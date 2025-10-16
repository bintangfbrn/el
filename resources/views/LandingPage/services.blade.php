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
                <div class="col-lg-4 col-md-6">

                    <div class="service-item wow fadeInUp">

                        <div class="service-image">
                            <a href="service-single.html" data-cursor-text="View">
                                <figure class="image-anime">
                                    <img src="{{ asset('assets/landing-pages/images/service-1.jpg') }}" alt="">
                                </figure>
                            </a>
                        </div>

                        <div class="service-btn">
                            <a href="service-single.html"><img
                                    src="{{ asset('assets/landing-pages/images/arrow-white.svg') }}" alt=""></a>
                        </div>

                        <div class="service-content">
                            <h3><a href="service-single.html">residential interior design</a></h3>
                            <p>We create personalized living spaces that reflect your style and functional needs.</p>
                        </div>

                    </div>

                </div>
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
    <!-- Why Choose Us Section End -->

    <!-- Our Skill Start -->
    {{-- <div class="our-skill">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <!-- Our Skill Content Start -->
                    <div class="our-skill-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp">our skills</h3>
                            <h2 class="text-anime-style-2" data-cursor="-opaque">Skills that shape your<span> dream
                                    home</span></h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">Our dedicated team of designers works
                                closely with you to understand your vision and bring it to life with thoughtful
                                attention to detail.</p>
                        </div>
                        <!-- Section Title End -->

                        <!-- About SkillBar Start -->
                        <div class="our-skillbar">
                            <!-- Skills Progress Bar Start -->
                            <div class="skills-progress-bar">
                                <!-- Skill Item Start -->
                                <div class="skillbar" data-percent="95%">
                                    <div class="skill-data">
                                        <div class="skill-title">space planning and layout</div>
                                        <div class="skill-no">95%</div>
                                    </div>
                                    <div class="skill-progress">
                                        <div class="count-bar"></div>
                                    </div>
                                </div>
                                <!-- Skill Item End -->
                            </div>
                            <!-- Skills Progress Bar End -->

                            <!-- Skills Progress Bar Start -->
                            <div class="skills-progress-bar">
                                <!-- Skill Item Start -->
                                <div class="skillbar" data-percent="85%">
                                    <div class="skill-data">
                                        <div class="skill-title">project challenges and solutions</div>
                                        <div class="skill-no">85%</div>
                                    </div>
                                    <div class="skill-progress">
                                        <div class="count-bar"></div>
                                    </div>
                                </div>
                                <!-- Skill Item End -->
                            </div>
                            <!-- Skills Progress Bar End -->

                            <!-- Skills Progress Bar Start -->
                            <div class="skills-progress-bar">
                                <!-- Skill Item Start -->
                                <div class="skillbar" data-percent="75%">
                                    <div class="skill-data">
                                        <div class="skill-title">sustainability and eco-friendly features</div>
                                        <div class="skill-no">75%</div>
                                    </div>
                                    <div class="skill-progress">
                                        <div class="count-bar"></div>
                                    </div>
                                </div>
                                <!-- Skill Item End -->
                            </div>
                            <!-- Skills Progress Bar End -->
                        </div>
                        <!-- About SkillBar End -->
                    </div>
                    <!-- Our Skill Content End -->
                </div>

                <div class="col-lg-6">
                    <!-- Our Skill Image Start -->
                    <div class="our-skill-image">
                        <div class="our-skill-img-1">
                            <figure class="image-anime reveal">
                                <img src="images/our-skill-img-1.jpg" alt="">
                            </figure>
                        </div>

                        <div class="our-skill-img-2">
                            <figure class="image-anime reveal">
                                <img src="images/our-skill-img-2.jpg" alt="">
                            </figure>
                        </div>

                        <div class="our-skill-img-3">
                            <figure class="image-anime reveal">
                                <img src="images/our-skill-img-3.jpg" alt="">
                            </figure>
                        </div>
                    </div>
                    <!-- Our Skill Image End -->
                </div>
            </div>
        </div>
    </div> --}}
@endsection
@section('script')
@endsection
