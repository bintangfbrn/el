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
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <a href="{{ route('akun.role.index') }}"
                    class="btn btn-icon btn-primary waves-effect waves-float waves-light">
                    <i class='bx bx-chevron-left fs-3'></i>
                </a>
                <h4 class="card-title mb-0 p-2">Create Role</h4>
            </div>
        </div>
        <form class="card-body" action="{{ route('akun.role.store') }}" method="POST">
            @csrf
            <h6 class="fw-normal">1. Role Details</h6>
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label" for="name">Name <small class="text-danger">*</small></label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Ex. Superadmin"
                        required>
                </div>
                <div class="col-md-12">
                    <label for="guardName" class="form-label">Guard Name <small class="text-danger">*</small></label>
                    <select id="guardName" name="guard_name" class="select2 form-select form-select-lg"
                        data-allow-clear="true" data-placeholder="-Pilih Guard Name-" required>
                        <option></option>
                        @foreach ($guard as $gd)
                            <option value="{{ $gd->value }}">{{ strtolower($gd->name) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <hr class="my-4 mx-n4">
            <h6 class="fw-normal">2. Permissions Details</h6>
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label" for="permissions">Permissions <small class="text-danger">*</small></label>
                    <div class="card-datatable table-responsive">
                        <table class="dt-responsive table" id="role-table">
                            <thead>
                                <tr>
                                    <th>Data Master</th>
                                    <th>
                                        <input type="checkbox" class="form-check-input" id="selectAllCheckBox" /> Selected
                                        All
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $item => $val)
                                    <tr>
                                        <td>
                                            <h6>{{ strtoupper($item) }}</h6>
                                        </td>
                                        <td>
                                            @foreach ($val as $permission)
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input checkbox-item"
                                                        name="permissions[]" value="{{ $permission->name }}" />
                                                    <label class="form-check-label">{{ $permission->name }}</label>
                                                </div>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="pt-4 float-end">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection
