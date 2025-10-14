@extends('layouts.app')
@section('core-css')
@endsection
@section('vendor-css')
@endsection
@section('helper-js')
@endsection
@section('breadcrumbs')
    {{ Breadcrumbs::render() }}
@endsection
@section('content')
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Manajemen Desain Rumah</h5>
            @can('create_design')
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalDesign" id="btnAddDesign">
                    <i class="bx bx-plus"></i> Tambah Desain
                </button>
            @endcan
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="tableDesign" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Desain</th>
                            <th>Gaya</th>
                            <th>Estimasi Biaya</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- <x-modal-component id="tambahDesign" title="Tambah Design" action="{{ route('designer.store') }}"
        formId="tambahPermissionForm">
        @include('UserManajemen/permission/create')
    </x-modal-component> --}}
@endsection
@section('script')
    @vite(['resources/js/ProjectManajemen/Designer/index.js'])
@endsection
