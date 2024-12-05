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
                                                <th>Nama Barang</th>
                                                <th>Kategori</th>
                                                <th>Satuan</th>
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
                                        <div class="col-lg-3 col-md-3">
                                            <label for="kategori" class="col-sm-12 col-form-label">Kategori <span
                                                    class="text-danger">*</span></label>

                                            <div class="d-flex">
                                                <!-- Tombol Reload -->
                                                <button type="button" id="reload-kategori"
                                                    class="btn btn-sm btn-outline-light ml-2" title="Reload kategori">
                                                    <i class="fa fa-sync-alt"></i> <!-- Icon reload -->
                                                </button>
                                                <!-- Dropdown kategori -->
                                                <select class="select2" name="kategori" id="kategori" required>
                                                    <option value=""></option>
                                                </select>
                                            </div>

                                            <div class="my-2">
                                                <span class="text-danger error-text kategori_error"></span>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-3">
                                            <label for="satuan" class="col-sm-12 col-form-label">Satuan <span
                                                    class="text-danger">*</span></label>

                                            <div class="d-flex">
                                                <!-- Tombol Reload -->
                                                <button type="button" id="reload-satuan"
                                                    class="btn btn-sm btn-outline-light ml-2" title="Reload Satuan">
                                                    <i class="fa fa-sync-alt"></i> <!-- Icon reload -->
                                                </button>
                                                <!-- Dropdown Satuan -->
                                                <select class="select2" name="satuan" id="satuan" required>
                                                    <option value=""></option>
                                                </select>
                                            </div>

                                            <div class="my-2">
                                                <span class="text-danger error-text satuan_error"></span>
                                            </div>
                                        </div>
                                    </div>




                                    <div class="row mb-1 mt-2">
                                        <div class="col-lg-6 col-md-6">
                                            <label for="barang" class="col-sm-12 col-form-label">Barang <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="barang" id="barang"
                                                value="" placeholder="" required>
                                            <div class="my-2">
                                                <span class="text-danger error-text barang_error"></span>
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

            // Memuat data pada saat halaman dimuat 
            fetchSatuanData();

            fetchKategoriData();
        });

        // button reload satuan
        $('#reload-satuan').on('click', function() {
            fetchSatuanData();
        });

        // button reload kategori
        $('#reload-kategori').on('click', function() {
            fetchKategoriData();
        })

        // Fokus ke kotak pencarian ketika dropdown dibuka dan panggil fetchSatuanData 
        $('#satuan').on('select2:open', function() {
            // Panggil fetchSatuanData saat dropdown dibuka 
            // fetchSatuanData();

            const searchField = document.querySelector('.select2-search__field');
            if (searchField) {
                searchField.focus();
            }

        });

        // Fokus ke kotak pencarian ketika dropdown dibuka dan panggil fetchKategoriData 
        $('#kategori').on('select2:open', function() {
            // Panggil fetchSatuanData saat dropdown dibuka 
            // fetchSatuanData();

            const searchField = document.querySelector('.select2-search__field');
            if (searchField) {
                searchField.focus();
            }

        });

        // buatkan function fetchSatuanData
        function fetchSatuanData() {
            $.ajax({
                url: '{{ route('master-barang-fetch-satuan') }}',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    let satuanSelect = $('#satuan');
                    satuanSelect.empty().append('<option value=""></option>');
                    // Hapus opsi lama dan tambahkan placeholder 
                    $.each(response.data, function(index, item) {
                        satuanSelect.append(new Option(item.nama_satuan, item.id));
                    });
                }
            });
        }

        // buatkan function fetchKategoriData
        function fetchKategoriData() {
            $.ajax({
                url: '{{ route('master-barang-fetch-kategori') }}',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    let kategoriSelect = $('#kategori');
                    kategoriSelect.empty().append('<option value=""></option>');
                    // Hapus opsi lama dan tambahkan placeholder 
                    $.each(response.data, function(index, item) {
                        kategoriSelect.append(new Option(item.nama_kategori, item.id));
                    });
                }
            });
        }

        // buatkan function fecthData
        function fetchData() {
            $.ajax({
                url: '{{ route('master-barang-fetch') }}',
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
                            value.nama_barang,
                            value.satuan.nama_satuan,
                            value.kategori.nama_kategori
                        ]).draw(false);
                    });
                    table.columns.adjust().draw();
                }
            });
        }

        function deleteData(id) {
            if (confirm('Apakah anda yakin ingin menghapus data ini?')) {

                $.ajax({
                    url: '{{ url('master-barang/hapus') }}/' + id,
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
                    url: '{{ route('master-barang-simpan') }}',
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
                            $('.select2').val(null).trigger('change');
                            $(document).find('span.error-text').text('');
                        }
                    }
                })
            } else {
                $.ajax({
                    url: '{{ url('master-barang/update') }}/' + id,
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
                            $('.select2').val(null).trigger('change');
                            $(document).find('span.error-text').text('');

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
                url: '{{ url('master-barang/edit') }}/' + id,
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
                    $('#barang').val(response.data.nama_barang);
                    $('#satuan').val(response.data.satuan_id).trigger('change');
                    $('#kategori').val(response.data.kategori_id).trigger('change');

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
            $('.select2').val(null).trigger('change');
            $(document).find('span.error-text').text('');

            // ubah nama #tambah-tab dari "Ubah" {{ $sub_title }} menjadi "Tambah" {{ $sub_title }}
            $('#tambah-tab').text('Tambah {{ $sub_title }}');
        })
    </script>
@endsection
