@extends('backend.main')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="custom-container">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Dashboard</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Total Barang</p>
                                <h4 class="mb-2">{{ $total_barang }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="ri-stack-line font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Total Barang Kosong</p>
                                <h4 class="mb-2">{{ $barang_kosong }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-success rounded-3">
                                    <i class="ri-archive-2-line font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->
        </div><!-- end row -->


        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Latest Transactions</h4>

                        <div class="table-responsive" id="tabel">
                            <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Nama Barang</th>
                                        <th>Kategori</th>
                                        <th>Debit</th>
                                        <th>Kredit</th>
                                        <th>Saldo</th>
                                        <th>Satuan</th>
                                    </tr>
                                </thead><!-- end thead -->
                                <tbody>
                                </tbody><!-- end tbody -->
                            </table> <!-- end table -->
                        </div>
                    </div><!-- end card -->
                </div><!-- end card -->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>

    <script>
        $(document).ready(function() {
            fetchData()
        });

        // buatkan function fecthData
        function fetchData() {
            $.ajax({
                url: '{{ url('kartu-stok/fetch-for-dashboard') }}',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    var tableBody = $('#tabel tbody');
                    tableBody.html('');

                    // Add the data rows
                    $.each(response.data, function(index, item) {
                        tableBody.append('<tr><td>' + item.tanggal + '</td><td>' + item.nama_barang +
                            '</td><td>' + item.kategori + '</td><td>' + item.debit + '</td><td>' +
                            item.kredit + '</td><td>' + item.saldo + '</td><td>' + item.satuan +
                            '</td></tr>');
                    });
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(error);
                }
            });
        }
    </script>
@endsection
