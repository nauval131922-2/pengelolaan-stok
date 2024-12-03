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

        <div class="row">
            <div class="col-lg-4">
                <form enctype="multipart/form-data" id="formUbahDataProfilePicture" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-2">Profile Picture</h4>
                            <p class="text-truncate font-size-14 mb-2">Update your account's profile picture.
                            </p>
                            <div class="row mb-1">
                                {{-- gambar --}}
                                <div class="col-lg-12 col-md-12">
                                    <img class="img rounded mb-2" alt="Profile Picture" height="171" id="showImage">
                                    <input class="form-control" type="file" name="gambar" id="gambar" value=""
                                        placeholder="" accept="image/*">
                                    <input type="hidden" id="gambarLama" name="gambarLama">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-lg-8">
                <form enctype="multipart/form-data" id="formUbahDataProfile" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-2">Profile Information</h4>
                            <p class="text-truncate font-size-14 mb-2">Update your account's profile information and email
                                address.
                            </p>

                            <div class="row mb-1">
                                <div class="col-lg-6 col-md-6">
                                    <label for="name" class="col-sm-12 col-form-label">Name <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="name" id="name" value=""
                                        placeholder="" required>
                                    <div class="my-2">
                                        <span class="text-danger error-text name_error"></span>
                                    </div>
                                </div>

                            </div>

                            <div class="row mb-1">
                                <div class="col-lg-6 col-md-6">
                                    <label for="username" class="col-sm-12 col-form-label">Username <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="username" id="username" value=""
                                        placeholder="" required>
                                    <div class="my-2">
                                        <span class="text-danger error-text username_error"></span>
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
            </div>
        </div>

        <form enctype="multipart/form-data" id="formUbahDataPassword" method="POST">
            @csrf

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-2">Update Password</h4>
                    <p class="text-truncate font-size-14 mb-2">Ensure your account is using a long, random password to stay
                        secure.</p>

                    <div class="row mb-1">
                        <div class="col-lg-6 col-md-6">
                            <label for="currentPassword" class="col-sm-12 col-form-label">Current Password <span
                                    class="text-danger">*</span></label>
                            <input class="form-control" type="password" name="currentPassword" id="currentPassword"
                                value="" placeholder="" required>
                            <div class="my-2">
                                <span class="text-danger error-text currentPassword_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-1">
                        <div class="col-lg-6 col-md-6">
                            <label for="newPassword" class="col-sm-12 col-form-label">New Password <span
                                    class="text-danger">*</span></label>
                            <input class="form-control" type="password" name="newPassword" id="newPassword"
                                value="" placeholder="" required>
                            <div class="my-2">
                                <span class="text-danger error-text newPassword_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-1">
                        <div class="col-lg-6 col-md-6">
                            <label for="confirmPassword" class="col-sm-12 col-form-label">Confirm Password <span
                                    class="text-danger">*</span></label>
                            <input class="form-control" type="password" name="confirmPassword" id="confirmPassword"
                                value="" placeholder="" required>
                            <div class="my-2">
                                <span class="text-danger error-text confirmPassword_error"></span>
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
                    $('#username').val(profile.username);
                    $('#email').val(profile.email);
                    $('#namaUserLoginDiHeader').text(profile.name);
                    // Cek apakah profile.foto_profil ada, jika ada gunakan itu, jika tidak gunakan gambar default
                    var profileImage = profile.foto_profil ? profile.foto_profil :
                        '{{ asset('assets/images/users/user.png') }}';

                    $('#fotoUserLoginDiHeader').show();
                    $('#fotoUserLoginDiHeader').attr('src', profileImage);

                    profile.foto_profil ? $('#gambarLama').val(profileImage) : '';
                    profile.foto_profil ? $('#showImage').attr('src', profileImage) : '';

                    $('#gambar').val('')
                    $('#showImage').show();
                    $('#showImage').attr('src', profileImage);
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
                        // tampilkan alert
                        alert(response.message);
                    } else {
                        // fetch data
                        fetchData();

                        // tampilkan alert
                        alert(response.message);
                    }
                }
            })

        })

        $('#formUbahDataPassword').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData($('#formUbahDataPassword')[0]);

            $.ajax({
                url: '{{ route('profile.update.password') }}',
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
                        // kosongkan form
                        $('#formUbahDataPassword')[0].reset();

                        // tampilkan alert
                        alert(response.message);
                    }
                }
            })

        })

        $('#gambar').on('change', function(e) {
            e.preventDefault();

            let formData = new FormData($('#formUbahDataProfilePicture')[0]);

            $.ajax({
                url: '{{ route('profile.update.profile.picture') }}',
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
                    }
                }
            })

        })
    </script>
@endsection
