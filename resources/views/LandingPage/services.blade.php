@extends('layouts.front-layout')

@section('core-css')
@endsection

@section('helper-js')
@endsection

@section('content')
    <!-- Page Header End -->

    <!-- Our Services Section Start -->
    <div class="page-services">
        <div class="container">
            <div class="row">
                @foreach ($serviceItems as $service)
                    <div class="col-lg-4 col-md-6">
                        <div class="service-item wow fadeInUp">

                            <div class="service-image">
                                <a href="{{ url('service-single/' . $service->slug) }}" data-cursor-text="View">
                                    <figure class="image-anime">
                                        {{-- Jika gambar disimpan di storage --}}
                                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}">
                                    </figure>
                                </a>
                            </div>

                            <div class="service-btn">
                                <a href="{{ url('service-single/' . $service->slug) }}">
                                    <img src="{{ asset('assets/landing-pages/images/arrow-white.svg') }}" alt="">
                                </a>
                            </div>

                            <div class="service-content">
                                <h3>
                                    <a href="{{ url('service-single/' . $service->slug) }}">
                                        {{ $service->title }}
                                    </a>
                                </h3>
                                <p>{{ $service->description }}</p>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Our Services Section End -->

    <!-- Why Choose Us Section Start -->
    <div class="why-choose-us">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <!-- Why Choose Content Start -->
                    <div class="why-choose-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp">why choose us</h3>
                            <h2 class="text-anime-style-2" data-cursor="-opaque">{{ $highlight->title }}</h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">{{ $highlight->subtitle }}</p>
                        </div>
                        <div class="why-choose-item-list">
                            @foreach ($features as $index => $feature)
                                <div class="why-choose-item wow fadeInUp" data-wow-delay="{{ 0.2 + $index * 0.2 }}s">
                                    <!-- Icon -->
                                    <div class="icon-box">
                                        @if (!empty($feature->icon))
                                            <img src="{{ asset('storage/' . $feature->icon) }}"
                                                alt="{{ $feature->title ?? 'Feature icon' }}">
                                        @else
                                            <img src="{{ asset('images/default-icon.svg') }}" alt="default-icon">
                                        @endif
                                    </div>

                                    <!-- Content -->
                                    <div class="why-choose-item-content">
                                        <h3>{{ $feature->title ?? 'No Title' }}</h3>
                                        <p>{{ $feature->description ?? '' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="why-choose-images">
                        @foreach ($images->chunk(2) as $boxIndex => $chunk)
                            <!-- Why Choose Box {{ $boxIndex + 1 }} Start -->
                            <div class="why-choose-img-box-{{ $boxIndex + 1 }}">
                                @foreach ($chunk as $imgIndex => $image)
                                    @php
                                        $imgNumber = $boxIndex * 2 + ($imgIndex + 1); // hasil urutan: 1, 2, 3, 4, dst
                                    @endphp

                                    <!-- Why Choose img {{ $imgNumber }} Start -->
                                    <div class="why-choose-img-{{ $imgNumber }}">
                                        <figure class="image-anime reveal">
                                            <img src="{{ asset('storage/' . $image->image_path) }}"
                                                alt="Image {{ $imgNumber }}">
                                        </figure>
                                    </div>
                                    <!-- Why Choose img {{ $imgNumber }} End -->
                                @endforeach
                            </div>
                            <!-- Why Choose Box {{ $boxIndex + 1 }} End -->
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
