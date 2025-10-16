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
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Tambah Artikel / Service Baru</h5>
                </div>

                <div class="card-body from-prevent-multiple-submits">
                    <form action="{{ route('store-services-items') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <!-- Judul -->
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="req">Judul</label>
                                    <input type="text" name="title" class="form-control mt-2"
                                        placeholder="Masukkan judul artikel" required>
                                </div>
                            </div>

                            <!-- Deskripsi Singkat -->
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label>Deskripsi Singkat</label>
                                    <textarea name="short_description" class="form-control mt-2" rows="2" placeholder="Deskripsi singkat (opsional)"></textarea>
                                </div>
                            </div>

                            <!-- Deskripsi Lengkap -->
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="req">Deskripsi Lengkap</label>
                                    <textarea name="description" id="description" class="form-control mt-2" rows="6"
                                        placeholder="Tulis isi artikel..." required></textarea>
                                </div>
                            </div>

                            <!-- Gambar Utama -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Gambar Utama</label>
                                    <input type="file" name="image" class="form-control mt-2" accept="image/*">
                                    <small class="text-muted">Format: jpg, png, jpeg. Maks 5MB.</small>
                                </div>
                            </div>

                            <!-- Gambar Tambahan -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Gambar Tambahan</label>
                                    <input type="file" name="image_2" class="form-control mt-2" accept="image/*">
                                    <small class="text-muted">Opsional</small>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Status</label>
                                    <select name="status" class="select2 form-select form-select-lg">
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Pin Artikel -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Pin Artikel</label>
                                    <select name="pin" class="select2 form-select form-select-lg">
                                        <option value="0">Reguler</option>
                                        <option value="1">Pinned</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="card-footer text-end">
                            <a href="{{ route('services-items') }}" class="btn btn-outline-danger">Batal</a>
                            <button type="submit" class="btn btn-primary from-prevent-multiple-submits">Simpan</button>
                            <button class="btn btn-primary" id="btn_loading" type="button" disabled hidden>
                                <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                                Loading...
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite(['resources/js/LandingPage/admin/services-items/create.js'])
@endpush
