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
                                        <div class="col-lg-2">
                                            <div class="mb-3">
                                                <input type="date" class="form-control" id="tanggal" name="tanggal"
                                                    value="{{ date('Y-m-d') }}">
                                            </div>
                                            {{-- tombol excel --}}

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
                                                <th>Action</th>
                                                <th>Nama Barang</th>
                                                <th>Kategori</th>
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

    <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalContent">
                    <!-- Konten PDF akan dimasukkan di sini -->
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
        });

        $('#tanggal').on('change', function() {
            fetchData(); // Panggil fetchData saat tanggal berubah
        });



        // buatkan function fecthData
        function fetchData() {
            var tanggal = $('#tanggal').val(); // Ambil nilai tanggal dari input date

            $.ajax({
                url: '{{ route('saldo-barang-fetch', ':tanggal') }}'.replace(':tanggal',
                    tanggal), // Ganti :tanggal dengan nilai tanggal
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    var table = $('#datatable').DataTable();

                    if ($.fn.DataTable.isDataTable('#datatable')) {
                        table.clear();
                    }
                    var data = response.data;
                    $.each(data, function(key, value) {
                        var pdfButton = '';

                        pdfButton =
                            '<button class="btn btn-danger btn-sm" id="delete" onclick="deleteData(' +
                            value.id +
                            ')"><i class="ri-file-pdf-line align-middle me-1"></i><span style="vertical-align: middle">PDF</span></button>';

                        // Pastikan saldo ditampilkan dengan format dua angka desimal
                        let formattedSaldo = value.saldo_barang.toFixed(2).replace(
                            /\B(?=(\d{3})+(?!\d))/g, ",");

                        table.row.add([
                            (key + 1),
                            pdfButton,
                            value.nama_barang,
                            value.kategori.nama_kategori,
                            formattedSaldo,
                            value.satuan.nama_satuan,
                        ]).draw(false);
                    });
                    table.columns.adjust().draw();
                }
            });
        }

        // pdf all
        $('#btnPdf').on('click', function() {
            // tanggal
            var tanggal = $('#tanggal').val();

            $.ajax({
                url: '{{ url('saldo-barang/pdf') }}/' + tanggal,
                type: 'GET',
                xhrFields: {
                    responseType: 'blob' // Pastikan respons diterima sebagai blob
                },
                success: function(response) {
                    const modalContent = document.getElementById('modalContent');
                    const pdfUrl = URL.createObjectURL(response);
                    modalContent.innerHTML = '<embed src="' + pdfUrl + '" width="100%" height="500px">';
                    const modal = new bootstrap.Modal(document.getElementById('pdfModal'));
                    modal.show();

                    // set modal title
                    const modalTitle = document.getElementById('pdfModalLabel');
                    modalTitle.textContent = 'Laporan Saldo Barang';
                },
                error: function() {
                    alert('Gagal memuat PDF.');
                }
            });
        });
    </script>
@endsection
