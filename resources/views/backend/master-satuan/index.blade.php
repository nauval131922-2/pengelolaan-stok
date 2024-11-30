@extends('backend.main')

@section('title')
    Dashboard | {{ $title }}
@endsection

@section('content')
    <style>

        .custom-container {
            width: 100%;
            max-width: 100%;
            padding-left: 15px;
            padding-right: 15px;
          }
    </style>


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
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
                                    role="tab" aria-controls="home" aria-selected="true">Daftar {{ $sub_title }}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
                                    role="tab" aria-controls="profile" aria-selected="false">Tambah {{ $sub_title }}</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
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
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...
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
            fetchDataMasterSatuan();

        });

        // menampilkan modal tambah data

        // buatkan function fecthData
        function fetchDataMasterSatuan() {
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
    </script>
@endsection
