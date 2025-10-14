<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Design;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\GeneralFunction;
use Illuminate\Support\Facades\Auth;

class DesignController extends Controller
{
    public function index()
    {
        PermissionChecking(['view_design', 'create_design', 'edit_design', 'delete_design']);
        if (request()->ajax()) {
            $data = Design::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $url_delete = route('design.destroy', encrypt($row->id));
                    $action = '<div class="btn-group" role="group" aria-label="Basic example">';

                    if (Auth::user()->can('edit_design')) {
                        $action .= '<button class="btn btn-icon btn-warning editDesign" 
                            data-id="' . encrypt($row->id) . '" 
                            data-nama="' . e($row->name) . '"
                            data-deskripsi="' . e($row->description) . '"
                            data-estimasi="' . e($row->estimated_cost) . '"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                            <span class="tf-icons bx bx-pencil"></span></button>';
                    }

                    if (Auth::user()->can('delete_design')) {
                        $action .= '<button class="btn btn-icon btn-danger btn-delete" 
                            data-nama="' . e($row->name) . '" 
                            data-url="' . $url_delete . '" 
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
                            <span class="tf-icons bx bx-trash-alt"></span></button>';
                    }

                    if (Auth::user()->can('show_design')) {
                        $action .= '<button class="btn btn-icon btn-info btn-show" 
                            data-id="' . encrypt($row->id) . '"
                            data-bs-toggle="tooltip" title="Detail">
                            <i class="bx bx-note"></i></button>';
                    }

                    $action .= '</div>';
                    return $action;
                })
                ->addColumn('name', fn($row) => $row->name)
                ->addColumn('style', fn($row) => $row->style)
                ->addColumn('estimated_cost', fn($row) => number_format($row->estimated_cost))
                ->rawColumns(['action', 'name', 'style', 'estimated_cost'])
                ->make(true);
        }

        return view('ProjectManajemen.Designer.index');
    }

    public function store(Request $request)
    {
        PermissionChecking(['create_design']);
        $request->validate([
            'name' => ['required'],
            'style' => ['nullable'],
            'estimated_cost' => ['nullable', 'integer'],
            'description' => ['nullable'],
        ]);

        try {
            $design = Design::create($request->only(['name', 'style', 'estimated_cost', 'description']));
            log_status([
                'id_detail' => $design->id,
                'model' => Design::class,
                'controller_function' => 'DesignController@store',
                'deskripsi' => 'Menambah Data Desain Rumah',
            ]);

            GeneralFunction::toastr('success', 'Berhasil!', 'Data Desain Berhasil Ditambahkan!');
            return redirect()->route('design.index');
        } catch (Exception $e) {
            Log::error("[DesignController@store] Gagal: {$e->getMessage()}", [
                'request' => $request->all(),
                'exception' => $e,
            ]);
            GeneralFunction::toastr('error', 'Gagal!', 'Tidak Dapat Menambahkan Desain!');
            return redirect()->route('design.index');
        }
    }

    public function edit($id)
    {
        PermissionChecking(['edit_design']);
        $id = decrypt($id);
        $data = Design::findOrFail($id);
        return response()->json([
            'data' => $data,
            'id' => encrypt($id),
        ]);
    }

    public function update(Request $request, $id)
    {
        PermissionChecking(['edit_design']);
        $request->validate([
            'name' => ['required'],
            'style' => ['nullable'],
            'estimated_cost' => ['nullable', 'integer'],
            'description' => ['nullable'],
        ]);

        try {
            $id = decrypt($id);
            $design = Design::findOrFail($id);
            $design->update($request->only(['name', 'style', 'estimated_cost', 'description']));

            log_status([
                'id_detail' => $design->id,
                'model' => Design::class,
                'controller_function' => 'DesignController@update',
                'deskripsi' => 'Mengubah Data Desain Rumah',
            ]);

            GeneralFunction::toastr('success', 'Berhasil!', 'Data Desain Berhasil Diubah!');
            return redirect()->route('design.index');
        } catch (Exception $e) {
            Log::error("[DesignController@update] Gagal: {$e->getMessage()}", [
                'request' => $request->all(),
                'exception' => $e,
            ]);
            GeneralFunction::toastr('error', 'Gagal!', 'Tidak Dapat Mengubah Desain!');
            return redirect()->route('design.index');
        }
    }

    public function destroy($id)
    {
        PermissionChecking(['delete_design']);
        try {
            $id = decrypt($id);
            Design::findOrFail($id)->delete();
            log_status([
                'id_detail' => $id,
                'model' => Design::class,
                'controller_function' => 'DesignController@destroy',
                'deskripsi' => 'Menghapus Data Desain Rumah',
            ]);
            return response()->json(['message' => 'Berhasil Menghapus Data!', 'status' => 'success']);
        } catch (Exception $e) {
            Log::error("[DesignController@destroy] Error: {$e->getMessage()}");
            return response()->json(['message' => 'Gagal Menghapus Data!', 'status' => 'error']);
        }
    }

    public function show($id)
    {
        $id = decrypt($id);
        $data = Design::with('logs.flag')->findOrFail($id);
        return response()->json($data);
    }
}
