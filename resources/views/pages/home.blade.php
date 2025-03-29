@extends('frontend.Master')
<style>
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: rgba(0, 0, 0, 0.5); /* Darken the background */
        border-radius: 50%; /* Make it rounded */
        width: 40px;
        height: 40px;
    }

    .carousel-control-prev:hover .carousel-control-prev-icon,
    .carousel-control-next:hover .carousel-control-next-icon {
        background-color: rgba(0, 0, 0, 0.8); /* Darker on hover */
    }
</style>

@section('content')
    <!-- Hero Section with Slider -->
    <div class="hero-section position-relative">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                @foreach($images as $image)
                    <div class="swiper-slide">
                        <img src="{{ asset($image->image_path) }}" alt="Musical Instrument" class="img-fluid w-100" style="height: 600px; object-fit: cover;">
                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(0,0,0,0.5);">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-6 text-white">
                                        <h1 class="display-4 fw-bold mb-4">Find Your Perfect Sound</h1>
                                        <p class="lead mb-4">Rent premium quality musical instruments for any occasion. No commitment, just music.</p>
                                        <a href="#" class="btn btn-primary btn-lg px-4 me-2">Browse Instruments</a>
                                        <a href="#how-it-works" class="btn btn-outline-light btn-lg px-4">How It Works</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <!-- Featured Benefits Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4 text-center">
                <div class="col-md-3">
                    <div class="p-3">
                        <i class="bi bi-music-note-beamed fs-1 text-primary mb-3"></i>
                        <h5>Premium Instruments</h5>
                        <p class="text-muted">High-quality instruments from top brands</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3">
                        <i class="bi bi-truck fs-1 text-primary mb-3"></i>
                        <h5>Free Delivery</h5>
                        <p class="text-muted">Free delivery and pickup for rentals over $100</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3">
                        <i class="bi bi-shield-check fs-1 text-primary mb-3"></i>
                        <h5>Maintenance Included</h5>
                        <p class="text-muted">Regular maintenance and repairs included</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3">
                        <i class="bi bi-calendar-check fs-1 text-primary mb-3"></i>
                        <h5>Flexible Rental</h5>
                        <p class="text-muted">Daily, weekly, or monthly rental options</p>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- Shop by Instruments Slider Section -->
    <section class="shop-by-instruments py-5" id="instruments">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold">SHOP BY INSTRUMENTS</h2>
                <p class="lead text-muted">Find the perfect instrument for your next performance or practice</p>
            </div>
            <div id="instrumentCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach($Category->chunk(4) as $chunkIndex => $chunk)
                        <div class="carousel-item @if($chunkIndex == 0) active @endif">
                            <div class="row">
                                @foreach($chunk as $item)
                                    <div class="col-md-3">
                                        <div class="card instrument-card h-100 shadow-sm border-0 position-relative overflow-hidden">
                                            <div class="instrument-img-container" style="height: 350px; overflow: hidden;">
                                                <img src="{{ asset('storage/'.$item->image_path) }}" alt="{{$item->name}}" class="d-block w-100 h-100" style="object-fit: cover; transition: transform 0.3s;">
                                            </div>
                                            <div class="card-body text-center">
                                                <h4 class="card-title">{{$item->name}}</h4>
                                                <a href="{{ route('instruments', $item->id) }}" class="btn btn-outline-primary">View Collection</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Carousel Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#instrumentCarousel" data-bs-slide="prev" style="display: block;">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#instrumentCarousel" data-bs-slide="next" style="display: block;">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>



    <!-- How It Works Section -->
    <section class="how-it-works py-5 bg-light" id="how-it-works">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold">HOW IT WORKS</h2>
                <p class="lead text-muted">Renting an instrument has never been easier</p>
            </div>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px;">
                                <h3 class="m-0">1</h3>
                            </div>
                            <h4>Browse</h4>
                            <p class="text-muted">Explore our wide selection of instruments and choose what you need</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px;">
                                <h3 class="m-0">2</h3>
                            </div>
                            <h4>Book</h4>
                            <p class="text-muted">Select your rental period and complete your booking online</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px;">
                                <h3 class="m-0">3</h3>
                            </div>
                            <h4>Receive</h4>
                            <p class="text-muted">Get your instrument delivered to your doorstep or pick it up</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px;">
                                <h3 class="m-0">4</h3>
                            </div>
                            <h4>Return</h4>
                            <p class="text-muted">Return the instrument when your rental period is over</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Instruments Section -->
    <section class="featured-instruments py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold">FEATURED INSTRUMENTS</h2>
                <p class="lead text-muted">Our most popular rental instruments</p>
            </div>
            <div class="row g-4">
                @foreach($instruments as $item)
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
{{--                        <span class="position-absolute top-0 end-0 badge bg-danger m-3">Popular</span>--}}
                        <img src="{{asset('Photos/1741440425.jpg')}}" class="card-img-top" alt="Grand Piano">
                        <div class="card-body">
                            <h5 class="card-title">{{$item->name}}</h5>
                            <p class="card-text text-muted">{{$item->category->name}}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-primary fw-bold">Rs.{{$item->rental_price}}/day</span>
                                <a href="{{route('detail',$item->id)}}" class="btn btn-sm btn-outline-primary">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold">WHAT OUR CUSTOMERS SAY</h2>
                <p class="lead text-muted">Hear from musicians who have rented with us</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="mb-3 text-warning">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="card-text">"I needed a quality piano for a weekend performance. The rental process was smooth, and the instrument was in perfect condition. Highly recommend!"</p>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Sarah Johnson</h6>
                                    <small class="text-muted">Professional Pianist</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="mb-3 text-warning">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="card-text">"As a music teacher, I often need different instruments for my students. This service has been a lifesaver! Great selection and excellent customer service."</p>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Michael Rodriguez</h6>
                                    <small class="text-muted">Music Educator</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="mb-3 text-warning">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                            </div>
                            <p class="card-text">"I rented a drum kit for my son's band practice. The quality was excellent, and the delivery was prompt. Will definitely use this service again!"</p>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">David Thompson</h6>
                                    <small class="text-muted">Parent</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="cta py-5 bg-primary text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 text-center text-lg-start">
                    <h2 class="display-5 fw-bold mb-3">Ready to Make Music?</h2>
                    <p class="lead mb-0">Browse our collection of premium instruments and start your musical journey today.</p>
                </div>
                <div class="col-lg-4 text-center text-lg-end mt-4 mt-lg-0">
                    <a href="#" class="btn btn-light btn-lg px-4">Rent Now</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Add Bootstrap Icons if not already included in your Master layout -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
        <style>
            .instrument-card:hover .instrument-img-container img {
                transform: scale(1.05);
            }
            .hero-section {
                margin-top: 0;
            }
        </style>


    <!-- Add Swiper JS if not already included -->

        <script>
            // Initialize Swiper
            var swiper = new Swiper(".mySwiper", {
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                autoplay: {
                    delay: 5000,
                },
                loop: true,
            });
        </script>

@endsection
