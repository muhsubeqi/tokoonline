@extends('admin.layouts.template')
@section('title')
    Admin | Sub Kategori
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
                    <h1>Sub Kategori</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Sub Kategori</a></li>
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
                    <div class="card">
                        <div class="card-header">
                            <a href="#" class="btn btn-sm btn-info"><i class="fas fa-info mr-1"></i>
                                <strong>{{ $category->name }}</strong></a>
                            <a href="{{ route('admin.category') }}" class="btn btn-sm btn-secondary"><i
                                    class="fas fa-chevron-left mr-1"></i> Kembali</a>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Sub Kategori</th>
                                        <th>Slug</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($sub as $row)
                                        <tr>
                                            <td class="align-middle">{{ $i }}</td>
                                            <td class="align-middle">{{ $row->name }}</td>
                                            <td class="align-middle">{{ $row->slug }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        Klik
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <button type="button" class="dropdown-item" data-toggle="modal"
                                                            data-target="#modal_edit" data-id="{{ $row->id }}"
                                                            data-name="{{ $row->name }}"
                                                            data-slug="{{ $row->slug }}"
                                                            data-icon="{{ $row->icon }}"
                                                            data-parent_id="{{ $row->parent_id }}">Edit</button>
                                                        <form action="" onsubmit="deleteData(event)" method="POST">
                                                            @method('DELETE')
                                                            @csrf
                                                            <input type="hidden" name="id"
                                                                value="{{ $row->id }}">
                                                            <input type="hidden" name="name"
                                                                value="{{ $row->name }}">
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
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
                            <div class="form-group">
                                <label for="parent-edit">Parent Kategori</label>
                                <select class="form-control select2bs4edit" name="parent_id_edit" id="parent-edit">
                                    <option value="">Pilih ...</option>
                                    @foreach ($categories as $row)
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
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
        $(document).ready(function() {

            // data table and card refresh
            $('#table').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
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
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#modal_edit').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var name = button.data('name');
                var slug = button.data('slug');
                var icon = button.data('icon');
                var parent_id = button.data('parent_id');

                var modal = $(this);
                modal.find('#id-edit').val(id);
                modal.find('#name-edit').val(name);
                modal.find('#slug-edit').val(slug);
                modal.find('#icon-edit').val(icon);
                modal.find('#parent-edit').val(parent_id).change();
            })

            $('#form_edit').submit(function(e) {
                e.preventDefault();
                var url = "{{ route('admin.category.updateSubCategory') }}";
                var fd = new FormData($(this)[0]);
                $.ajax({
                    type: "post",
                    url: url,
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#modal_edit').modal('toggle');
                        window.location.reload();
                    }
                });
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
                    var url = "{{ route('admin.category.deleteSubCategory') }}";
                    var fd = new FormData($(event.target)[0]);
                    $.ajax({
                        type: "post",
                        url: url,
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            window.location.reload();
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
