{{-- @extends('layouts.app')
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
                <a href="{{ route('akun.permission.index') }}"
                    class="btn btn-icon btn-primary waves-effect waves-float waves-light">
                    <i class='bx bx-chevron-left fs-3'></i>
                </a>
                <h4 class="card-title mb-0 p-2">Edit Permission</h4>
            </div>
        </div>
        <form class="card-body" action="{{ route('akun.permission.update', $id) }}" method="POST">
            @csrf
            @method('PUT')
            <h6 class="fw-normal">1. Permission Details</h6>
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label" for="name">Name <small class="text-danger">*</small></label>
                    <input type="text" id="name" name="name" value="{{ $data->name }}" class="form-control" placeholder="Ex. View_Permission" required>
                </div>
                <div class="col-md-12">
                    <label for="guardName" class="form-label">Guard Name <small class="text-danger">*</small></label>
                    <select id="guardName" name="guard_name" class="select2 form-select form-select-lg" data-allow-clear="true" data-placeholder="-Pilih Guard Name-" required>
                        <option></option>
                        @foreach ($guard as $gd)
                            <option value="{{ $gd->value }}" @if ($gd->value == $data->guard_name) selected @endif>{{ strtolower($gd->name) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="pt-4 float-end">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection --}}
@method('PUT')
<div class="modal-body">
    <div class="row g-2">
        <div class="col-md-12">
            <label class="form-label" for="name">Name <small class="text-danger">*</small></label>
            <input type="text" id="namePermission" name="name" class="form-control" placeholder="Ex. View_Permission"
                required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-12">
            <label for="guardId" class="form-label">Guard Name <small class="text-danger">*</small></label>
            <select id="guardId" name="guard_name" class="select2 form-select form-select-lg" data-allow-clear="true"
                data-placeholder="-Pilih Guard Name-" required>
            </select>
            @error('guard_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
