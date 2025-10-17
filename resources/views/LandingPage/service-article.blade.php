@extends('layouts.front-layout')

@section('core-css')
@endsection

@section('helper-js')
@endsection

@section('content')
    <div class="page-service-single">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <!-- Service Sidebar Start -->
                    <div class="service-sidebar">
                        <!-- Service Category List Start -->
                        <div class="service-catagery-list wow fadeInUp">
                            <h3>services category</h3>
                            <ul>
                                <li><a href="#">residential design</a></li>
                                <li><a href="#">commercial interiors</a></li>
                                <li><a href="#">space planning</a></li>
                                <li><a href="#">furniture selection</a></li>
                                <li><a href="#">lighting design</a></li>
                                <li><a href="#">color consultation</a></li>
                                <li><a href="#">3D visualization</a></li>
                                <li><a href="#">custom renovations</a></li>
                            </ul>
                        </div>
                        <!-- Service Category List End -->

                        <!-- Sidebar CTA Box Start -->
                    </div>
                    <!-- Service Sidebar End -->
                </div>

                <div class="col-lg-8">
                    <!-- Service Single Content Start -->
                    <div class="service-single-content">
                        <!-- Service Feature Image Start -->
                        <div class="service-feature-image">
                            <figure class="image-anime reveal">
                                <img src="{{ asset('storage/' . $serviceItems->image) }}" alt="">
                            </figure>
                        </div>
                        <!-- Service Feature Image End -->

                        <!-- Secvice Entry Start -->
                        <div class="service-entry">
                            <p class="wow fadeInUp">{{ $serviceItems->description }}</p>

                            {{-- <p class="wow fadeInUp" data-wow-delay="0.2s">Our offerings also include expert color and
                                material selection, lighting solutions to enhance mood, and soft furnishings to add
                                warmth. From home renovations that revitalize interiors to storage solutions that bring
                                both style and organization, we cover all aspects of interior enhancement. Using 3D
                                visualization, we ensure clients can envision their transformed space, making the design
                                process both transparent and collaborative.</p> --}}

                            <!-- Service Entry List Image Start -->
                            <div class="service-entry-list-image">
                                <!-- Service Entry Image Start -->
                                <div class="service-entry-image">
                                    <figure class="image-anime reveal">
                                        <img src="{{ asset('storage/' . $serviceItems->image_2) }}" alt="">
                                    </figure>
                                </div>
                                <!-- Service Entry Image End -->

                                <!-- Service Entry List Start -->
                                <div class="service-entry-list wow fadeInUp" data-wow-delay="0.6s">
                                    <ul>
                                        <li>excellence in creative design expertise</li>
                                        <li>mastering the art of creative design excellence</li>
                                        <li>innovative approaches creative design mastery</li>
                                        <li>transforming ideas into design masterpieces</li>
                                        <li>shaping extraordinary spaces with design</li>
                                        <li>pushing boundaries in creative design innovation</li>
                                    </ul>
                                </div>
                                <!-- Service Entry List End -->
                            </div>
                            <!-- Service Entry List Image End -->
                        </div>
                    </div>
                    <!-- Service Single Content End -->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
