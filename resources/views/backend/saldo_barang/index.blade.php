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

    <style>
        .text-right {
            text-align: right;
        }
    </style>


    <script>
        $(document).ready(function() {
            fetchData()


        });



        // buatkan function fecthData
        function fetchData() {
            $.ajax({
                url: '{{ route('saldo-barang-fetch') }}',
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
                            // format titik dan 2 angka di belakang
                            formattedSaldo,
                            value.satuan.nama_satuan,
                        ]).draw(false);
                    });
                    table.columns.adjust().draw();



                }
            });
        }
    </script>
@endsection
