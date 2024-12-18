@extends('backend.main')

@section('title')
    Dashboard | {{ $title }}
@endsection

@section('content')
    <div class="custom-container">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{ $title }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Stok</a></li>
                            <li class="breadcrumb-item active">Data</li>
                            <li class="breadcrumb-item active">Master Satuan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="daftar-tab" data-bs-toggle="tab"
                                    data-bs-target="#daftar" type="button" role="tab" aria-controls="daftar"
                                    aria-selected="true">Daftar
                                    {{ $sub_title }}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tambah-tab" data-bs-toggle="tab" data-bs-target="#tambah"
                                    type="button" role="tab" aria-controls="tambah" aria-selected="false">Tambah
                                    {{ $sub_title }}</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="daftar" role="tabpanel"
                                aria-labelledby="daftar-tab">
                                <div class="col-xl-12 col-md-12" style="padding-top: 15px">
                                    <table id="datatable"
                                        class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline collapsed"
                                        style="border-collapse: collapse; border-spacing: 0px; width: 100%;" role="grid"
                                        aria-describedby="datatable-buttons_info">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Action</th>
                                                <th>Nama Satuan</th>
                                                {{-- @can('admin') --}}

                                                {{-- @endcan --}}
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div><!-- end col -->
                            </div>

                            <div class="tab-pane fade" id="tambah" role="tabpanel" aria-labelledby="tambah-tab">
                                <form enctype="multipart/form-data" id="formTambahData" method="POST">
                                    @csrf
                                    <input class="form-control" type="hidden" name="id" id="id" value=""
                                        placeholder="">

                                    <div class="row mb-1 mt-2">
                                        <div class="col-lg-6 col-md-6">
                                            <label for="satuan" class="col-sm-12 col-form-label">Satuan <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="satuan" id="satuan"
                                                value="" placeholder="" required>
                                            <div class="my-2">
                                                <span class="text-danger error-text satuan_error"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-1">
                                        <div class="col-lg-6 col-md-6">
                                            <button class="btn btn-dark" id="btnEditData" data-bs-toggle="modal"
                                                data-bs-target="#exampleModalScrollable" style="margin-right: 5px;"
                                                onclick=""><i class="ri-save-2-line align-middle me-1"></i><span
                                                    style="vertical-align: middle">Save</span></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>


    <script>
        $(document).ready(function() {

            // buatkan alert saat pertama kali halaman di load
            fetchData();

        });

        // buatkan function fecthData
        function fetchData() {
            $.ajax({
                url: '{{ route('master-satuan-fetch') }}',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    var table = $('#datatable').DataTable();

                    if ($.fn.DataTable.isDataTable('#datatable')) {
                        table.clear();
                    }
                    var data = response.data;
                    $.each(data, function(key, value) {
                        var editButton = '';
                        var deleteButton = '';


                        editButton =
                            '<button class="btn btn-light btn-sm" id="btnEditData" data-bs-toggle="modal" data-bs-target="#exampleModalScrollable" style="margin-right: 5px;" onclick="editData(' +
                            value.id +
                            ')"><i class="ri-edit-2-line align-middle me-1"></i><span style="vertical-align: middle">Koreksi</span></button>';

                        deleteButton =
                            '<button class="btn btn-danger btn-sm" id="delete" onclick="deleteData(' +
                            value.id +
                            ')"><i class="ri-delete-bin-2-line align-middle me-1"></i><span style="vertical-align: middle">Hapus</span></button>';


                        table.row.add([
                            (key + 1),
                            editButton + deleteButton,
                            value.nama_satuan
                        ]).draw(false);
                    });
                    table.columns.adjust().draw();
                }
            });
        }

        function deleteData(id) {
            if (confirm('Apakah anda yakin ingin menghapus data ini?')) {

                $.ajax({
                    url: '{{ url('master-satuan/hapus') }}/' + id,
                    type: 'get',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        fetchData();

                        alert(response.message);
                    }
                });
            }
        }

        $('#formTambahData').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData($('#formTambahData')[0]);

            // deklarasikan id
            let id = $('#id').val();

            if (id == '') {
                $.ajax({
                    url: '{{ route('master-satuan-simpan') }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $(document).find('span.error-text').text('');
                    },
                    success: function(response) {

                        if (response.status == 'error') {
                            $.each(response.message, function(prefix, val) {
                                $('span.' + prefix + '_error').text(val[0]);
                            });
                        } else if (response.status == 'error2') {
                            // tampilkan alert
                            alert(response.message);
                        } else {
                            // fetch data
                            fetchData();

                            // tampilkan alert
                            alert(response.message);

                            // aktifkan tab dengan id daftar
                            $('#daftar-tab').addClass('active');
                            $('#tambah-tab').removeClass('active');
                            $('#daftar').addClass('show active');
                            $('#tambah').removeClass('show active');

                            // kosongkan form
                            $('#formTambahData')[0].reset();
                            $('#id').val('');
                        }
                    }
                })
            } else {
                $.ajax({
                    url: '{{ url('master-satuan/update') }}/' + id,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $(document).find('span.error-text').text('');
                    },
                    success: function(response) {

                        if (response.status == 'error') {
                            $.each(response.message, function(prefix, val) {
                                $('span.' + prefix + '_error').text(val[0]);
                            });
                        } else if (response.status == 'error2') {
                            // tampilkan alert
                            alert(response.message);
                        } else {
                            // fetch data
                            fetchData();

                            // tampilkan alert
                            alert(response.message);

                            // aktifkan tab dengan id daftar
                            $('#daftar-tab').addClass('active');
                            $('#tambah-tab').removeClass('active');
                            $('#daftar').addClass('show active');
                            $('#tambah').removeClass('show active');

                            // kosongkan form
                            $('#formTambahData')[0].reset();
                            $('#id').val('');

                            // ubah nama #tambah-tab dari "Ubah" {{ $sub_title }} menjadi "Tambah" {{ $sub_title }}
                            $('#tambah-tab').text('Tambah {{ $sub_title }}');
                        }
                    }
                })
            }
        });

        // buatkan function editData
        function editData(id) {
            $.ajax({
                url: '{{ url('master-satuan/edit') }}/' + id,
                type: 'get',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // aktifkan tab dengan id tambah
                    $('#daftar-tab').removeClass('active');
                    $('#tambah-tab').addClass('active');
                    $('#daftar').removeClass('show active');
                    $('#tambah').addClass('show active');

                    $('#id').val(response.data.id);
                    $('#satuan').val(response.data.nama_satuan);

                    // ubah nama #tambah-tab dari "Tambah" {{ $sub_title }} menjadi "Ubah" {{ $sub_title }}
                    $('#tambah-tab').text('Ubah {{ $sub_title }}');
                }
            })
        }

        // jika selain #tambah-tab di klik
        $('#daftar-tab').on('click', function() {
            // kosongkan form
            $('#formTambahData')[0].reset();
            $('#id').val('');

            // ubah nama #tambah-tab dari "Ubah" {{ $sub_title }} menjadi "Tambah" {{ $sub_title }}
            $('#tambah-tab').text('Tambah {{ $sub_title }}');
        })
    </script>
@endsection
