@extends('layouts.admin.master') 
@section('content')
<ol class="breadcrumb page-breadcrumb">
    {{-- <li class="breadcrumb-item"><a href="javascript:void(0);">SmartAdmin</a></li>
    <li class="breadcrumb-item">Datatables</li>
    <li class="breadcrumb-item active">Basic</li> --}}
    <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
</ol>
<div class="subheader">
    <h1 class="subheader-title">
        <i class='subheader-icon fal fa-lock'></i> Change Password <span class='fw-300'></span> <sup class='badge badge-primary fw-500'></sup>
        {{-- <small>
            Insert page description or punch line
        </small> --}}
    </h1>
</div>
<!-- Your main content goes below here: -->
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Change Password <span class="fw-300"><i></i></span>
                </h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    {{-- <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button> --}}
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content" >
                    <form id="profileForm">
                        <div class="form-group">
                            <label class="form-label" for="current">Current Password</label>
                            <input type="password" id="current" name="current" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="password">New Password</label>
                            <input type="password" id="password" name="password" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="confirm">Confirm Password</label>
                            <input type="password" id="confirm" name="confirm" class="form-control" value="">
                        </div>
                    </form>
                    <div class="mt-5 form-group text-center">
                        <button id="save" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page_js')
<script type="text/javascript">
    $(document).ready(function(){

        $("#save").click(function (e) {
            var password = $('#password').val();
            var confirm = $('#confirm').val();
            if(password === confirm){
                var formData = {
                    current: $('#current').val(),
                    password: $('#password').val(),
                };
                var ajaxurl = "{{ route('admin.password.update') }}";
                $.ajax({
                    type: "POST",
                    url: ajaxurl,
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': "{{csrf_token()}}"
                    },
                    success: function (data) {
                        if(data.status == 'success')
                        {
                            $('#profileForm').trigger('reset');
                            toastr['success']('Change password successfully!');
                        }
                        if(data.status == 'error')
                        {
                            toastr['error'](data.message);
                        }
                    },
                    error: function (data) {
                        toastr['error']('Something went wrong, Please try again!');
                        console.log('Error:', data);
                    }
                });
            }else{
                toastr['error']('Confirm password not match with password!');
            }
            
        });

    });

</script>
@endsection