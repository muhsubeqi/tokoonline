@extends('admin.layouts.template')
@section('title')
    Admin | Produk
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
                    <h1>Produk</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Produk</a></li>
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
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_add">
                                <i class="fas fa-plus-circle mx-2"></i>Tambah Produk</button>
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
                            <table id="table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Photo</th>
                                        <th>Produk</th>
                                        <th>Kategori</th>
                                        <th>Stok</th>
                                        <th>harga</th>
                                        <th>Upload</th>
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
                            <h4 class="modal-title">Tambah Product</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Nama Produk</label>
                                <input type="text" name="name" class="form-control" id="name"
                                    placeholder="Masukkan Nama Produk">
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug Produk</label>
                                <input type="text" name="slug" class="form-control" id="slug"
                                    placeholder="Generate Slug Otomatis" readonly>
                            </div>
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea id="description" name="description" class="form-control">{!! old('content', 'isi deskripsi') !!}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="stock">Stok Produk</label>
                                <input type="number" name="stock" class="form-control" id="stock"
                                    placeholder="Masukkan Stok Produk">
                            </div>
                            <div class="form-group">
                                <label for="weight">Berat Produk (gram)</label>
                                <input type="number" name="weight" class="form-control" id="weight"
                                    placeholder="Masukkan Berat Produk">
                            </div>
                            <div class="form-group">
                                <label for="price">Harga Produk</label>
                                <input type="number" name="price" class="form-control" id="price"
                                    placeholder="Masukkan Harga Produk">
                            </div>
                            <div class="form-group">
                                <label>Kategori</label>
                                <select class="form-control select2bs4" name="categories_id" id="categories"
                                    style="width: 100%;">
                                    <option selected="selected">Pilih Kategori</option>
                                    @foreach ($categories as $row)
                                        <option value="{{ $row->id }}"><strong>{{ $row->name }}</strong></option>
                                        @foreach ($row->children as $sub)
                                            <option value="{{ $sub->id }}"> -- {{ $sub->name }}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="photo">Photo</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="photo" id="photo">
                                        <label class="custom-file-label" for="photo">Choose file</label>
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
                            <label for="name-edit">Nama Produk</label>
                            <input type="text" name="name_edit" class="form-control" id="name-edit"
                                placeholder="Masukkan Nama Produk" value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <label for="slug-edit">Slug Produk</label>
                            <input type="text" name="slug_edit" class="form-control" id="slug-edit"
                                placeholder="Generate Slug Otomatis" value="{{ old('slug') }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea id="description-edit" name="description_edit" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="stock-edit">Stok Produk</label>
                            <input type="number" name="stock_edit" class="form-control" id="stock-edit"
                                placeholder="Masukkan Stok Produk" value="{{ old('stock') }}">
                        </div>
                        <div class="form-group">
                            <label for="weight-edit">Berat Produk (gram)</label>
                            <input type="number" name="weight_edit" class="form-control" id="weight-edit"
                                placeholder="Masukkan Berat Produk" value="{{ old('weight') }}">
                        </div>
                        <div class="form-group">
                            <label for="price-edit">Harga Produk</label>
                            <input type="number" name="price_edit" class="form-control" id="price-edit"
                                placeholder="Masukkan Harga Produk" value="{{ old('price') }}">
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <select class="form-control select2bs4" name="categories_id_edit" id="categories-edit"
                                style="width: 100%;">
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $row)
                                    <option value="{{ $row->id }}"><strong>{{ $row->name }}</strong></option>
                                    @foreach ($row->children as $sub)
                                        <option value="{{ $sub->id }}"> -- {{ $sub->name }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="photo">Photo</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="hidden" name="photo_old" id="photo-old">
                                    <input type="file" class="custom-file-input" name="photo_edit" id="photo-edit">
                                    <label class="custom-file-label" id="chooseFileEdit" for="photo-edit">Choose
                                        file</label>
                                </div>
                            </div>
                            <small>*Kosongkan jika tidak mengubah photo</small>
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

            // otomatic slug generate
            $("#name").keyup(function() {
                var Text = $(this).val();
                Text = Text.toLowerCase();
                Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
                $("#slug").val(Text);
            });

            // otomatic slug generate edit
            $("#name-edit").keyup(function() {
                var Text = $(this).val();
                Text = Text.toLowerCase();
                Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
                $("#slug-edit").val(Text);
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
                var url = "{{ route('admin.product.store') }}";
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
                var slug = button.data('slug');
                var description = button.data('description');
                var stock = button.data('stock');
                var weight = button.data('weight');
                var price = button.data('price');
                var categories_id = button.data('categories_id');
                var photo = button.data('photo');

                description = decodeURIComponent(description);

                var modal = $(this);
                modal.find('#id-edit').val(id);
                modal.find('#name-edit').val(name);
                modal.find('#slug-edit').val(slug);
                modal.find('#description-edit').val(description);
                modal.find('#description-edit').html(description);
                modal.find('#stock-edit').val(stock);
                modal.find('#weight-edit').val(weight);
                modal.find('#price-edit').val(price);
                modal.find('#categories-edit').val(categories_id).change();
                modal.find('#photo-old').val(photo);

                if (photo) {
                    $('#chooseFileEdit').html(photo);
                } else {
                    $('#chooseFileEdit').html('Pilih File');
                }
            })

            $('#form_edit').submit(function(e) {
                e.preventDefault();
                var url = "{{ route('admin.product.update') }}";
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
                    var url = "{{ route('admin.product.delete') }}";
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
            var url = "{{ route('admin.product.getData') }}";
            var datatable = $(name).DataTable({
                responsive: true,
                autoWidth: false,
                processing: true,
                serverSide: true,
                "order": [
                    [0, "desc"]
                ],
                search: {
                    return: true,
                },
                ajax: {
                    url: url,
                },
                deferRender: true,
                columns: [{
                        "data": "id",
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        className: 'align-middle'
                    },
                    {
                        data: 'photo',
                        name: 'photo',
                        className: 'align-middle',
                    },
                    {
                        data: 'name',
                        name: 'name',
                        className: 'align-middle'
                    },
                    {
                        data: 'cat',
                        name: 'cat',
                        className: 'align-middle'
                    },
                    {
                        data: 'stock',
                        name: 'stock',
                        className: 'align-middle'
                    },
                    {
                        data: 'price',
                        name: 'price',
                        className: 'align-middle'
                    },
                    {
                        data: 'uploader',
                        name: 'uploader',
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
            })
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
    <script>
        var route_prefix = "/filemanager";
    </script>

    <!-- CKEditor init -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/ckeditor/4.5.11/ckeditor.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/ckeditor/4.5.11/adapters/jquery.js"></script>
    <script>
        $('textarea[name=description]').ckeditor({
            height: 100,
            filebrowserImageBrowseUrl: route_prefix + '?type=Images',
            filebrowserImageUploadUrl: route_prefix + '/upload?type=Images&_token={{ csrf_token() }}',
            filebrowserBrowseUrl: route_prefix + '?type=Files',
            filebrowserUploadUrl: route_prefix + '/upload?type=Files&_token={{ csrf_token() }}'
        });
    </script>

    <script>
        $('textarea[name=description_edit]').ckeditor({
            height: 100,
            filebrowserImageBrowseUrl: route_prefix + '?type=Images',
            filebrowserImageUploadUrl: route_prefix + '/upload?type=Images&_token={{ csrf_token() }}',
            filebrowserBrowseUrl: route_prefix + '?type=Files',
            filebrowserUploadUrl: route_prefix + '/upload?type=Files&_token={{ csrf_token() }}'
        });
    </script>

    <!-- TinyMCE init -->
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>
        var editor_config = {
            path_absolute: "",
            selector: "textarea[name=tm]",
            plugins: [
                "link image"
            ],
            relative_urls: false,
            height: 129,
            file_browser_callback: function(field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName(
                    'body')[0].clientWidth;
                var y = window.innerHeight || document.documentElement.clientHeight || document
                    .getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + route_prefix + '?field_name=' + field_name;
                if (type == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.open({
                    file: cmsURL,
                    title: 'Filemanager',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: "yes",
                    close_previous: "no"
                });
            }
        };

        tinymce.init(editor_config);
    </script>

    <script>
        {!! \File::get(base_path('vendor/unisharp/laravel-filemanager/public/js/stand-alone-button.js')) !!}
    </script>
    <script>
        $('#lfm').filemanager('image', {
            prefix: route_prefix
        });
        // $('#lfm').filemanager('file', {prefix: route_prefix});
    </script>

    <script>
        var lfm = function(id, type, options) {
            let button = document.getElementById(id);

            button.addEventListener('click', function() {
                var route_prefix = (options && options.prefix) ? options.prefix : '/filemanager';
                var target_input = document.getElementById(button.getAttribute('data-input'));
                var target_preview = document.getElementById(button.getAttribute('data-preview'));

                window.open(route_prefix + '?type=' + options.type || 'file', 'FileManager',
                    'width=900,height=600');
                window.SetUrl = function(items) {
                    var file_path = items.map(function(item) {
                        return item.url;
                    }).join(',');

                    // set the value of the desired input to image url
                    target_input.value = file_path;
                    target_input.dispatchEvent(new Event('change'));

                    // clear previous preview
                    target_preview.innerHtml = '';

                    // set or change the preview image src
                    items.forEach(function(item) {
                        let img = document.createElement('img')
                        img.setAttribute('style', 'height: 5rem')
                        img.setAttribute('src', item.thumb_url)
                        target_preview.appendChild(img);
                    });

                    // trigger change event
                    target_preview.dispatchEvent(new Event('change'));
                };
            });
        };

        lfm('lfm2', 'file', {
            prefix: route_prefix
        });
    </script>

    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js"></script>
    <style>
        .popover {
            top: auto;
            left: auto;
        }
    </style>
    <script>
        $(document).ready(function() {

            // Define function to open filemanager window
            var lfm = function(options, cb) {
                var route_prefix = (options && options.prefix) ? options.prefix : '/filemanager';
                window.open(route_prefix + '?type=' + options.type || 'file', 'FileManager',
                    'width=900,height=600');
                window.SetUrl = cb;
            };

            // Define LFM summernote button
            var LFMButton = function(context) {
                var ui = $.summernote.ui;
                var button = ui.button({
                    contents: '<i class="note-icon-picture"></i> ',
                    tooltip: 'Insert image with filemanager',
                    click: function() {

                        lfm({
                            type: 'image',
                            prefix: '/filemanager'
                        }, function(lfmItems, path) {
                            lfmItems.forEach(function(lfmItem) {
                                context.invoke('insertImage', lfmItem.url);
                            });
                        });

                    }
                });
                return button.render();
            };

            // Initialize summernote with LFM button in the popover button group
            // Please note that you can add this button to any other button group you'd like
            $('#summernote-editor').summernote({
                toolbar: [
                    ['popovers', ['lfm']],
                ],
                buttons: {
                    lfm: LFMButton
                }
            })
        });
    </script>
@endpush
