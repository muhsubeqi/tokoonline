@extends('admin.layouts.template')
@section('title')
    Admin | User
@endsection
@push('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Select2 --}}
    <link rel="stylesheet" href="{{ asset('/admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    {{-- Datatable --}}
    <link rel="stylesheet" href="{{ asset('/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <style>
        input.date {
            position: relative;
            overflow: hidden;
        }

        input.date::-webkit-calendar-picker-indicator {
            display: block;
            top: 0;
            left: 0;
            background: #0000;
            position: absolute;
            transform: scale(12)
        }
    </style>
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">User</a></li>
                        <li class="breadcrumb-item active">Daftar</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="fas fa-bullhorn"></i> Info!</h5>
                        Jika memilih tanggal (mulai dari), pastikan juga memilih tanggal (sampai dari) agar filter atau
                        export bisa diterapkan
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_add">
                                <i class="fas fa-plus-circle mx-2"></i>Tambah User</button>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" id="card_refresh">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.user.export') }}" method="get">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="gender-filter">Jenis Kelamin</label>
                                            <select class="custom-select rounded-0" name="gender_filter" id="gender-filter">
                                                @php
                                                    $statusPembayaran = App\Services\BulkData::statusPembayaran;
                                                @endphp
                                                <option value=""> Semua</option>
                                                <option value="L"> Laki laki</option>
                                                <option value="P"> Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="status-filter">Status</label>
                                            <select class="custom-select rounded-0" name="status_filter" id="status-filter">
                                                @php
                                                    $status = App\Services\BulkData::status;
                                                @endphp
                                                <option value="">Semua</option>
                                                @foreach ($status as $row)
                                                    <option value="{{ $row['id'] }}"> {{ $row['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="start-date">Mulai Dari</label>
                                            <input type="date" name="start_date" class="form-control date"
                                                id="start-date" placeholder="dd/mm/yyyy">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="end-date">Sampai Dari</label>
                                            <input type="date" name="end_date" class="form-control date" id="end-date"
                                                placeholder="dd/mm/yyyy">
                                        </div>
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button class="btn btn-primary" id="button-filter">Filter</button>
                                            <button class="btn btn-danger" id="button-reset">Reset</button>
                                            <button type="submit" class="btn btn-success" id="button-export"><i
                                                    class="fa fa-download mr-1"></i>
                                                Export Excel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <button type="button" class="btn btn-sm btn-danger mb-2" id="delete-selected">Delete All
                                Selected</button>
                            <table id="table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="check-all"></th>
                                        <th>No</th>
                                        <th>Photo</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal Tambah Kategori --}}
        <form action="#" id="form_add" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="modal fade" id="modal_add">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Tambah User</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" name="name" class="form-control" id="name"
                                    placeholder="Masukkan Nama">
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" id="username"
                                    placeholder="Masukkan Username" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" id="email"
                                    placeholder="Masukkan Email" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Telephone</label>
                                <input type="number" name="phone" class="form-control" id="phone"
                                    placeholder="Masukkan Nomor Telephone">
                            </div>
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <select class="form-control select2bs4" name="gender" id="gender"
                                    style="width: 100%;">
                                    <option selected="selected">Pilih...</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="birthday">Tanggal Lahir</label>
                                <input type="date" name="birthday" class="form-control" id="birthday"
                                    placeholder="Masukkan Tanggal Lahir">
                            </div>
                            <div class="form-group">
                                <label>Role</label>
                                <select class="form-control select2bs4" name="role" id="role"
                                    style="width: 100%;" required>
                                    <option selected="selected">Pilih...</option>
                                    <option value="admin">Admin</option>
                                    <option value="supplier">Supplier</option>
                                    <option value="member">Member</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="image">Photo</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="image" id="image">
                                        <label class="custom-file-label" for="image">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary" id="form_submit">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
    {{-- Modal Edit --}}
    <form action="#" method="POST" enctype="multipart/form-data" id="form_edit">
        @csrf
        <div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="modal_edit"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="title_edit">Edit </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id-edit" name="id_edit">
                        <div class="form-group">
                            <label for="name-edit">Nama</label>
                            <input type="text" name="name_edit" class="form-control" id="name-edit"
                                placeholder="Masukkan Nama" value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <label for="username-edit">Username</label>
                            <input type="text" name="username_edit" class="form-control" id="username-edit"
                                placeholder="Masukkan Username" value="{{ old('username') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email-edit">Email</label>
                            <input type="email" name="email_edit" class="form-control" id="email-edit"
                                placeholder="Masukkan Email" value="{{ old('email') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="phone-edit">Telephone</label>
                            <input type="number" name="phone_edit" class="form-control" id="phone-edit"
                                placeholder="Masukkan Nomor Telephone" value="{{ old('phone') }}">
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select class="form-control select2bs4" name="gender_edit" id="gender-edit"
                                style="width: 100%;">
                                <option selected="selected">Pilih...</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="birthday-edit">Tanggal Lahir</label>
                            <input type="date" name="birthday_edit" class="form-control" id="birthday-edit"
                                placeholder="Masukkan Tanggal Lahir" value="{{ old('birthday') }}">
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <select class="form-control select2bs4" name="role_edit" id="role-edit" style="width: 100%;"
                                required>
                                <option selected="selected">Pilih...</option>
                                <option value="admin">Admin</option>
                                <option value="member">Member</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="image-edit">Photo</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="hidden" name="image_old" id="image-old">
                                    <input type="file" class="custom-file-input" name="image_edit" id="image-edit">
                                    <label class="custom-file-label" id="chooseFileEdit" for="image-edit">Choose
                                        file</label>
                                </div>
                            </div>
                            {{-- <small>*Kosongkan jika tidak mengubah photo</small> --}}
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control select2bs4" name="status_edit" id="status-edit"
                                style="width: 100%;" required>
                                @php
                                    $status = App\Services\BulkData::status;
                                @endphp
                                @foreach ($status as $s)
                                    <option value="{{ $s['id'] }}">{{ $s['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@push('script')
    {{-- Select2 --}}
    <script src="{{ asset('/admin/plugins/select2/js/select2.full.min.js') }}"></script>
    {{-- Custom file input --}}
    <script src="{{ asset('/admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    {{-- Datatable --}}
    <script src="{{ asset('/admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    {{-- CKEditor --}}
    <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
    <script>
        $(document).ready(function() {
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            // data table and card refresh
            var table1 = dataTable('#table');
            $('#card_refresh').click(function(e) {
                table1.ajax.reload();
            });

            // INPUTFILE
            $(function() {
                bsCustomFileInput.init();
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            $('#form_add').submit(function(e) {
                e.preventDefault();
                var url = "{{ route('admin.user.store') }}";
                var fd = new FormData($(this)[0]);

                $.ajax({
                    type: "post",
                    url: url,
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#form_submit').attr('disabled', true);
                    },
                    success: function(response) {
                        console.log(response);
                        $('#modal_add').modal('toggle');
                        $('#form_submit').attr('disabled', false);
                        swalToast(response.status, response.message);
                        cardRefresh();
                    }
                });
            });

            $('#modal_edit').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var name = button.data('name');
                var username = button.data('username');
                var email = button.data('email');
                var phone = button.data('phone');
                var gender = button.data('gender');
                var birthday = button.data('birthday');
                var role = button.data('role');
                var status = button.data('status');
                var image = button.data('image');

                var modal = $(this);
                modal.find('#id-edit').val(id);
                modal.find('#name-edit').val(name);
                modal.find('#username-edit').val(username);
                modal.find('#email-edit').val(email);
                modal.find('#phone-edit').val(phone);
                modal.find('#gender-edit').val(gender).change();
                modal.find('#birthday-edit').val(birthday);
                modal.find('#role-edit').val(role).change();
                modal.find('#status-edit').val(status).change();
                modal.find('#image-old').val(image);

                if (image) {
                    $('#chooseFileEdit').html(image);
                } else {
                    $('#chooseFileEdit').html('Pilih File');
                }
            })

            $('#form_edit').submit(function(e) {
                e.preventDefault();
                var url = "{{ route('admin.user.update') }}";
                var fd = new FormData($(this)[0]);
                $.ajax({
                    type: "post",
                    url: url,
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#form_submit').attr('disabled', true);
                    },
                    success: function(response) {
                        console.log(response);
                        $('#modal_edit').modal('toggle');
                        $('#form_submit').attr('disabled', false);
                        swalToast(response.status, response.message);
                        cardRefresh();
                    }
                });
            });

            $('#check-all').on('click', function() {
                if ($(this).is(':checked', true)) {
                    $('.check').prop('checked', true);
                } else {
                    $('.check').prop('checked', false);
                }
            });

            $('#delete-selected').on('click', function() {
                var id = [];
                Swal.fire({
                    title: 'Apakah kamu yakin ingin menghapus data yang dipilih?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Iya',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('.check:checked').each(function() {
                            id.push($(this).val());
                        });

                        if (id.length > 0) {
                            var url = "{{ route('admin.user.deleteAll') }}"
                            $.ajax({
                                type: "get",
                                url: url,
                                data: {
                                    id: id
                                },
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content')
                                },
                                success: function(response) {
                                    console.log(response);
                                    $('#table').DataTable().ajax.reload(null, false);
                                    swalToast(response.status, response.message);
                                    $('#check-all').prop('checked', false)
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Mohon untuk checklist data terlebih dahulu!',
                            })
                        }
                    }
                })
            });
        });
    </script>
    <script>
        function deleteData(event) {
            event.preventDefault();
            var id = event.target.querySelector('input[name="id"]').value;
            var name = event.target.querySelector('input[name="name"]').value;
            Swal.fire({
                title: 'Yakin ingin menghapus data produk dengan nama ' + name + ' ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ route('admin.user.delete') }}";
                    var fd = new FormData($(event.target)[0]);
                    $.ajax({
                        type: "post",
                        url: url,
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            $('#table').DataTable().ajax.reload(null, false);
                            swalToast(response.status, response.message);
                        }
                    });
                }
            })
        }

        function dataTable(name) {
            var url = "{{ route('admin.user.getData') }}";
            var datatable = $(name).DataTable({
                responsive: true,
                autoWidth: false,
                processing: true,
                serverSide: true,
                language: {
                    searchPlaceholder: "Cari...",
                },
                "order": [
                    [0, "desc"]
                ],
                search: {
                    return: true,
                },
                ajax: {
                    url: url,
                    data: function(d) {
                        d.genderFilter = $('#gender-filter').val();
                        d.statusFilter = $('#status-filter').val();
                        d.startDate = $('#start-date').val();
                        d.endDate = $('#end-date').val();
                    }
                },
                deferRender: true,
                columnDefs: [{
                    orderable: false,
                    targets: 0,
                    width: '25px'
                }],
                columns: [{
                        data: 'checkbox',
                        name: 'checkbox',
                        className: 'align-middle',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        "data": "id",
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        className: 'align-middle'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        className: 'align-middle',
                    },
                    {
                        data: 'username',
                        name: 'username',
                        className: 'align-middle'
                    },
                    {
                        data: 'email',
                        name: 'email',
                        className: 'align-middle'
                    },
                    {
                        data: 'gender',
                        name: 'gender',
                        className: 'align-middle'
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                        className: 'align-middle'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'align-middle'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'align-middle'
                    },
                ]
            })

            $('#button-filter').click(function(e) {
                e.preventDefault();
                var genderFilter = $('#gender-filter').val();
                var statusFilter = $('#status-filter').val();
                var startDate = $('#start-date').val();
                var endDate = $('#end-date').val();

                if (startDate !== '' && endDate === '') {
                    alert('jika mengisi (mulai dari), isi juga (sampai dari)')
                }

                $('#table').DataTable().ajax.reload(null, false);
            });

            $('#button-reset').click(function(e) {
                e.preventDefault();
                var genderFilter = $('#gender-filter').val('');
                var statusFilter = $('#status-filter').val('');
                var startDate = $('#start-date').val('');
                var endDate = $('#end-date').val('');

                $('#table').DataTable().ajax.reload(null, false);
            });

            datatable.buttons().container().appendTo(name + '_wrapper .col-md-6:eq(0)');
            return datatable;
        }

        function cardRefresh() {
            var cardRefresh = document.querySelector('#card_refresh');
            cardRefresh.click();
        }

        function swalToast(status, message) {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                customClass: 'toast-content'
            });
            if (status == 200) {
                Toast.fire({
                    icon: 'success',
                    title: message
                });
            } else {
                Toast.fire({
                    icon: 'error',
                    title: message
                });
            }
        }
    </script>
@endpush
