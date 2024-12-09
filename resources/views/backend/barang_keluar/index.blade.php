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
                            <li class="breadcrumb-item active">Mutasi</li>
                            <li class="breadcrumb-item active">Barang Keluar</li>
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
                                                <th>Tanggal</th>
                                                <th>Nama Barang</th>
                                                <th>Kategori</th>
                                                <th>Qty</th>
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
                                    <input class="form-control" type="hidden" name="idData" id="id" value=""
                                        placeholder="">

                                    <div class="row mb-1 mt-2">
                                        <div class="col-lg-6 col-md-6">
                                            <label for="tanggal" class="col-sm-12 col-form-label">Tanggal <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="date" name="tanggal" id="tanggal"
                                                required>
                                            <div class="my-2">
                                                <span class="text-danger error-text tanggal_error"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-1">
                                        <div class="col-lg-6 col-md-6">
                                            <label for="nama_barang" class="col-sm-12 col-form-label">Nama Barang <span
                                                    class="text-danger">*</span></label>

                                            <div class="d-flex">
                                                <!-- Tombol Reload -->
                                                <button type="button" id="reload-nama-barang"
                                                    class="btn btn-sm btn-outline-light ml-2" title="Reload nama_barang">
                                                    <i class="fa fa-sync-alt"></i> <!-- Icon reload -->
                                                </button>
                                                <!-- Dropdown nama_barang -->
                                                <select class="select2" name="nama_barang" id="nama_barang" required>
                                                    <option value=""></option>
                                                </select>
                                            </div>

                                            <div class="my-2">
                                                <span class="text-danger error-text nama_barang_error"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-1">
                                        <div class="col-lg-3 col-md-3">
                                            <label for="kategori" class="col-sm-12 col-form-label">Kategori</label>

                                            <input class="form-control" type="text" name="kategori" id="kategori"
                                                value="" placeholder="" readonly>

                                            <div class="my-2">
                                                <span class="text-danger error-text kategori_error"></span>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-3">
                                            <label for="satuan" class="col-sm-12 col-form-label">Satuan</label>

                                            <input class="form-control" type="text" name="satuan" id="satuan"
                                                value="" placeholder="" readonly>

                                            <div class="my-2">
                                                <span class="text-danger error-text satuan_error"></span>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row mb-1">
                                        <div class="col-lg-6 col-md-6">
                                            <label for="saldo" class="col-sm-12 col-form-label">Saldo</label>
                                            <input class="form-control" type="number" name="saldo" id="saldo"
                                                value="" placeholder="" readonly>
                                            <div class="my-2">
                                                <span class="text-danger error-text saldo_error"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-1">
                                        <div class="col-lg-6 col-md-6">
                                            <label for="qty" class="col-sm-12 col-form-label">Qty <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="number" name="qty" id="qty"
                                                value="" placeholder="" required>
                                            <div class="my-2">
                                                <span class="text-danger error-text qty_error"></span>
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

            fetchNamaBarang();
        });

        function cekQty() {
            let qty = parseFloat($('#qty').val()); // Ambil nilai qty yang dimasukkan
            let saldo = parseFloat($('#saldo').val()); // Ambil nilai saldo dari elemen yang sesuai

            // Periksa apakah qty dan saldo adalah angka yang valid
            if (isNaN(qty) || isNaN(saldo)) {
                $('.qty_error').text('Jumlah qty atau saldo tidak valid.');
                return;
            }

            // Periksa apakah qty lebih besar dari saldo
            if (qty > saldo) {
                // Tampilkan pesan error
                $('.qty_error').text('Jumlah qty tidak boleh lebih besar dari saldo yang tersedia (' + saldo + ').');
            } else {
                // Hapus pesan error jika qty valid
                $('.qty_error').text('');
            }
        }

        // Panggil cekQty saat input qty atau saldo berubah
        $('#qty').on('input', function() {
            cekQty();
        });





        function fetchDataSpecific() {
            let id = $('#nama_barang').val(); // Ambil ID dari dropdown
            let tanggal = $('#tanggal').val(); // Ambil tanggal dari input dengan ID 'tanggal'
            let idBarangKeluar = $('#id').val();

            // Jika id kosong, reset elemen
            if (id === '') {
                $('#kategori').val('');
                $('#satuan').val('');
                $('#saldo').val('');
                return; // Hentikan eksekusi AJAX jika ID kosong
            }

            // Kirim request AJAX
            $.ajax({
                url: '{{ url('barang-keluar/fetch-nama-barang/specific') }}/' + id + '?tanggal=' +
                    tanggal + '&idBarangKeluar=' + idBarangKeluar, // Format URL yang benar
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Isi elemen dengan data yang diterima
                    $('#kategori').val(response.data.kategori);
                    $('#satuan').val(response.data.satuan);
                    $('#saldo').val(response.data.saldo_barang);

                    cekQty();
                },
                error: function(xhr, status, error) {
                    // Penanganan jika ada error
                    console.error("Error:", error);
                    alert('Terjadi kesalahan saat mengambil data.');
                }
            });
        }

        // Trigger saat #nama_barang berubah
        $('#nama_barang').on('change', function() {
            fetchDataSpecific(); // Panggil fungsi untuk mengambil data
        });

        // Trigger saat #tanggal berubah
        $('#tanggal').on('change', function() {
            fetchDataSpecific(); // Panggil fungsi untuk mengambil data
        });


        // button reload
        $('#reload-nama-barang').on('click', function() {
            fetchNamaBarang();
        });

        // Fokus ke kotak pencarian ketika dropdown dibuka dan panggil fetchSatuanData
        $('#nama_barang').on('select2:open', function() {

            const searchField = document.querySelector('.select2-search__field');
            if (searchField) {
                searchField.focus();
            }

        });

        // buatkan function fetchSatuanData
        function fetchNamaBarang() {
            $.ajax({
                url: '{{ route('barang-keluar-fetch-nama-barang') }}',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    let namaBarangSelect = $('#nama_barang');
                    namaBarangSelect.empty().append('<option value=""></option>');
                    // Hapus opsi lama dan tambahkan placeholder
                    $.each(response.data, function(index, item) {
                        namaBarangSelect.append(new Option(item.nama_barang, item.id));
                    });
                }
            });
        }

        // buatkan function fecthData
        function fetchData() {
            $.ajax({
                url: '{{ route('barang-keluar-fetch') }}',
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
                            value.tanggal,
                            value.barang.nama_barang,
                            value.barang.nama_kategori,
                            value.qty,
                            value.barang.nama_satuan,
                        ]).draw(false);
                    });
                    table.columns.adjust().draw();
                }
            });
        }

        function deleteData(id) {
            if (confirm('Apakah anda yakin ingin menghapus data ini?')) {

                $.ajax({
                    url: '{{ url('barang-keluar/hapus') }}/' + id,
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

            // Ambil nilai qty dan saldo
            let qty = $('#qty').val();
            let saldo = $('#saldo').val(); // Misalnya saldo disimpan dalam elemen dengan id 'saldo'

            // Pastikan qty dan saldo dalam bentuk angka
            qty = parseFloat(qty);
            saldo = parseFloat(saldo);

            // Cek apakah qty melebihi saldo
            if (qty > saldo) {
                // Tampilkan alert jika qty melebihi saldo
                alert('Jumlah qty tidak boleh lebih besar dari saldo yang tersedia (' + saldo + ').');
                return; // Hentikan eksekusi jika qty lebih besar dari saldo
            }

            // Jika id kosong (untuk simpan data baru)
            if (id == '') {
                $.ajax({
                    url: '{{ route('barang-keluar-simpan') }}',
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
                    url: '{{ url('barang-keluar/update') }}/' + id,
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
                url: '{{ url('barang-keluar/edit') }}/' + id, // Sesuaikan URL sesuai kebutuhan Anda
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
                        $('#tanggal').val(response.data.tanggal);
                        $('#nama_barang').val(response.data.barang_id).trigger('change');
                        $('#qty').val(response.data.qty);

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
