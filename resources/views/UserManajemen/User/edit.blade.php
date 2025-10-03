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
                <a href="{{ route('akun.user.index') }}"
                    class="btn btn-icon btn-primary waves-effect waves-float waves-light">
                    <i class='bx bx-chevron-left fs-3'></i>
                </a>
                <h4 class="card-title mb-0 p-2">Edit User</h4>
            </div>
        </div>
        <form class="card-body" action="{{ route('akun.user.update', $id) }}" method="POST">
            @csrf
            @method('PUT')
            <h6 class="fw-normal">1. User Details</h6>
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label" for="name">Name <small class="text-danger">*</small></label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Ex. John Doe"
                        value="{{ $user->name }}" required>
                </div>
                <div class="col-md-12">
                    <label for="username" class="form-label">Username <small class="text-danger">*</small></label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Ex. johndoe2530"
                        value="{{ $user->username }}" required>
                </div>
                <div class="col-md-12">
                    <label class="form-label" for="email">Email <small class="text-danger">*</small></label>
                    <input type="email" id="email" name="email" class="form-control"
                        placeholder="Ex. johndoe@example.com" value="{{ $user->email }}" required>
                </div>
                <div class="col-md-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <label class="form-label" for="password">Password</label>
                        <small class="text-danger">Isikan jika anda ingin menggantikan password</small>
                    </div>
                    <input type="password" id="password" name="password" class="form-control"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;">
                </div>
            </div>
            <hr class="my-4 mx-n4">
            <h6 class="fw-normal">2. Role Details</h6>
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label" for="role">Role <small class="text-danger">*</small></label>
                    <div class="row mt-2">
                        @foreach ($roles as $item)
                            <div class="col-md-4 mb-2">
                                <label class="switch switch-primary">
                                    <input type="checkbox" class="switch-input" name="roles[]" value="{{ $item->name }}"
                                        {{ in_array($item->name, $userRoles) ? 'checked' : '' }}>
                                    <span class="switch-toggle-slider">
                                        <span class="switch-on">
                                            <i class="bx bx-check"></i>
                                        </span>
                                        <span class="switch-off">
                                            <i class="bx bx-x"></i>
                                        </span>
                                    </span>
                                    <span class="switch-label">{{ $item->name }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-12 @if (empty($user->id_unit)) d-none @endif" id="unit-section">
                    <label class="form-label" for="unit">Unit <small class="text-danger">*</small></label>
                    <select class="select2 form-select" id="unit" name="unit">
                        <option value="">Select Unit</option>
                        @foreach ($unit as $item)
                            <option value="{{ $item->id }}" @if ($item->id == $user->id_unit) selected @endif>
                                {{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="pt-4 float-end">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection
@section('script')
    @vite(['resources/js/user_manajemen/user/create.js'])
@endsection
