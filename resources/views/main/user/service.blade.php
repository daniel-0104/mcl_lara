@extends('main.user.layouts.master')

@section('title','Services')

@section('content')
    <!-- service title start  -->
    <section>
        <div id="service-title">
            <h1>Web development Services</h1>
            @if ($infos && $infos->service_letter )
                <p>{{ $infos->service_letter }}</p>
            @endif
            <div>
                <label for="">OUR SERVICES : </label>
                <div class="row mt-3">
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4 text-center mx-auto">
                        <div class="border py-2">
                            <img src="{{ asset('user/image/web.png') }}" class="w-50 d-block mx-auto" alt="">
                            <h6 class="w-75 mx-auto">Web App Development</h6>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4  text-center mx-auto">
                        <div class="border py-2">
                            <img src="{{ asset('user/image/frontend.png') }}" class="w-50 d-block mx-auto" alt="">
                            <h6 class="w-75 mx-auto">Frontend Development</h6>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4  text-center mx-auto">
                        <div class="border py-2">
                            <img src="{{ asset('user/image/backend.png') }}" class="w-50 d-block mx-auto" alt="">
                            <h6 class="w-75 mx-auto">Backend Development</h6>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4  text-center mx-auto">
                        <div class="border py-2">
                            <img src="{{ asset('user/image/team.png') }}" class="w-50 d-block mx-auto" alt="">
                            <h6 class="w-75 mx-auto">Flexible Team Solutions</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- service title end  -->
@endsection

