@extends('main.user.layouts.master')

@section('title','Cases')

@section('content')
    <!-- cases start  -->
    <section id="web-cases" class="container-lg">
        <div id="cases-title">
            <h1>Projects We’re Proud Of Done for Our Clients</h1>
        </div>
        <div id="case-category">
            <div class="d-flex align-items-center case-scroll-container">
                <a href="{{ route('user#caseList') }}" class="category-link">
                    <button class="btn {{ !isset($projectType) ? 'active' : '' }}">All</button>
                </a>

                @foreach ($projects as $t)
                    <a href="{{ route('user#caseFilter', $t->type) }}" class="category-link">
                        <button class="btn {{ isset($projectType) && $projectType == $t->type ? 'active' : '' }}">
                            {{ $t->type }}
                        </button>
                    </a>
                @endforeach

            </div>
        </div>
        <div id="project-cases">
            @foreach ($typeProjects ?? $projects as $p)
                <div class="row">
                    <div class="col-lg-8 p-0 order-lg-1">
                        <a href="{{ route('user#caseView', $p->id) }}">
                            @php
                                $images = json_decode($p->images, true);
                            @endphp
                            <img src="{{ asset('storage/projects/'.$images[1]) }}" class="w-100 d-block" alt="">
                        </a>
                    </div>
                    <div class="col-lg-4">
                        <a href="{{ route('user#caseView', $p->id) }}" class="text-decoration-none text-dark">
                            <h4>{{ $p->name }}</h4>
                        </a>
                        <label for="">{{ $p->type }}</label>
                        <p>{{ $p->paragraph1 }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    <!-- cases end  -->

    <section>
        <div id="new-project">
            <h5>Have a project you'd like to discuss?</h5>
            <a href="{{ route('user#contact') }}">
                <button class="btn fw-bold" id="price-plans">Contact Us<i class="fa-solid fa-arrow-right ms-2"></i></button>
            </a>
        </div>
    </section>
@endsection

@section('scriptSource')
    <script>
        //....................................... ......category active link start .........................................
        document.addEventListener('DOMContentLoaded', function() {
            const caseCategory = document.querySelector('.case-scroll-container');
            const categoryLinks = document.querySelectorAll('.category-link button');
            const currentHTMLPage = window.location.pathname;

            categoryLinks.forEach(button => {
                button.addEventListener('click', function() {
                    categoryLinks.forEach(btn => btn.classList.remove('active'));
                    button.classList.add('active');
                });
            });

            categoryLinks.forEach(button => {
                let linkHref = button.closest('a').getAttribute('href')

                if (linkHref.startsWith(window.location.origin)){
                    linkHref = linkHref.replace(window.location.origin, '');
                }

                if (currentHTMLPage === linkHref) {
                    button.classList.add('active');
                }

                sessionStorage.setItem('case-scroll-x', caseCategory.scrollLeft);
            });

            const caseScrollX = sessionStorage.getItem('case-scroll-x');
            if (caseScrollX !== null) {
                caseCategory.scrollLeft = parseInt(caseScrollX, 10);
            }
        });
    //................................................category active link end..... .........................................
    </script>
@endsection
