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
        <i class='subheader-icon fal fa-user'></i> Profile <span class='fw-300'></span> <sup class='badge badge-primary fw-500'></sup>
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
                    Profile <span class="fw-300"><i></i></span>
                </h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    {{-- <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button> --}}
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content" >
                    <form id="profileForm" type="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="form-label" for="first_name">First Name</label>
                            <input type="text" id="first_name" name="first_name" class="form-control" value="{{ $user->first_name }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="last_name">Last Name</label>
                            <input type="text" id="last_name" name="last_name" class="form-control" value="{{ $user->last_name }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="email">Email</label>
                            <input type="text" id="email" name="email" class="form-control" value="{{ $user->email }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="email">Photo</label>
                            <input type="file" id="photo" name="photo" class="form-control">
                        </div>
                        <div class="form-group">
                            <img src="{{ $user->photo }}" width="80" id="image">
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" id="save" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('admin.users.create')
</div>
@endsection

@section('page_js')
<script type="text/javascript">
    $(document).ready(function(){

        $('#profileForm').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            var ajaxurl = "{{ route('admin.profile.update') }}";
            $.ajax({
                type: "POST",
                url: ajaxurl,
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                },
                success: function (data) {
                    if(data.status == 'success')
                    {
                        $('#first_name').val(data.data.first_name);
                        $('#last_name').val(data.data.last_name);
                        $('#email').val(data.data.email);
                        $('#photo').val('');
                        $('#image').attr('src',data.data.photo);
                        toastr['success']('Save successfully!');
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
        });

    });

</script>
@endsection