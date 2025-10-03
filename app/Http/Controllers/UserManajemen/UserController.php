<?php

namespace App\Http\Controllers\UserManajemen;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\GeneralFunction;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    //
    public function index()
    {
        PermissionChecking(['view_user']);
        if (request()->ajax()) {
            $data = User::with('roles')->orderBy('id', 'desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $url_edit = route('akun.user.edit', encrypt($row->id));
                    $url_delete = route('akun.user.destroy', encrypt($row->id));
                    $action = '<div class="btn-group" role="group">';

                    if (Auth::user()->can('edit_user')) {
                        $action .= '<a href="' . $url_edit . '" class="btn btn-icon btn-warning" data-bs-toggle="tooltip" title="Edit">
                    <span class="tf-icons bx bx-pencil"></span>
                </a>';
                    }

                    if (Auth::user()->can('delete_user')) {
                        $action .= '<button href="javascript:void(0)" class="btn btn-icon btn-danger btn-delete" data-nama="' . $row->name . '" data-url="' . $url_delete . '" data-bs-toggle="tooltip" title="Hapus">
                    <span class="tf-icons bx bx-trash-alt"></span>
                </button>';
                    }

                    if (Auth::user()->can('show_user')) {
                        $action .= '<button class="btn btn-icon btn-info btn-show" data-id="' . encrypt($row->id) . '" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-info" title="Detail User">
                    <i class="bx bx-note"></i>
                </button>';
                    }

                    $action .= '</div>';
                    return $action;
                })
                ->addColumn('name', function ($row) {
                    return $row->name;
                })
                ->addColumn('username', function ($row) {
                    return $row->username;
                })
                ->addColumn('email', function ($row) {
                    return $row->email;
                })
                ->addColumn('role', function ($row) {
                    return $row->roles[0]?->name ?? '';
                })
                ->addColumn('unit', function ($row) {
                    return $row->unit?->singkatan ?? '-';
                })
                ->rawColumns(['action', 'name', 'username', 'email', 'role', 'unit'])
                ->make(true);
        } else {
            return view('UserManajemen.user.index');
        }
    }

    public function create()
    {
        PermissionChecking(['create_user']);
        $data = [
            'roles' => Role::all(),
            'unit' => Unit::get(),
        ];

        return view('UserManajemen.user.create', $data);
    }

    public function store(Request $request)
    {
        PermissionChecking(['create_user']);
        try {
            $request->validate([
                'name' => 'required',
                'username' => 'required|unique:users,username',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'roles' => 'required'
            ]);

            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'id_unit' => $request->unit
            ])->assignRole($request->roles);

            log_status([
                'id_detail' => $user->id,
                'model' => User::class,
                'controller_function' => 'UserController@store',
                'deskripsi' => 'Menambah Data Pada Menu User',
            ]);

            GeneralFunction::toastr('success', 'Berhasil!', 'Data User Berhasil Dimasukan!');
            return redirect()->route('akun.user.index');
        } catch (Exception $e) {
            Log::error("[UserController@store] Gagal Memasukan Data User : {$e->getMessage()}", [
                'request' => request()->all(),
                'exception' => [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'message' => $e->getMessage(),
                ],
            ]);
            GeneralFunction::toastr('error', 'Gagal!', 'Gagal Memasukan Data User!');
            return redirect()->route('akun.user.index');
        }
    }

    public function edit($id)
    {
        PermissionChecking(['edit_user']);
        $id = decrypt($id);
        $user = User::find($id);
        $data = [
            'id' => encrypt($id),
            'user' => $user,
            'roles' => Role::all(),
            'userRoles' => $user->roles->pluck('name')->toArray(),
            'unit' => Unit::get(),
        ];

        return view('UserManajemen.user.edit', $data);
    }

    public function update(Request $request, $id)
    {
        PermissionChecking(['edit_user']);
        try {
            $id = decrypt($id);
            $request->validate([
                'name' => 'required',
                'username' => 'required|unique:users,username,' . $id,
                'email' => 'required|email|unique:users,email,' . $id,
                'roles' => 'required'
            ]);

            $user = User::find($id);
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->id_unit = $request->unit;
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
            $user->syncRoles($request->roles);

            log_status([
                'id_detail' => $user->id,
                'model' => User::class,
                'controller_function' => 'UserController@update',
                'deskripsi' => 'Mengubahn Data Pada Menu User',
            ]);

            GeneralFunction::toastr('success', 'Berhasil!', 'Data User Berhasil Diubah!');
            return redirect()->route('akun.user.index');
        } catch (Exception $e) {
            Log::error("[UserController@update] Gagal Mengubah Data User : {$e->getMessage()}", [
                'request' => request()->all(),
                'exception' => [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'message' => $e->getMessage(),
                ],
            ]);
            GeneralFunction::toastr('error', 'Gagal!', 'Gagal Mengubah Data User!');
            return redirect()->route('akun.user.index');
        }
    }

    public function destroy($id)
    {
        PermissionChecking(['delete_user']);
        try {
            $id = decrypt($id);
            $user = User::findOrFail($id);
            $user->syncRoles([]);
            $user->delete();

            log_status([
                'id_detail' => $user->id,
                'model' => User::class,
                'controller_function' => 'UserController@destroy',
                'deskripsi' => 'Menghapus Data Pada Menu User',
            ]);

            return response()->json(['message' => 'Berhasil Menghapus Data!', 'status' => 'success']);
        } catch (Exception $e) {
            Log::error("[UserController@destroy] Gagal Menghapus Data User : {$e->getMessage()}", [
                'request' => request()->all(),
                'exception' => [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'message' => $e->getMessage(),
                ],
            ]);
            return response()->json(['message' => 'Gagal Menghapus Data!', 'status' => 'error']);
        }
    }

    public function show($id)
    {
        $id = decrypt($id);
        $data = User::with('logs.flag')->find($id);
        return response()->json($data);
    }
}