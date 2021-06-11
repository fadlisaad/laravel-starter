@extends('frontend.layouts.app')

@section('title') Privacy Policy - {{ config('app.name') }} @endsection

@section('content')

<section class="section-header bg-gradient text-white pb-7 pb-lg-11">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 text-center">
                <h1 class="display-2 mb-4">
                    Privacy Policy
                </h1>
                <p class="lead">
                    Privacy policy for usage of Cartsitu mobile app
                </p>

                @include('frontend.includes.messages')
            </div>
        </div>
    </div>
</section>

<section class="section section-lg line-bottom-light">
    <div class="container mt-n7 mt-lg-n12 z-2">
        <div class="row">
            <div class="col-lg-12">
                <div class="card bg-white border-light shadow-soft no-gutters p-4">
                    {!! setting('privacy_policy') !!}
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
