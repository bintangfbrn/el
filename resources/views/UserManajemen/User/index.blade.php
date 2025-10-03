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
                    <h4 class="card-header">User Table</h4>
                    @can('create_user')
                        <div class="mb-0">
                            <a href="{{ route('akun.user.create') }}" class="btn btn-outline-primary me-2">
                                <span class="tf-icons bx bx-plus me-1"></span> Tambah
                            </a>
                        </div>
                    @endcan
                </div>
                <div class="card-datatable table-responsive">
                    <table class="dt-responsive table" id="user-table">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="8%">#</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Unit</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <section>
        <div class="modal fade" id="detailLogModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Detail Bank</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered mb-4">
                            <tr>
                                <th>Nama</th>
                                <td id="detail-nama"></td>
                            </tr>
                            <tr>
                                <th>Username</th>
                                <td id="detail-username"></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td id="detail-email"></td>
                            </tr>
                        </table>

                        <h6 class="fw-bold">Log Aktivitas</h6>
                        <ul class="timeline mt-3" id="timeline-user"></ul>
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
    @vite(['resources/js/UserManajemen/user/index.js'])
@endsection
