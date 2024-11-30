@extends('main.admin.layouts.master')

@section('title','Message')
@section('label','Message')

@section('noti')
    {{ $orderCounts->count() }}
@endsection

@section('content')
    <!-- contact message start  -->
    <main class="content px-3 py-4">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between">
                <div class="bg-white text-dark px-3 border rounded pt-2 h-100 text-center">
                    <h5>Total - {{ $messages->count() }}</h5>
                </div>
            </div>

            @if(session('success'))
                <div class="row mt-3 mb-0 me-5 justify-content-end" id="alert-row">
                    <div class="col-lg-6 w-auto alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @if(session('deleteSuccess'))
                <div class="row mt-3 mb-0 me-5 justify-content-end" id="alert-row">
                    <div class="col-lg-6 w-auto alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('deleteSuccess') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @if($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="row mt-3 mb-0 me-5 justify-content-end" id="alert-row">
                        <div class="col-lg-6 w-auto alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $error }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endforeach
            @endif

            @php
                $counter = 1;
            @endphp

            <div id="table-bg">
                <div class="my-3">
                    @if(count($messages) != 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Website Name</th>
                                        <th class="message-column">Message</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($messages as $m)
                                    <tr>
                                        <td>{{ $counter++ }}</td>
                                        <td>{{ $m->name }}</td>
                                        <td>{{ $m->email }}</td>
                                        <td>{{ $m->website_name }}</td>
                                        <td class="message-column">{{ $m->message }}</td>
                                        <td style="color: {{ $m->status == 'read' ? '#00b32c' : '#FF6347' }};">
                                            {{ $m->status == 'read' ? 'Send' : 'Unsend' }}
                                        </td>
                                        <td>
                                            <div class="table-data-feature">
                                                <a href="{{ route('admin#messageReply',$m->id) }}" class="text-decoration-none" id="edit">
                                                    <button class="item btn bg-dark text-white" data-toggle="tooltip" data-placement="top" title="Reply">
                                                        <i class="fa-solid fa-reply"></i>
                                                    </button>
                                                </a>
                                                <a href="{{ route('admin#messageDelete',$m->id) }}" class="text-decoration-none" id="delete">
                                                    <button class="item btn bg-danger text-white" data-toggle="tooltip" data-placement="top" title="Delete">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <h6 class="text-secondary text-center mt-4">There is no message here yet!</h6>
                    @endif


                    <div class="mt-2">
                        {{ $messages->links() }}
                    </div>

                </div>
            </div>
        </div>
    </main>
    <!-- contact message end -->
@endsection
