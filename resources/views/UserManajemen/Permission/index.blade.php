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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="d-flex justify-content-between align-items-center px-2 py-2">
                    <h4 class="card-header">Permission Table</h4>
                    @can('create_permission')
                        <div class="mb-0">
                            <a href="javascript:void(0)" class="btn btn-outline-primary me-2" data-bs-toggle="modal"
                                data-bs-target="#tambahPermissionModal">
                                <span class="tf-icons bx bx-plus me-1"></span> Tambah
                            </a>
                        </div>
                    @endcan
                </div>
                <div class="card-datatable table-responsive">
                    <table class="dt-responsive table" id="permission-table">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="8%">#</th>
                                <th>Name</th>
                                <th>Guard</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <x-modal-component id="tambahPermissionModal" title="Tambah Permission" action="{{ route('akun.permission.store') }}"
        formId="tambahPermissionForm">
        @include('UserManajemen/permission/create')
    </x-modal-component>

    <x-modal-component id="editPermissionModal" title="Edit Permission" formId="editPermissionForm">
        @include('UserManajemen/permission/edit')
    </x-modal-component>
    <section>
        <div class="modal fade" id="detailLogModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Detail Permission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered mb-4">
                            <tr>
                                <th>Nama</th>
                                <td id="detail-nama"></td>
                            </tr>
                            <tr>
                                <th>Guard</th>
                                <td id="detail-gn"></td>
                            </tr>
                        </table>

                        <h6 class="fw-bold">Log Aktivitas</h6>
                        <ul class="timeline mt-3" id="timeline-permission"></ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    @vite(['resources/js/UserManajemen/Permission/index.js'])
@endsection
