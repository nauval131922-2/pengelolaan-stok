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
                            <li class="breadcrumb-item active">Pengguna</li>
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
                                                <th>Nama</th>
                                                <th>Username</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div><!-- end col -->
                            </div>



                            <div class="tab-pane fade" id="tambah" role="tabpanel" aria-labelledby="tambah-tab">
                                <form enctype="multipart/form-data" id="formTambahData" method="POST">
                                    @csrf
                                    <input class="form-control" type="hidden" name="idData" id="id" value=""
                                        placeholder="">

                                    <div class="row mb-1 mt-2">
                                        <div class="col-lg-6 col-md-6">
                                            <label for="name" class="col-sm-12 col-form-label">Name <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="name" id="name"
                                                value="" placeholder="" required>
                                            <div class="my-2">
                                                <span class="text-danger error-text name_error"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-1">
                                        <div class="col-lg-6 col-md-6">
                                            <label for="username" class="col-sm-12 col-form-label">Username <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="username" id="username"
                                                value="" placeholder="" required>
                                            <div class="my-2">
                                                <span class="text-danger error-text username_error"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-1">
                                        <div class="col-lg-6 col-md-6">
                                            <label for="password" class="col-sm-12 col-form-label">Password <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="password" name="password" id="password"
                                                value="" placeholder="">
                                            <div class="my-2">
                                                <span class="text-danger error-text password_error"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-1">
                                        <div class="col-lg-6 col-md-6">
                                            <label for="confirmPassword" class="col-sm-12 col-form-label">Confirm Password
                                                <span class="text-danger">*</span></label>
                                            <input class="form-control" type="password" name="confirmPassword"
                                                id="confirmPassword" value="" placeholder="">
                                            <div class="my-2">
                                                <span class="text-danger error-text confirmPassword_error"></span>
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

            fetchData()

        });

        // buatkan function fecthData
        function fetchData() {
            $.ajax({
                url: '{{ route('pengguna-fetch') }}',
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
                            value.name,
                            value.username,
                        ]).draw(false);
                    });
                    table.columns.adjust().draw();
                }
            });
        }

        function deleteData(id) {
            if (confirm('Apakah anda yakin ingin menghapus data ini?')) {

                $.ajax({
                    url: '{{ url('pengguna/hapus') }}/' + id,
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

            // Jika id kosong (untuk simpan data baru)
            if (id == '') {
                $.ajax({
                    url: '{{ route('pengguna-simpan') }}',
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
                            $('.select2').val(null).trigger('change');
                            $(document).find('span.error-text').text('');
                        }
                    }
                });
            } else { // Jika id ada (untuk update data)
                $.ajax({
                    url: '{{ url('pengguna/update') }}/' + id,
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
                            $('.select2').val(null).trigger('change');
                            $(document).find('span.error-text').text('');

                            // ubah nama #tambah-tab dari "Ubah" {{ $sub_title }} menjadi "Tambah" {{ $sub_title }}
                            $('#tambah-tab').text('Tambah {{ $sub_title }}');
                        }
                    }
                });
            }
        });



        // buatkan function editData
        function editData(id) {
            $.ajax({
                url: '{{ url('pengguna/edit') }}/' + id, // Sesuaikan URL sesuai kebutuhan Anda
                type: 'GET',
                success: function(response) {
                    // Periksa apakah data berhasil ditemukan
                    if (response && response.data) {
                        // Aktifkan tab dengan id tambah (edit)
                        $('#daftar-tab').removeClass('active');
                        $('#tambah-tab').addClass('active');
                        $('#daftar').removeClass('show active');
                        $('#tambah').addClass('show active');

                        // Isi field dengan data yang diterima
                        $('#id').val(response.data.id);
                        $('#name').val(response.data.name);
                        $('#username').val(response.data.username);

                        // Jika ada field lain seperti keterangan, sesuaikan juga
                        // $('#keterangan').val(response.data.keterangan);

                        // Ubah nama tab dari "Tambah" menjadi "Ubah"
                        $('#tambah-tab').text('Ubah {{ $sub_title }}');
                    } else {
                        alert('Data tidak ditemukan.');
                    }
                },
                error: function(xhr, status, error) {
                    alert('Terjadi kesalahan saat memuat data: ' + error);
                }
            });
        }



        // jika selain #tambah-tab di klik
        $('#daftar-tab').on('click', function() {
            // kosongkan form
            $('#formTambahData')[0].reset();
            $('#id').val('');
            $('.select2').val(null).trigger('change');
            $(document).find('span.error-text').text('');

            // ubah nama #tambah-tab dari "Ubah" {{ $sub_title }} menjadi "Tambah" {{ $sub_title }}
            $('#tambah-tab').text('Tambah {{ $sub_title }}');
        })

        $('#tambah-tab').on('click', function() {
            // jika #id kosong
            if ($('#id').val() == '') {
                // tanggal otomatis hari ini
                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                var yyyy = today.getFullYear();

                today = yyyy + '-' + mm + '-' + dd;
                $('#tanggal').val(today);
            }
        })
    </script>
@endsection
