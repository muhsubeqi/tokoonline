@extends('admin.layouts.template')
@section('title', 'Profil | Edit Pegawai')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profil</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.profile') }}">Profil</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Profil</h3>
                    <div class="card-tools">
                        <!-- Maximize Button -->
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i
                                class="fas fa-expand"></i></button>
                    </div>
                </div>
                <!-- form start -->
                <form id="quickForm" action="{{ route('admin.profile.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="input" name="name" class="form-control" id="name"
                                placeholder="Masukkan nama" value="{{ $user->name }}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" id="email"
                                placeholder="Enter email" value="{{ $user->email }}">
                        </div>
                        <div class="form-group">
                            <label for="image">Photo</label><br>
                            @php
                                $image = $user->image;
                            @endphp
                            @if ($user->image)
                                <img src="{{ asset("/data/user/$user->image") }}"
                                    class="profile-user-img img-fluid img-circle" id="img-preview"
                                    style="width: 100px; height: 100px; object-fit:cover;" alt="User Image">
                            @else
                                <img class="profile-user-img img-fluid img-circle" id="img-preview"
                                    style="width: 100px; height: 100px; object-fit:cover;" alt="User Image">
                            @endif
                            <div class="custom-file mt-2">
                                <input type="hidden" name="image_lama" value="{{ $user->image }}">
                                <input type="file" class="custom-file-input" onchange="previewImage()" id="image"
                                    name="image" accept="image/png, image/jpeg">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                        <div class="collapse" id="f_password">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control " id="password"
                                    placeholder="Masukkan password" disabled>
                            </div>
                            <div class="form-group">
                                <label for="konfirmasi_password">Konfirmasi Password</label>
                                <input type="password" name="konfirmasi_password" class="form-control"
                                    id="konfirmasi_password" placeholder="Masukkan ulang password" disabled>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <a class="btn btn-warning text-light w-100 mb-2" data-toggle="collapse" href="#f_password"
                            role="button" aria-expanded="false" aria-controls="collapseExample" onclick="showPassword()">
                            Ubah Password
                        </a>
                        <button type="submit" id="submitButton" class="btn btn-primary w-100">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->

            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@push('script')
    <!-- jquery-validation -->
    <script src="{{ asset('/admin/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <script>
        //add name to fileinput
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>

    <script>
        $(function() {
            $("#quickForm").submit(function() {
                $("#submitButton").prop("disabled", true);
            });
            $('#quickForm').validate({
                rules: {
                    password: {
                        required: true,
                        minlength: 8
                    },
                    konfirmasi_password: {
                        required: true,
                        equalTo: '#password'
                    }
                },
                messages: {
                    password: {
                        required: 'Password tidak boleh kosong',
                        minlength: 'Minimal 8 karakter'
                    },
                    konfirmasi_password: {
                        required: 'Konfirmasi tidak boleh kosong',
                        equalTo: 'Password tidak sama'
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>

    <script>
        var checkCollapse = true;

        function showPassword() {
            if (checkCollapse) {
                $('#password').attr("disabled", false);
                $('#konfirmasi_password').attr("disabled", false);
                checkCollapse = false;
            } else {
                $('#password').attr("disabled", true);
                $('#konfirmasi_password').attr("disabled", true);
                checkCollapse = true;
            }
        }

        function previewImage() {
            const image = document.querySelector("#image");
            const imgPreview = document.querySelector("#img-preview");

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);
            // oFReader.onLoad = function(oFREvent) {
            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            };
        }
    </script>
@endpush
