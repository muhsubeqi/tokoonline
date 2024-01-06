<div class="top-bar">
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-md-6 d-md-block d-none">
                @php
                    $announcement = App\Models\Setting::where('setting', 'announcement')->first();
                @endphp
                <p>{{ @$announcement->tool2 }}</p>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-md-end justify-content-between">
                    <ul class="list-inline contact-info d-block d-md-none">
                        <li class="list-inline-item"><a href="#"><i class="fa fa-phone"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fa fa-envelope"></i></a></li>
                    </ul>
                    @guest
                        <div class="login">
                            <a href="#" data-toggle="modal" data-target="#login-modal" class="login-btn"><i
                                    class="fa fa-sign-in"></i><span class="d-none d-md-inline-block">Sign
                                    In</span></a>
                            <a href="{{ route('register.supplier-member') }}" class="signup-btn"><i
                                    class="fa fa-user"></i><span class="d-none d-md-inline-block">Sign Up</span></a>
                        </div>
                    @endguest
                    <ul class="social-custom list-inline">
                        @php
                            $facebook = App\Models\Setting::where('setting', 'sosial_media_1')->first();
                            $instagram = App\Models\Setting::where('setting', 'sosial_media_2')->first();
                            $other = App\Models\Setting::where('setting', 'sosial_media_3')->first();
                        @endphp
                        <li class="list-inline-item"><a href="{{ $facebook->tool2 }}"><i class="fa fa-facebook"></i></a>
                        </li>
                        <li class="list-inline-item"><a href="{{ $instagram->tool2 }}"><i
                                    class="fa fa-instagram"></i></a>
                        </li>
                        <li class="list-inline-item"><a href="{{ $other->tool2 }}"><i class="fa fa-link"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
