<?php

namespace App\Http\Controllers\UserManajemen;

use App\Enums\GuardEnum;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use App\Traits\GeneralFunction;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    //

    public function index()
    {

        PermissionChecking(['view_permission', 'create_permission', 'edit_permission', 'delete_permission']);
        if (request()->ajax()) {
            $data = Permission::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $url_delete = route('akun.permission.destroy', encrypt($row->id));
                    $action = '<div class="btn-group" role="group" aria-label="Basic example">';

                    // Check edit permission
                    if (Auth::user()->can('edit_permission')) {

                        $action .= ' <button class="btn btn-icon btn-warning editPermission" data-id="' . encrypt($row->id) . '" data-nama="' . $row->name . '" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-warning" data-bs-original-title="Edit"><span class="tf-icons bx bx-pencil"></span>
                        </button>';
                    }

                    //Check delete permission
                    if (Auth::user()->can('delete_permission')) {
                        $action .= '
                        <button href="javascript:void(0)" class="btn btn-icon btn-danger delete btn-delete" data-nama="' . $row->name . '" data-url="' . $url_delete . '" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-danger" data-bs-original-title="Hapus">
                            <span class="tf-icons bx bx-trash-alt"></span>
                        </button>';
                    }

                    if (Auth::user()->can('show_permission')) {
                        $action .= '<button class="btn btn-icon btn-info btn-show" data-id="' . encrypt($row->id) . '" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-info" data-bs-original-title="Detail Permission"><i class="bx bx-note"></i></button>';
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
                ->rawColumns(['action', 'name', 'guard', 'created_at', 'updated_at'])
                ->make(true);
        } else {
            $data = [
                'guard' => GuardEnum::cases(),
            ];
            return view('UserManajemen.Permission.index', $data);
        }
    }

    public function store(Request $request)
    {
        PermissionChecking(['create_permission']);
        $request->validate([
            'name'          => ['required'],
            'guard_name'    => ['required'],
        ]);

        try {
            $permission = Permission::create([
                'name'          => $request->name,
                'guard_name'    => $request->guard_name
            ]);
            log_status([
                'id_detail'             => $permission->id,
                'model'                 => Permission::class,
                'controller_function'   => 'PermissionController@store',
                'deskripsi'             => 'Menambah Data Permission',
            ]);
            GeneralFunction::toastr('success', 'Berhasil!', 'Data Permission Berhasil Dimasukan!');
            return redirect()->route('akun.permission.index');
        } catch (Exception $e) {
            Log::error("[PermissionController@store] Gagal Memasukan Data Permission : {$e->getMessage()}", [
                'request'       => request()->all(),
                'exception'     => [
                    'file'      => $e->getFile(),
                    'line'      => $e->getLine(),
                    'message'   => $e->getMessage(),
                ],
            ]);
            GeneralFunction::toastr('error', 'Gagal!', 'Gagal Memasukan Data Permission!');
            return redirect()->route('akun.permission.index');
        }
    }

    public function edit($id)
    {
        PermissionChecking(['edit_permission']);
        $id     = decrypt($id);
        $data   = [
            'data'  => Permission::find($id),
            'id'    => encrypt($id),
            'guard' => GuardEnum::cases()
        ];

        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'          => ['required'],
            'guard_name'    => ['required'],
        ]);

        try {
            $id     = decrypt($id);
            $data   = Permission::find($id);
            $data->update([
                'name'          => $request->name,
                'guard_name'    => $request->guard_name
            ]);
            log_status([
                'id_detail'             => $data->id,
                'model'                 => Permission::class,
                'controller_function'   => 'PermissionController@update',
                'deskripsi'             => 'Mengubah Data Permission',
            ]);
            GeneralFunction::toastr('success', 'Berhasil!', 'Data Permission Berhasil Diubah!');
            return redirect()->route('akun.permission.index');
        } catch (Exception $e) {
            Log::error("[PermissionController@update] Gagal Mengubah Data Permission : {$e->getMessage()}", [
                'request'       => request()->all(),
                'exception'     => [
                    'file'      => $e->getFile(),
                    'line'      => $e->getLine(),
                    'message'   => $e->getMessage(),
                ],
            ]);
            GeneralFunction::toastr('error', 'Gagal!', 'Gagal Mengubah Data Permission!');
            return redirect()->route('akun.permission.index');
        }
    }

    public function destroy($id)
    {
        PermissionChecking(['delete_permission']);
        try {
            $id     = decrypt($id);
            $delete = Permission::find($id)->delete();
            log_status([
                'id_detail'             => $id,
                'model'                 => Permission::class,
                'controller_function'   => 'PermissionController@destroy',
                'deskripsi'             => 'Menghapus Data Permission',
            ]);
            return response()->json(['message' => 'Berhasil Menghapus Data!', 'status' => 'success']);
        } catch (Exception $e) {
            Log::error("[PermissionController@destroy] Gagal Menghapus Data Permission : {$e->getMessage()}", [
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
        $data = Permission::with('logs.flag')->find($id);
        return response()->json($data);
    }
}
