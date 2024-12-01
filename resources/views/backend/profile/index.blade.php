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

        <form enctype="multipart/form-data" id="formUbahDataProfile" method="POST">
            @csrf
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-2">Profile Information</h4>
                    <p class="text-truncate font-size-14 mb-2">Update your account's profile information and email address.</p>

                    <div class="row mb-1">
                        <div class="col-lg-6 col-md-6">
                            <label for="name" class="col-sm-12 col-form-label">Name <span
                                    class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="name" id="name" value=""
                                placeholder="" required>
                            <div class="mt-2">
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-1">
                        <div class="col-lg-6 col-md-6">
                            <label for="email" class="col-sm-12 col-form-label">Email <span
                                    class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="email" id="email" value=""
                                placeholder="" required>
                            <div class="mt-2">
                                <span class="text-danger error-text email_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-1">
                        <div class="col-lg-6 col-md-6">
                            <button class="btn btn-dark" id="btnEditData" data-bs-toggle="modal"
                                data-bs-target="#exampleModalScrollable" style="margin-right: 5px;"
                                onclick="editData(' +
                                value.id +
                                ')"><i
                                    class="ri-save-2-line align-middle me-1"></i><span
                                    style="vertical-align: middle">Save</span></button>
                        </div>
                    </div>

                </div>
            </div>
        </form>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-2">Update Password</h4>
                <p class="text-truncate font-size-14 mb-2">Ensure your account is using a long, random password to stay
                    secure.</p>

                <div class="row mb-1">
                    <div class="col-lg-6 col-md-6">
                        <label for="name" class="col-sm-12 col-form-label">Current Password <span
                                class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="name" id="name" value=""
                            placeholder="" required>
                        <div class="mt-2">
                            <span class="text-danger error-text name_error"></span>
                        </div>
                    </div>
                </div>

                <div class="row mb-1">
                    <div class="col-lg-6 col-md-6">
                        <label for="email" class="col-sm-12 col-form-label">New Password <span
                                class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="email" id="email" value=""
                            placeholder="" required>
                        <div class="mt-2">
                            <span class="text-danger error-text email_error"></span>
                        </div>
                    </div>
                </div>

                <div class="row mb-1">
                    <div class="col-lg-6 col-md-6">
                        <label for="email" class="col-sm-12 col-form-label">Confirm Password <span
                                class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="email" id="email" value=""
                            placeholder="" required>
                        <div class="mt-2">
                            <span class="text-danger error-text email_error"></span>
                        </div>
                    </div>
                </div>

                <div class="row mb-1">
                    <div class="col-lg-6 col-md-6">
                        <button class="btn btn-dark" id="btnEditData" data-bs-toggle="modal"
                            data-bs-target="#exampleModalScrollable" style="margin-right: 5px;"
                            onclick="editData(' +
                            value.id +
                            ')"><i
                                class="ri-save-2-line align-middle me-1"></i><span
                                style="vertical-align: middle">Save</span></button>
                    </div>
                </div>

            </div>
        </div>

    </div>


    <script>
        $(document).ready(function() {

            fetchData();

        });

        function fetchData() {

            $.ajax({
                url: '{{ route('profile.fetch') }}',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    let profile = response.data;
                    $('#name').val(profile.name);
                    $('#email').val(profile.email);
                    $('#namaUserLoginDiHeader').text(profile.name);
                }

            });
        }

        $('#formUbahDataProfile').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData($('#formUbahDataProfile')[0]);

            $.ajax({
                url: '{{ route('profile.update') }}',
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
                        toastr.warning(response.message, "", {
                            "closeButton": true,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": false,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "100",
                            "hideDuration": "100",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        });
                    } else {

                        // // toastr success message
                        // toastr.success(response.message, "", {
                        //     "closeButton": false,
                        //     "debug": false,
                        //     "newestOnTop": true,
                        //     "progressBar": false,
                        //     "positionClass": "toast-top-right",
                        //     "preventDuplicates": false,
                        //     "onclick": null,
                        //     "showDuration": "100",
                        //     "hideDuration": "100",
                        //     "timeOut": "1500",
                        //     "extendedTimeOut": "1000",
                        //     "showEasing": "swing",
                        //     "hideEasing": "linear",
                        //     "showMethod": "fadeIn",
                        //     "hideMethod": "fadeOut"
                        // });

                        // // hide modal
                        // $('#exampleModalScrollable').modal('hide');

                        // fetch data
                        fetchData();
                    }
                }
            })

        })
    </script>
@endsection
