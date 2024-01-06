@extends('admin.layouts.template')
@section('title')
    Admin | Category
@endsection
@push('css')
    {{-- Select2 --}}
    <link rel="stylesheet" href="{{ asset('/admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    {{-- Datatable --}}
    <link rel="stylesheet" href="{{ asset('/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kategori</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Kategori</a></li>
                        <li class="breadcrumb-item active">Daftar</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Data</h3>
                        </div>
                        <form action="#" method="POST" id="form_add" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Nama</label>
                                    <input type="name" class="form-control" name="name" id="name"
                                        placeholder="Masukkan Nama">
                                </div>
                                <div class="form-group">
                                    <label for="slug">Slug</label>
                                    <input type="slug" class="form-control" name="slug" id="slug"
                                        placeholder="Generate slug otomatis" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="icon">Icon</label>
                                    <input type="icon" class="form-control" name="icon" id="icon"
                                        placeholder="Masukkan Icon">
                                </div>
                                <div class="form-group">
                                    <label for="parent">Parent Kategori</label>
                                    <select class="form-control select2bs4" name="parent_id" id="parent">
                                        <option value="" selected>Pilih ...</option>
                                        @foreach ($categories as $row)
                                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">

                        </div>
                        <div class="card-body">
                            <table id="table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kategori</th>
                                        <th>Sub Kategori</th>
                                        <th>Icon</th>
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
                                <label for="name-edit">Name</label>
                                <input type="text" name="name_edit" class="form-control" id="name-edit"
                                    placeholder="Input Category Name" value="{{ old('name') }}">
                            </div>
                            <div class="form-group">
                                <label for="slug-edit">Slug</label>
                                <input type="text" name="slug_edit" class="form-control" id="slug-edit"
                                    placeholder="Input Slug Name" value="{{ old('slug') }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="icon-edit">Icon</label>
                                <input type="icon" class="form-control" name="icon_edit" id="icon-edit"
                                    placeholder="Masukkan Icon" value="{{ old('icon') }}">
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
    </section>
@endsection
@push('script')
    {{-- Select2 --}}
    <script src="{{ asset('/admin/plugins/select2/js/select2.full.min.js') }}"></script>
    {{-- Datatable --}}
    <script src="{{ asset('/admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            // otomatic slug generate
            $("#name").keyup(function() {
                var Text = $(this).val();
                Text = Text.toLowerCase();
                Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
                $("#slug").val(Text);
            });

            // Generate Slug edit
            $("#name-edit").keyup(function() {
                var Text = $(this).val();
                Text = Text.toLowerCase();
                Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
                $("#slug-edit").val(Text);
            });

            $('.select2bs4edit').select2({
                theme: 'bootstrap4'
            })

        })
    </script>
    <script>
        $(document).ready(function() {
            $(function DataTable() {
                var table = $('#table').DataTable({
                    responsive: true,
                    autoWidth: false,
                    processing: true,
                    serverSide: true,
                    "order": [
                        [0, "desc"]
                    ],
                    ajax: "{{ route('admin.category.getData') }}",
                    columns: [{
                            "data": "id",
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            },
                            className: 'align-middle'
                        },
                        {
                            data: 'name',
                            name: 'name',
                            className: 'align-middle'
                        },
                        {
                            data: 'subCategory',
                            name: 'subCategory',
                            className: 'align-middle',
                            searchable: false
                        },
                        {
                            data: 'icon',
                            name: 'icon',
                            className: 'align-middle'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: true,
                            searchable: true,
                            className: 'align-middle'
                        },
                    ]
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#form_add').submit(function(e) {
                e.preventDefault();
                var url = "{{ route('admin.category.store') }}";
                var fd = new FormData($(this)[0]);

                $.ajax({
                    type: "POST",
                    url: url,
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#table').DataTable().ajax.reload(null, false);
                        // window.location.reload();
                        $("#parent").val('').trigger('change');
                        swalToast(response.status, response.message);
                        document.getElementById("form_add").reset();
                    }
                });
            });
        });

        $('#modal_edit').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');
            var slug = button.data('slug');
            var icon = button.data('icon');

            var modal = $(this);
            modal.find('#id-edit').val(id);
            modal.find('#name-edit').val(name);
            modal.find('#slug-edit').val(slug);
            modal.find('#icon-edit').val(icon);
        })

        $('#form_edit').submit(function(e) {
            e.preventDefault();
            var url = "{{ route('admin.category.update') }}";
            var fd = new FormData($(this)[0]);
            $.ajax({
                type: "post",
                url: url,
                data: fd,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    $('#modal_edit').modal('toggle');
                    $('#table').DataTable().ajax.reload(null, false);
                    swalToast(response.status, response.message);
                }
            });
        });
    </script>
    <script>
        function deleteData(event) {
            event.preventDefault();
            var id = event.target.querySelector('input[name="id"]').value;
            var name = event.target.querySelector('input[name="name"]').value;
            Swal.fire({
                title: 'Yakin ingin menghapus data kategori dengan nama ' + name + ' ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ route('admin.category.delete') }}";
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
