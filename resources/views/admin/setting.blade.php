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
        <i class='subheader-icon fal fa-cogs'></i> App Settings <span class='fw-300'></span> <sup class='badge badge-primary fw-500'></sup>
        {{-- <small>
            Insert page description or punch line
        </small> --}}
    </h1>
</div>
<!-- Your main content goes below here: -->
<div class="row">
    
    <div class="col-xl-12">
        <div class="alert alert-warning" role="alert">
            Don't do any changes if you're not sure without help of technical Team / Developer, This changes are not revertable and direct apply on live application and might be shout down or create errors to live Users.
        </div>
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    App Setting <span class="fw-300"><i></i></span>
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
                            <label class="form-label" for="push_token">App Name</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ $setting->name }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="url">App Url</label>
                            <input type="text" id="url" name="url" class="form-control" value="{{ $setting->url }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="push_token">Firebase Key</label>
                            <input type="text" id="push_token" name="push_token" class="form-control" value="{{ $setting->push_token }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="api_log">Api Log</label>
                            <input type="text" id="api_log" name="api_log" class="form-control" value="{{ $setting->api_log }}">
                        </div>
                    </form>
                    <div class="mt-5 form-group text-center">
                        <button id="save" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Email Setting  <span class="fw-300"><i></i></span>
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
                            <label class="form-label" for="host">Host</label>
                            <input type="text" id="host" name="host" class="form-control" value="{{ $setting->host }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="port">Port</label>
                            <input type="text" id="port" name="port" class="form-control" value="{{ $setting->port }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="email">Email</label>
                            <input type="text" id="email" name="email" class="form-control" value="{{ $setting->email }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="password">Password</label>
                            <input type="text" id="password" name="password" class="form-control" value="{{ $setting->password }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="from_address">From Address</label>
                            <input type="text" id="from_address" name="from_address" class="form-control" value="{{ $setting->from_address }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="from_name">From Name</label>
                            <input type="text" id="from_name" name="from_name" class="form-control" value="{{ $setting->from_name }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="encryption">Encryption</label>
                            <input type="text" id="encryption" name="encryption" class="form-control" value="{{ $setting->encryption }}">
                        </div>
                    </form>
                    <div class="mt-5 form-group text-center">
                        <button id="saveEmail" class="btn btn-primary">Update</button>
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
                name: $('#name').val(),
                url: $('#url').val(),
                api_log: $('#api_log').val(),
                push_token : $('#push_token').val(),
                host : $('#host').val(),
                port : $('#port').val(),
                email : $('#email').val(),
                password : $('#password').val(),
                from_address : $('#from_address').val(),
                from_name : $('#from_name').val(),
                encryption : $('#encryption').val(),
            };
            var ajaxurl = "{{ route('admin.setting.update') }}";
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
                        $('#name').val(data.data.name);
                        $('#url').val(data.data.url);
                        $('#push_token').val(data.data.push_token);
                        $('#api_log').val(data.data.api_log);
                        $('#host').val(data.data.host);
                        $('#port').val(data.data.port);
                        $('#email').val(data.data.email);
                        $('#password').val(data.data.password);
                        $('#from_address').val(data.data.from_address);
                        $('#from_name').val(data.data.from_name);
                        $('#encryption').val(data.data.encryption);
                        toastr['success']('Update setting successfully!');
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
        $("#saveEmail").click(function (e) {
            var formData = {
                name: $('#name').val(),
                url: $('#url').val(),
                api_log: $('#api_log').val(),
                push_token : $('#push_token').val(),
                host : $('#host').val(),
                port : $('#port').val(),
                email : $('#email').val(),
                password : $('#password').val(),
                from_address : $('#from_address').val(),
                from_name : $('#from_name').val(),
                encryption : $('#encryption').val(),
            };
            var ajaxurl = "{{ route('admin.setting.update') }}";
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
                        $('#name').val(data.data.name);
                        $('#url').val(data.data.url);
                        $('#push_token').val(data.data.push_token);
                        $('#api_log').val(data.data.api_log);
                        $('#host').val(data.data.host);
                        $('#port').val(data.data.port);
                        $('#email').val(data.data.email);
                        $('#password').val(data.data.password);
                        $('#from_address').val(data.data.from_address);
                        $('#from_name').val(data.data.from_name);
                        $('#encryption').val(data.data.encryption);
                        toastr['success']('Update setting successfully!');
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