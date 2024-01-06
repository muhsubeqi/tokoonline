@extends('homepage.layouts.template')
@section('title')
    Member
@endsection
@section('content')
    <div id="heading-breadcrumbs">
        <div class="container">
            <div class="row d-flex align-items-center flex-wrap">
                <div class="col-md-7">
                    <h1 class="h2">Member</h1>
                </div>
                <div class="col-md-5">
                    <ul class="breadcrumb d-flex justify-content-end">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active">Member</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="content">
        <div class="container">
            <section class="bar mb-0">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row text-center">
                            @foreach ($member as $row)
                                <div class="col-md-2 col-sm-3">
                                    <div data-animate="fadeInUp" class="team-member">
                                        @if ($row->image != null)
                                            <div class="image image-container">
                                                <img src="{{ asset('data/user/' . $row->image) }}" alt=""
                                                    class="img-fluid image-member">
                                            </div>
                                        @else
                                            <div class=" image image-container">
                                                <img src="/admin/dist/img/avatar5.png" alt=""
                                                    class="img-fluid image-member">
                                            </div>
                                        @endif
                                        <h3>{{ $row->name }}
                                        </h3>
                                        <p class="role">{{ $row->role }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row justify-content-center">
                            {{ $member->onEachSide(0)->links() }}
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
