@extends('frontend.Master')



@section('content')
    <!-- Hero Section with Slider -->
    <div class="hero-section position-relative">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                @foreach($images as $image)
                    <div class="swiper-slide">
                        <img src="{{ asset($image->image_path) }}" alt="Musical Instrument" class="img-fluid w-100">
                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center hero-overlay">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-7 text-white hero-content">
                                        <h1 class="hero-title">Find Your Perfect Sound</h1>
                                        <p class="hero-description">Rent premium quality musical instruments for any occasion. No commitment, just music.</p>
                                        <div class="d-flex flex-wrap gap-3">
                                            <a href="#instruments" class="btn btn-primary btn-lg">Browse Instruments</a>
                                            <a href="#how-it-works" class="btn btn-outline-light btn-lg">How It Works</a>
                                        </div>
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
        <div class="container py-4">
            <div class="text-center mb-5 animate-fadeInUp">
                <h2 class="display-5 fw-bold section-title">WHY CHOOSE US</h2>
                <p class="lead text-muted mx-auto" style="max-width: 700px;">Experience the best musical instrument rental service with premium quality and exceptional service</p>
            </div>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="bi bi-music-note-beamed"></i>
                        </div>
                        <h4>Premium Instruments</h4>
                        <p class="text-muted">High-quality instruments from top brands, maintained to perfection</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="bi bi-truck"></i>
                        </div>
                        <h4>Free Delivery</h4>
                        <p class="text-muted">Free delivery and pickup for rentals over $100, right to your doorstep</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h4>Maintenance Included</h4>
                        <p class="text-muted">Regular maintenance and repairs included in every rental package</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <h4>Flexible Rental</h4>
                        <p class="text-muted">Daily, weekly, or monthly rental options to suit your schedule</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Shop by Instruments Slider Section -->
    <section class="shop-by-instruments py-5" id="instruments">
        <div class="container py-4">
            <div class="text-center mb-5 animate-fadeInUp">
                <h2 class="display-5 fw-bold section-title">SHOP BY INSTRUMENTS</h2>
                <p class="lead text-muted mx-auto" style="max-width: 700px;">Find the perfect instrument for your next performance or practice</p>
            </div>
            <div id="instrumentCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach($Category->chunk(4) as $chunkIndex => $chunk)
                        <div class="carousel-item @if($chunkIndex == 0) active @endif">
                            <div class="row g-4">
                                @foreach($chunk as $item)
                                    <div class="col-md-3">
                                        <div class="instrument-card h-100 position-relative overflow-hidden">
                                            <div class="instrument-img-container" style="height: 350px; overflow: hidden;">
                                                <img src="{{ asset('storage/'.$item->image_path) }}" alt="{{$item->name}}" class="d-block w-100 h-100" style="object-fit: cover;">
                                            </div>
                                            <div class="card-body text-center">
                                                <h4 class="card-title mb-3">{{$item->name}}</h4>
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
                <button class="carousel-control-prev" type="button" data-bs-target="#instrumentCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#instrumentCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works py-5 bg-light" id="how-it-works">
        <div class="container py-4">
            <div class="text-center mb-5 animate-fadeInUp">
                <h2 class="display-5 fw-bold section-title">HOW IT WORKS</h2>
                <p class="lead text-muted mx-auto" style="max-width: 700px;">Renting an instrument has never been easier</p>
            </div>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="step-card">
                        <div class="card-body text-center p-4">
                            <div class="step-number">1</div>
                            <h3 class="mb-3">Browse</h3>
                            <p class="text-muted">Explore our wide selection of instruments and choose what you need</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="step-card">
                        <div class="card-body text-center p-4">
                            <div class="step-number">2</div>
                            <h3 class="mb-3">Book</h3>
                            <p class="text-muted">Select your rental period and complete your booking online</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="step-card">
                        <div class="card-body text-center p-4">
                            <div class="step-number">3</div>
                            <h3 class="mb-3">Receive</h3>
                            <p class="text-muted">Get your instrument delivered to your doorstep or pick it up</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="step-card">
                        <div class="card-body text-center p-4">
                            <div class="step-number">4</div>
                            <h3 class="mb-3">Return</h3>
                            <p class="text-muted">Return the instrument when your rental period is over</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Instruments Section -->
    <section class="featured-instruments py-5">
        <div class="container py-4">
            <div class="text-center mb-5 animate-fadeInUp">
                <h2 class="display-5 fw-bold section-title">FEATURED INSTRUMENTS</h2>
                <p class="lead text-muted mx-auto" style="max-width: 700px;">Our most popular rental instruments</p>
            </div>
            <div class="row g-4">
                @foreach($instruments as $item)
                    <div class="col-md-6 col-lg-3">
                        <div class="featured-card">
                            <div class="position-relative overflow-hidden">
                                <img src="{{ asset($item->image_path) }}" class="card-img-top" alt="{{ $item->name }}">
                                @if($loop->first)
                                    <span class="featured-badge animate-pulse">Popular</span>
                                @endif
                            </div>
                            <div class="card-body">
                                <h5 class="card-title mb-2">{{$item->name}}</h5>
                                <p class="card-text text-muted mb-3">{{$item->category->name}}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="featured-price">Rs.{{$item->rental_price}}/day</span>
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
        <div class="container py-4">
            <div class="text-center mb-5 animate-fadeInUp">
                <h2 class="display-5 fw-bold section-title">WHAT OUR CUSTOMERS SAY</h2>
                <p class="lead text-muted mx-auto" style="max-width: 700px;">Hear from musicians who have rented with us</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="card-body p-4">
                            <div class="testimonial-stars mb-3">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="testimonial-text">"I needed a quality piano for a weekend performance. The rental process was smooth, and the instrument was in perfect condition. Highly recommend!"</p>
                        </div>
                        <div class="card-footer bg-white border-0 p-4">
                            <div class="d-flex align-items-center">
                                <div class="testimonial-avatar">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">Sarah Johnson</h6>
                                    <small class="text-muted">Professional Pianist</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="card-body p-4">
                            <div class="testimonial-stars mb-3">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="testimonial-text">"As a music teacher, I often need different instruments for my students. This service has been a lifesaver! Great selection and excellent customer service."</p>
                        </div>
                        <div class="card-footer bg-white border-0 p-4">
                            <div class="d-flex align-items-center">
                                <div class="testimonial-avatar">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">Michael Rodriguez</h6>
                                    <small class="text-muted">Music Educator</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="card-body p-4">
                            <div class="testimonial-stars mb-3">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                            </div>
                            <p class="testimonial-text">"I rented a drum kit for my son's band practice. The quality was excellent, and the delivery was prompt. Will definitely use this service again!"</p>
                        </div>
                        <div class="card-footer bg-white border-0 p-4">
                            <div class="d-flex align-items-center">
                                <div class="testimonial-avatar">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">David Thompson</h6>
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
    <section class="cta-section text-white">
        <div class="container">
            <div class="row align-items-center cta-content">
                <div class="col-lg-8 text-center text-lg-start">
                    <h2 class="cta-title mb-3">Ready to Make Music?</h2>
                    <p class="cta-description">Browse our collection of premium instruments and start your musical journey today.</p>
                </div>
                <div class="col-lg-4 text-center text-lg-end mt-4 mt-lg-0">
                    <a href="#instruments" class="btn btn-light btn-lg px-4 animate-pulse">Rent Now</a>
                </div>
            </div>
        </div>
    </section>


    <!-- Add Swiper JS -->
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
            effect: "fade",
            fadeEffect: {
                crossFade: true
            },
            loop: true,
            speed: 1000,
        });

        // Add animation classes on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-fadeInUp');
                    }
                });
            }, {
                threshold: 0.1
            });

            document.querySelectorAll('.benefit-card, .instrument-card, .step-card, .featured-card, .testimonial-card').forEach(element => {
                observer.observe(element);
            });
        });
    </script>
@endsection
