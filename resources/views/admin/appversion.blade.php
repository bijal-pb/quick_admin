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
        <i class='subheader-icon fal fa-cogs'></i> App Version <span class='fw-300'></span> <sup class='badge badge-primary fw-500'></sup>
        {{-- <small>
            Insert page description or punch line
        </small> --}}
    </h1>
</div>
<!-- Your main content goes below here: -->
<div class="row"> 
    <div class="col-xl-12">
        <div class="alert alert-danger" role="alert">
            Don't do any changes if you're not sure without help of technical Team / Developer, This changes are not revertable and direct apply on live application and might be shout down or create errors to live Users.
        </div>
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                App Version <span class="fw-300"><i></i></span>
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
                            <label class="form-label" for="push_token">iOS</label>
                            <input type="text" id="ios" name="ios" class="form-control" value="{{$AppVersion->ios}}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="url">Android</label>
                            <input type="text" id="android" name="android" class="form-control" value="{{$AppVersion->android}}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="push_token">Forcefully</label>
                            <select class="form-control" name="forcefully" id="forcefully">
                                <option value="0" {{ $AppVersion->forcefully == '0' ? 'selected' : '' }}>No</option>
                                <option value="1" {{ $AppVersion->forcefully == '1' ? 'selected' : '' }}>Yes</option>
                            </select>
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
            var formData = {
                ios: $('#ios').val(),
                android: $('#android').val(),
                forcefully: $('#forcefully').val(),
            };
            var ajaxurl = "{{ route('admin.version.update') }}";
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
                        $('#ios').val(data.data.ios);
                        $('#android').val(data.data.android);
                        $('#forcefully').val(data.data.forcefully);
                        toastr['success']('App Version updated successfully!!');
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
