@extends('layouts.app')

@section('core-css')
@endsection

@section('vendor-css')
    {{-- Add SweetAlert CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection

@section('helper-js')
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render() }}
@endsection

@section('content')
    <form action="{{ route('about.Perusahaan.store') }}" method="POST" enctype="multipart/form-data" id="form_about_us"
        class="needs-validation form-prevent-multiple-submits" data-is-edit="{{ isset($about) ? 'true' : 'false' }}"
        novalidate>
        @csrf
        {{-- ===== Informasi Perusahaan ===== --}}
        <div class="card shadow mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">About The Company</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    {{-- Nama Perusahaan --}}
                    <div class="col-md-6 mb-3">
                        <label class="req">Company Name</label>
                        <input type="text" name="company_name" id="company_name" class="form-control"
                            value="{{ old('company_name', $about->company_name ?? '') }}" required>
                        @error('company_name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tagline --}}
                    <div class="col-md-6 mb-3">
                        <label>Tagline</label>
                        <input type="text" name="tagline" id="tagline" class="form-control"
                            value="{{ old('tagline', $about->tagline ?? '') }}">
                        @error('tagline')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="mb-3">
                    <label class="req">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description', $about->description ?? '') }}</textarea>
                    @error('description')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    {{-- Tahun Berdiri --}}
                    <div class="col-md-3 mb-3">
                        <label>Founded Year</label>
                        <input type="number" name="founded_year" id="founded_year" class="form-control" min="1800"
                            max="{{ date('Y') }}" value="{{ old('founded_year', $about->founded_year ?? '') }}">
                        @error('founded_year')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Telepon --}}
                    <div class="col-md-3 mb-3">
                        <label>Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control"
                            value="{{ old('phone', $about->phone ?? '') }}">
                        @error('phone')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="col-md-3 mb-3">
                        <label>Email</label>
                        <input type="email" name="email" id="email" class="form-control"
                            value="{{ old('email', $about->email ?? '') }}">
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Website --}}
                    <div class="col-md-3 mb-3">
                        <label>Website</label>
                        <input type="url" name="website" id="website" class="form-control"
                            value="{{ old('website', $about->website ?? '') }}">
                        @error('website')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Alamat --}}
                <div class="mb-3">
                    <label>Address</label>
                    <textarea name="address" id="address" class="form-control" rows="2">{{ old('address', $about->address ?? '') }}</textarea>
                    @error('address')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- ===== Gambar Perusahaan ===== --}}
        <div class="card shadow mb-4">
            <div class="card-header">
                <h5 class="card-title m-0 me-2">Company Image</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label>Upload Image (Max 2MB)</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                        @if (!empty($about->image))
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $about->image) }}" alt="Company Image"
                                    class="img-thumbnail" width="200">
                                <small class="text-muted d-block mt-1">Current Image</small>
                            </div>
                        @endif
                        @error('image')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label>Upload Image (Max 2MB)</label>
                        <input type="file" name="image_2" id="image_2" class="form-control" accept="image/*">
                        @if (!empty($about->image))
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $about->image_2) }}" alt="Company Image"
                                    class="img-thumbnail" width="200">
                                <small class="text-muted d-block mt-1">Current Image</small>
                            </div>
                        @endif
                        @error('image_2')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                {{-- Status --}}
                <div class="col-md-12 mb-3">
                    <label>Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="1" {{ old('status', $about->status ?? 1) == 1 ? 'selected' : '' }}>Active
                        </option>
                        <option value="0" {{ old('status', $about->status ?? 1) == 0 ? 'selected' : '' }}>Inactive
                        </option>
                    </select>
                    @error('status')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- ===== Tombol Simpan ===== --}}
        <div class="text-end mt-4">
            <button type="submit" class="btn btn-primary" id="submit-btn">
                {{ isset($about) ? 'Update Data' : 'Save Data' }}
            </button>
        </div>
    </form>
@endsection

@section('script')
    @vite(['resources/js/LandingPage/admin/AboutUs/Perusahaan/index.js'])
@endsection
