<?php

namespace App\Http\Controllers\UserManajemen;

use App\Enums\GuardEnum;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\GeneralFunction;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    //
    public function index()
    {
        PermissionChecking(['view_role', 'create_role', 'edit_role', 'delete_role']);
        if (request()->ajax()) {
            $data = Role::with('permissions')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $url_edit   = route('akun.role.edit', encrypt($row->id));
                    $url_delete = route('akun.role.destroy', encrypt($row->id));
                    $action = '<div class="btn-group" role="group" aria-label="Basic example">';

                    // Check edit role
                    if (Auth::user()->can('edit_role')) {
                        $action .= '
                        <a href="' . $url_edit . '" class="btn btn-icon btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-warning" data-bs-original-title="Edit">
                            <span class="tf-icons bx bx-pencil"></span>
                        </a>';
                    }

                    //Check delete role
                    if (Auth::user()->can('delete_role')) {
                        $action .= '
                        <button href="javascript:void(0)" class="btn btn-icon btn-danger delete btn-delete" data-nama="' . $row->name . '" data-url="' . $url_delete . '" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-danger" data-bs-original-title="Hapus">
                            <span class="tf-icons bx bx-trash-alt"></span>
                        </button>';
                    }

                    if (Auth::user()->can('show_role')) {
                        $action .= '<button class="btn btn-icon btn-info btn-show" data-id="' . encrypt($row->id) . '" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-info" data-bs-original-title="Detail Role"><i class="bx bx-note"></i></button>';
                    }

                    $action .= '</div>';
                    return $action;
                })
                ->addColumn('name', function ($row) {
                    return $row->name;
                })
                ->addColumn('guard', function ($row) {
                    return $row->guard_name;
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at;
                })
                ->addColumn('updated_at', function ($row) {
                    return $row->updated_at;
                })
                ->rawColumns(['action', 'name', 'guard', 'permission', 'created_at', 'updated_at'])
                ->make(true);
        } else {
            $data = [
                'title' => 'Role Akun',
            ];
            return view('UserManajemen.role.index', $data);
        }
    }

    public function create()
    {
        PermissionChecking(['create_role']);
        $permissions = Permission::all()->groupBy(function ($item) {
            $segments = explode('_', $item->name);
            return end($segments);
        });
        $data       = [
            'permissions' => $permissions,
            'guard'       => GuardEnum::cases(),
            'title'       => 'Tambah Data Role',
        ];
        return view('UserManajemen.role.create', $data);
    }

    public function store(Request $request)
    {
        PermissionChecking(['create_role']);
        $request->validate([
            'name'          => 'required',
            'guard_name'    => 'required',
            'permissions'   => 'array',
        ]);

        try {
            $role = Role::create(['name' => $request->name]);
            log_status([
                'id_detail'             => $role->id,
                'model'                 => Role::class,
                'controller_function'   => 'RoleController@store',
                'deskripsi'             => 'Menambahkan Data Pada Menu Role',
            ]);
            if ($request->has('permissions')) {
                $role->syncPermissions($request->permissions);
            }
            GeneralFunction::toastr('success', 'Berhasil!', 'Data Role Berhasil Dimasukan!');
            return redirect()->route('akun.role.index');
        } catch (Exception $e) {
            Log::error("[RoleController@store] Gagal Memasukan Data Role : {$e->getMessage()}", [
                'request'       => request()->all(),
                'exception'     => [
                    'file'      => $e->getFile(),
                    'line'      => $e->getLine(),
                    'message'   => $e->getMessage(),
                ],
            ]);
            GeneralFunction::toastr('success', 'Berhasil!', 'Gagal Memasukan Data Role!');
            return redirect()->route('akun.role.index');
        }
    }

    public function edit($id)
    {
        PermissionChecking(['edit_role']);
        $id             = decrypt($id);
        $role           = Role::findOrFail($id);
        $permissions    = Permission::all()->groupBy(function ($item) {
            $segments   = explode('_', $item->name);
            return end($segments);
        });
        $data   = [
            'id'                => encrypt($id),
            'role'              => $role,
            'permissions'       => $permissions,
            'rolePermissions'   => $role->permissions?->pluck('name')->toArray(),
            'guard'             => GuardEnum::cases(),
            'title'             => 'Ubah Data Role',
        ];

        return view('UserManajemen.role.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'          => 'required',
            'guard_name'    => 'required',
            'permissions'   => 'array',
        ]);

        try {
            $id     = decrypt($id);
            $role   = Role::findOrFail($id);

            $role->name         = $request->name;
            $role->guard_name   = $request->guard_name;
            $role->save();

            if ($request->has('permissions')) {
                $role->syncPermissions($request->permissions);
            } else {
                $role->syncPermissions([]);
            }

            log_status([
                'id_detail'             => $role->id,
                'model'                 => Role::class,
                'controller_function'   => 'RoleController@update',
                'deskripsi'             => 'Mengubah Data Pada Menu Role',
            ]);

            GeneralFunction::toastr('success', 'Berhasil!', 'Data Role Berhasil Diubah!');
            return redirect()->route('akun.role.index');
        } catch (Exception $e) {
            Log::error("[RoleController@update] Gagal Mengubah Data Role : {$e->getMessage()}", [
                'request'       => request()->all(),
                'exception'     => [
                    'file'      => $e->getFile(),
                    'line'      => $e->getLine(),
                    'message'   => $e->getMessage(),
                ],
            ]);
            GeneralFunction::toastr('success', 'Berhasil!', 'Gagal Mengubah Data Role!');
            return redirect()->route('akun.role.index');
        }
    }

    public function destroy($id)
    {
        PermissionChecking(['delete_role']);
        try {
            $id     = decrypt($id);
            $role   = Role::findOrFail($id);
            $role->syncPermissions([]);
            $role->delete();

            log_status([
                'id_detail'             => $role->id,
                'model'                 => Role::class,
                'controller_function'   => 'RoleController@destroy',
                'deskripsi'             => 'Menghapus Data Pada Menu Role',
            ]);

            return response()->json(['message' => 'Berhasil Menghapus Data!', 'status' => 'success']);
        } catch (Exception $e) {
            Log::error("[RoleController@destroy] Gagal Menghapus Data Role : {$e->getMessage()}", [
                'request'       => request()->all(),
                'exception'     => [
                    'file'      => $e->getFile(),
                    'line'      => $e->getLine(),
                    'message'   => $e->getMessage(),
                ],
            ]);
            return response()->json(['message' => 'Gagal Menghapus Data!', 'status' => 'error']);
        }
    }

    public function show($id)
    {
        $id = decrypt($id);
        $data = Role::with('logs.flag')->find($id);
        return response()->json($data);
    }
}
