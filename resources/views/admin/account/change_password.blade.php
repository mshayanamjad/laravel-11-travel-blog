@extends('admin.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Change Password</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a onclick="goBack()" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            @include('admin.admin-authentication.message')
            <form action="" method="post" name="changePasswordForm" id="changePasswordForm">
                <div class="card">
                    <div class="card-body">								
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="old_password">Old Password</label>
                                    <input type="password" name="old_password" id="old_password" class="form-control" placeholder="Old Password">
                                    <p class="error"></p>	
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="new_password">New Password</label>
                                    <input type="password" name="new_password" id="new_password" class="form-control" placeholder="New Password">	
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="confirm_password">Confirm Password</label>
                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password">
                                    <p class="error"></p>	
                                </div>
                            </div>
                        </div>
                    </div>							
                </div>
            
                <div class="pb-5 pt-3">
                    <button class="btn btn-primary" style="min-height: 30px; min-width: 100px;" id="submit" type="submit">Save</button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</section>
@endsection
@section('customJS')
<script>

    $('#changePasswordForm').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: '{{ route("accounts.processChangePassword") }}',
            type: 'post',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function (response) {
                if(response.status == true) {
                    $('.error').removeClass('invalid-feedback').html('');
                    $('input').removeClass('is-invalid');
                    
                    window.location.href="{{ route('accounts.changePassword') }}";
                } else {
                    let errors = response['errors'];
                    $('.error').removeClass('invalid-feedback').html('');
                    $('input').removeClass('is-invalid');

                    $.each(errors, function(key, value) {
                        $(`#${key}`).addClass('is-invalid').siblings('.error').addClass('invalid-feedback').html(value);
                    });
                }
            }
        });
    });

</script>
@endsection