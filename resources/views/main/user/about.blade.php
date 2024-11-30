@extends('main.user.layouts.master')

@section('title','About Us')

@section('content')
    <!-- about us start  -->
    <section class="container-lg">
        <div class="stand-for">
            <h3>What We Stand For</h3>
            @if ($infos && $infos->about_letter )
                <p>{{ $infos->about_letter }}</p>
            @endif
        </div>
        <div class="mission">
            <h3>Our Mission & Process</h3>
            <hr>
            <div class="row align-items-center mt-4 mb-4">
                <div class="col-lg-3 col-sm-3">
                    <h5>Discovery</h5>
                </div>
                <div class="col-lg-9 col-sm-9">
                    <p class="mt-2">Understanding your vision, goals, and needs from the start.</p>
                </div>
            </div>
            <div class="row align-items-center mb-4">
                <div class="col-lg-3 col-sm-3">
                    <h5>Design</h5>
                </div>
                <div class="col-lg-9 col-sm-9">
                    <p class="mt-2">Creating tailored, elegant solutions that align with your objectives.</p>
                </div>
            </div>
            <div class="row align-items-center mb-4">
                <div class="col-lg-3 col-sm-3">
                    <h5>Development</h5>
                </div>
                <div class="col-lg-9 col-sm-9">
                    <p class="mt-2">Building your project with a focus on functionality and efficiency.</p>
                </div>
            </div>
            <div class="row align-items-center mb-4">
                <div class="col-lg-3 col-sm-3">
                    <h5>Testing & Improvements</h5>
                </div>
                <div class="col-lg-9 col-sm-9">
                    <p class="mt-2">This is when we make sure that your product works the way it has to work.</p>
                </div>
            </div>
            <div class="row align-items-center mb-4">
                <div class="col-lg-3 col-sm-3">
                    <h5>Time Limit</h5>
                </div>
                <div class="col-lg-9 col-sm-9">
                    <p class="mt-2">Delivering each phase on schedule, with a commitment to timely success.</p>
                </div>
            </div>
        </div>
        <div class="teams">
            <div class="text-center">
                <h3>Meet Our MCL Team</h3>
            </div>
            <div class="row mt-4 justify-content-center">
                @foreach ($teams as $t)
                <div class="col-lg-3 col-md-4 col-sm-6 mx-auto mb-3">
                    <div class="p-3">
                        <img src="{{ asset('storage/members/'.$t->image) }}" class="d-block rounded" alt="">
                        <h5>{{ $t->name }}</h5>
                        <label for="">{{ $t->position }}</label>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- about us end  -->

    <!-- partner company start  -->
    <section id="partner-company" class="container-lg">
        <div class="text-center">
            <h3>Clients We Work With</h3>
            <p>Partners</p>
        </div>
        <div class="row align-items-center mt-4">
            @foreach ($clientLogos as $c)
            <div class="col-lg-3 col-md-3 col-sm-4 mb-2">
                <img src="{{ asset('storage/client-logo/'.$c->image) }}" class="d-block w-100" alt="">
            </div>
            @endforeach
        </div>
    </section>
    <!-- partner company end  -->
@endsection

