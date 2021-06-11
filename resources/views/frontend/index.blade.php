@extends('frontend.layouts.app')

@section('title') {{app_name()}} @endsection

@section('content')

<!-- ======= Hero Section ======= -->
<section id="hero" class="section section-lg bg-soft">

    <div class="container mt-3">
        <div class="row">
            <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1">
            <h1>Immersive shopping experiences purpose-built for<span style="color: red;"> communities </span></h1>
            <h2>Malaysia’s first video shopping app</h2>
            </div>
            <div class="col-lg-6 order-2 order-lg-2 hero-img d-flex justify-content-center">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/nVbyGhH75NI?controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </div>

</section><!-- End Hero -->

<section class="section pb-5">
    <div class="container">
        <div class="row">
            <div class="col-6 justify-content-center">
                <img src="{{ asset('frontend/img/cartsitu/Asset 6.png') }}" height="100px">
            </div>
            <div class="col-6 justify-content-center">
                <h2 class="mb-3 mb-lg-4 text-black">
                    About Us
                </h2>
                <p class="text-gray">
                    We're a Video based Social Commerce App that supports businesses to market their products using <span style="color: #BA1E2D;">video content</span> to promote and sell their products or services in a <span style="color: #ED5A29;"> FUN </span>and <span style = "color: #F3901E;"> EFFECTIVE </span>way
                </p>
            </div>
        </div>
    </div>
</section>

<section class="section section-lg pb-5 bg-soft">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 text-gray text-center mb-4 mb-lg-5">
                <h2 class="mb-3 mb-lg-4 text-black">
                    Download
                </h2>
                <p class="lead text-gray mb-4">
                    Get our app now from the Google Play Store!
                </p>
            </div>
            <div class="col-12 col-md-6 text-center">
                <p>
                    <img src="{{ asset('frontend/img/google.png') }}" height="48px">
                    <img src="{{ asset('frontend/img/apple.png') }}" height="54px">
                </p>
            </div>
        </div>
    </div>
</section>

@endsection
