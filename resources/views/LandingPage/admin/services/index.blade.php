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
    <form action="{{ route('service.store') }}" method="POST" enctype="multipart/form-data" id="form_service_highlight"
        class="needs-validation form-prevent-multiple-submits" novalidate>
        @csrf

        {{-- Hidden field untuk ID jika edit --}}
        @if (isset($highlight))
            <input type="hidden" name="id" value="{{ $highlight->id }}">
        @endif

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
                                value="{{ old('sub_title', $highlight->sub_title ?? '') }}" required>
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
        <div class="card shadow mb-4">
            <div class="card-header">
                <h5 class="card-title m-0 me-2">Upload Images</h5>
            </div>

            <div class="card-body">
                <div class="row">
                    @for ($i = 1; $i <= 4; $i++)
                        <div class="col-md-3 mb-3">
                            <label for="image_{{ $i }}" class="req">Image {{ $i }}</label>

                            @php
                                $field = 'image_' . $i;
                                $currentImage = $highlight->$field ?? null;
                            @endphp

                            @if ($currentImage)
                                <div class="file-preview mb-2">
                                    @if (pathinfo($currentImage, PATHINFO_EXTENSION) === 'pdf')
                                        <iframe src="{{ asset('storage/' . $currentImage) }}" width="100%" height="200px"
                                            class="border rounded"></iframe>
                                    @else
                                        <img src="{{ asset('storage/' . $currentImage) }}" width="100%" height="200px"
                                            class="border rounded" style="object-fit: cover;">
                                    @endif
                                </div>
                            @endif

                            <input type="file" name="image_{{ $i }}" id="image_{{ $i }}"
                                class="form-control" accept="image/*,application/pdf">
                            @error("image_{$i}")
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    @endfor
                </div>

                <small class="text-muted d-block">Upload hingga 4 file (bisa gambar atau PDF). Maksimal 5MB per
                    file.</small>
            </div>
        </div>

        {{-- ===== Submit Button ===== --}}
        <div class="text-end mt-4">
            <button type="submit" class="btn btn-primary">
                {{ isset($highlight) ? 'Update Data' : 'Save Data' }}
            </button>
        </div>
    </form>
@endsection

@section('script')
    @vite(['resources/js/landingpage/admin/services/services-highlight.js'])
@endsection
