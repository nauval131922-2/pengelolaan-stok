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
                            <li class="breadcrumb-item active">Laporan</li>
                            <li class="breadcrumb-item active">{{ $sub_title }}</li>
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
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="daftar" role="tabpanel"
                                aria-labelledby="daftar-tab">
                                <div class="col-xl-12 col-md-12" style="padding-top: 15px">
                                    {{-- input tanggal --}}
                                    <div class="row">
                                        <div class="col-lg-1">
                                            <div class="mb-3">
                                                <!-- Tombol Reload -->
                                                <button type="button" id="reload-nama-barang"
                                                    class="btn btn-outline-light w-100" title="Reload nama_barang">
                                                    <i class="fa fa-sync-alt"></i> <!-- Icon reload -->
                                                </button>
                                            </div>
                                        </div>

                                        <div class="col-lg-5">
                                            <div class="mb-3">
                                                <!-- Dropdown nama_barang -->
                                                <select class="select2" name="nama_barang" id="nama_barang" required>
                                                    <option value=""></option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-2">
                                            <div class="mb-3">
                                                <input type="date" class="form-control" id="tanggalMulai"
                                                    name="tanggalMulai" value="{{ date('Y-m-d') }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-2">
                                            <div class="mb-3">
                                                <input type="date" class="form-control" id="tanggalAkhir"
                                                    name="tanggalAkhir" value="{{ date('Y-m-d') }}">
                                            </div>
                                        </div>
                                        {{-- tombol pdf --}}
                                        <div class="col-lg-2">
                                            <div class="mb-3">
                                                <button class="btn btn-danger w-100" id="btnPdf" type="button"><i
                                                        class="ri-file-pdf-line"></i> PDF</button>
                                            </div>
                                        </div>
                                    </div>

                                    <table id="datatable"
                                        class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline collapsed"
                                        style="border-collapse: collapse; border-spacing: 0px; width: 100%;" role="grid"
                                        aria-describedby="datatable-buttons_info">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Barang</th>
                                                <th>Kategori</th>
                                                <th>Debit</th>
                                                <th>Kredit</th>
                                                <th>Saldo</th>
                                                <th>Satuan</th>
                                                {{-- @can('admin') --}}

                                                {{-- @endcan --}}
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div><!-- end col -->
                            </div>



                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <style>
        .text-right {
            text-align: right;
        }
    </style>


    <script>
        $(document).ready(function() {
            fetchData()

            fetchNamaBarang();
        });

        // button reload
        $('#reload-nama-barang').on('click', function() {
            fetchNamaBarang();
        });

        function fetchNamaBarang() {
            $.ajax({
                url: '{{ route('kartu-stok-fetch-nama-barang') }}',
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

        $('#tanggal').on('change', function() {
            fetchData(); // Panggil fetchData saat tanggal berubah
        });



        // buatkan function fecthData
        function fetchData() {
            var idBarang = $('#nama_barang').val();
            var tanggalMulai = $('#tanggalMulai').val();
            var tanggalAkhir = $('#tanggalAkhir').val();

            // Validasi input
            if (!idBarang || !tanggalMulai || !tanggalAkhir) {
                alert("Semua field harus diisi!");
                return;
            }

            $.ajax({
                url: '{{ route('kartu-stok-fetch', [':idBarang', ':tanggalMulai', ':tanggalAkhir']) }}'
                    .replace(':idBarang', idBarang)
                    .replace(':tanggalMulai', tanggalMulai)
                    .replace(':tanggalAkhir', tanggalAkhir), // Ganti placeholder dengan nilai input
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    var table = $('#datatable').DataTable();

                    // Clear existing table data
                    if ($.fn.DataTable.isDataTable('#datatable')) {
                        table.clear();
                    }

                    // Populate table with response data
                    var data = response.data;
                    $.each(data, function(key, value) {
                        table.row.add([
                            (key + 1),
                            value.nama_barang,
                            value.tanggal,
                            value.kategori.nama_kategori,
                            value.saldo, // Pastikan data sesuai dengan respon controller
                            value.satuan.nama_satuan
                        ]).draw(false);
                    });
                    table.columns.adjust().draw();
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                    alert("Gagal mengambil data. Periksa input dan coba lagi.");
                }
            });
        }
    </script>
@endsection