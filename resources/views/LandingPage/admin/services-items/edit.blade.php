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
                    <h5 class="card-title m-0 me-2">Edit Artikel / Service Item</h5>
                </div>

                <form action="{{ route('updated_services_items', encrypt($service->id)) }}" method="POST"
                    enctype="multipart/form-data" class="from-prevent-multiple-submits">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <div class="row">
                            {{-- Judul --}}
                            <div class="col-md-12 mb-3">
                                <label class="req">Judul</label>
                                <input type="text" name="title" id="title"
                                    class="form-control form-control-md mt-2" value="{{ old('title', $service->title) }}"
                                    required>
                            </div>

                            {{-- Deskripsi Singkat --}}
                            <div class="col-md-12 mb-3">
                                <label>Deskripsi Singkat</label>
                                <textarea name="short_description" id="short_description" class="form-control mt-2" rows="3">{{ old('short_description', $service->short_description) }}</textarea>
                            </div>

                            {{-- Deskripsi Lengkap --}}
                            <div class="col-md-12 mb-3">
                                <label>Deskripsi Lengkap</label>
                                <textarea name="description" id="description" class="form-control mt-2" rows="6">{{ old('description', $service->description) }}</textarea>
                            </div>

                            {{-- Status --}}
                            <div class="col-md-6 mb-3">
                                <label>Status</label>
                                <select name="status" id="status" class="form-select mt-2">
                                    <option value="1" {{ $service->status == 1 ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ $service->status == 0 ? 'selected' : '' }}>Tidak Aktif
                                    </option>
                                </select>
                            </div>

                            {{-- Pin --}}
                            <div class="col-md-6 mb-3">
                                <label>Pin</label>
                                <select name="pin" id="pin" class="form-select mt-2">
                                    <option value="0" {{ $service->pin == '0' ? 'selected' : '' }}>Reguler</option>
                                    <option value="1" {{ $service->pin == '1' ? 'selected' : '' }}>Pinned</option>
                                </select>
                            </div>

                            {{-- Gambar --}}
                            <div class="col-md-6 mb-3">
                                <label>Gambar Utama</label>
                                <input type="file" name="image" class="form-control mt-2" accept="image/*">
                                @if ($service->image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $service->image) }}" alt="Image"
                                            class="img-thumbnail" width="200">
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Gambar Kedua (Opsional)</label>
                                <input type="file" name="image_2" class="form-control mt-2" accept="image/*">
                                @if ($service->image_2)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $service->image_2) }}" alt="Image 2"
                                            class="img-thumbnail" width="200">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-end">
                        <a href="{{ route('services-items') }}" class="btn btn-outline-danger">Batal</a>

                        <button type="submit" class="btn btn-primary from-prevent-multiple-submits">Simpan</button>


                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite(['resources/js/LandingPage/admin/services-items/edit.js'])
@endpush
