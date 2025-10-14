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
    {{-- SweetAlert Notifications --}}
    @if (session('swal'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: '{{ session('swal.icon') }}',
                    title: '{{ session('swal.title') }}',
                    text: '{{ session('swal.text') }}',
                    confirmButtonText: '{{ session('swal.confirmButtonText', 'OK') }}',
                    confirmButtonColor: '#3085d6'
                });
            });
        </script>
    @endif

    <form action="{{ route('service.store') }}" method="POST" enctype="multipart/form-data" id="form_service_highlight"
        class="needs-validation form-prevent-multiple-submits" novalidate>
        @csrf

        {{-- Hidden field untuk ID jika edit --}}
        @if (isset($highlight))
            <input type="hidden" name="id" value="{{ $highlight->id }}">
        @endif

        {{-- Your existing form content remains the same --}}
        {{-- ===== Service Highlight Section ===== --}}
        <div class="card shadow mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Service Highlight</h5>
            </div>

            <div class="card-body">
                {{-- ===== Title & Sub Title ===== --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="req">Title</label>
                            <input id="title" type="text" name="title" class="form-control form-control-md mt-2"
                                value="{{ old('title', $highlight->title ?? '') }}" required>
                            @error('title')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="req">Sub Title</label>
                            <input id="sub_title" type="text" name="sub_title" class="form-control form-control-md mt-2"
                                value="{{ old('sub_title', $highlight->subtitle ?? '') }}" required>
                            @error('sub_title')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- ===== Deskripsi ===== --}}
                <div class="mb-3">
                    <label class="req">Deskripsi</label>
                    <textarea name="description" id="description" class="form-control mt-2" rows="3" required>{{ old('description', $highlight->description ?? '') }}</textarea>
                    @error('description')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- ===== Service Feature Section ===== --}}
        <div class="card shadow mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Service Feature</h5>
                <button type="button" id="add-feature" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Add Feature
                </button>
            </div>

            <div class="card-body">
                <div id="features-container">
                    @php
                        $features = old(
                            'features',
                            isset($highlight) && $highlight->features->count() > 0
                                ? $highlight->features->toArray()
                                : [['icon' => '', 'title' => '', 'description' => '']],
                        );
                    @endphp

                    @foreach ($features as $index => $feature)
                        <div class="card mb-3 feature-item">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">Feature {{ $loop->iteration }}</h6>
                                    @if ($loop->first && count($features) === 1)
                                        <span class="text-muted small">Minimal 1 feature</span>
                                    @else
                                        <button type="button" class="btn btn-outline-danger btn-sm remove-feature">
                                            Remove
                                        </button>
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Icon (path / URL)</label>
                                        <input type="text" name="features[{{ $index }}][icon]"
                                            class="form-control" value="{{ $feature['icon'] ?? '' }}">
                                        @error("features.{$index}.icon")
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="req">Title</label>
                                        <input type="text" name="features[{{ $index }}][title]"
                                            class="form-control" value="{{ $feature['title'] ?? '' }}" required>
                                        @error("features.{$index}.title")
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label>Description</label>
                                        <textarea name="features[{{ $index }}][description]" class="form-control" rows="2">{{ $feature['description'] ?? '' }}</textarea>
                                        @error("features.{$index}.description")
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ===== Upload Images Section ===== --}}
        {{-- Your existing images section remains the same --}}
        <div class="card shadow mb-4">
            <div class="card-header">
                <h5 class="card-title m-0 me-2">Upload Images</h5>
            </div>

            <div class="card-body">
                <div class="row">
                    <!-- Image 1 -->
                    <div class="col-md-3 mb-3">
                        <label for="images_1" class="req">Image 1</label>
                        <input type="file" name="images[]" id="images_1" class="form-control"
                            accept="image/*,application/pdf">

                        @if (isset($images[0]))
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $images[0]->image_path) }}" alt="Image 1"
                                    class="img-thumbnail" style="width: 100%; height: 150px; object-fit: cover;">
                                <small class="text-muted d-block">Current Image</small>
                            </div>
                        @endif
                    </div>

                    <!-- Image 2 -->
                    <div class="col-md-3 mb-3">
                        <label for="images_2" class="req">Image 2</label>
                        <input type="file" name="images[]" id="images_2" class="form-control"
                            accept="image/*,application/pdf">

                        @if (isset($images[1]))
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $images[1]->image_path) }}" alt="Image 2"
                                    class="img-thumbnail" style="width: 100%; height: 150px; object-fit: cover;">
                                <small class="text-muted d-block">Current Image</small>
                            </div>
                        @endif
                    </div>

                    <!-- Image 3 -->
                    <div class="col-md-3 mb-3">
                        <label for="images_3" class="req">Image 3</label>
                        <input type="file" name="images[]" id="images_3" class="form-control"
                            accept="image/*,application/pdf">

                        @if (isset($images[2]))
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $images[2]->image_path) }}" alt="Image 3"
                                    class="img-thumbnail" style="width: 100%; height: 150px; object-fit: cover;">
                                <small class="text-muted d-block">Current Image</small>
                            </div>
                        @endif
                    </div>

                    <!-- Image 4 -->
                    <div class="col-md-3 mb-3">
                        <label for="images_4" class="req">Image 4</label>
                        <input type="file" name="images[]" id="images_4" class="form-control"
                            accept="image/*,application/pdf">

                        @if (isset($images[3]))
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $images[3]->image_path) }}" alt="Image 4"
                                    class="img-thumbnail" style="width: 100%; height: 150px; object-fit: cover;">
                                <small class="text-muted d-block">Current Image</small>
                            </div>
                        @endif
                    </div>
                </div>

                <small class="text-muted d-block">Upload hingga 4 file (bisa gambar atau PDF). Maksimal 5MB per
                    file.</small>
            </div>
        </div>

        <div class="text-end mt-4">
            <button type="submit" class="btn btn-primary" id="submit-btn">
                {{ isset($highlight) ? 'Update Data' : 'Save Data' }}
            </button>
        </div>
    </form>
@endsection

@section('script')
    {{-- Add SweetAlert JS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    {{-- Optional: Add confirmation on form submit --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('form_service_highlight');
            const submitBtn = document.getElementById('submit-btn');

            if (submitBtn) {
                submitBtn.addEventListener('click', function(e) {
                    e.preventDefault();

                    const isEdit = {{ isset($highlight) ? 'true' : 'false' }};
                    const title = isEdit ? 'Update Data?' : 'Save Data?';
                    const text = isEdit ?
                        'Are you sure you want to update this service highlight?' :
                        'Are you sure you want to save this service highlight?';

                    Swal.fire({
                        title: title,
                        text: text,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, ' + (isEdit ? 'Update' : 'Save') + ' it!',
                        cancelButtonText: 'No, cancel!',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            }
        });
    </script>

    @vite(['resources/js/landingpage/admin/services/services-highlight.js'])
@endsection
