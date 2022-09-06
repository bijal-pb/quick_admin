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
        <i class='subheader-icon fal fa-file'></i> Pages <span class='fw-300'></span> <sup class='badge badge-primary fw-500'></sup>
        {{-- <small>
            Insert page description or punch line
        </small> --}}
    </h1>
</div>

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <i class="fal fa-user-clock"></i>&nbsp;&nbsp;&nbsp; Page
                </h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    {{-- <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button> --}}
                </div>
            </div>
            {{-- <div class="col-md-12 form-group text-right">
                    <span id="load_notification" class="hidden-xs"></span>
                    <input type="checkbox" onchange="ToggleEmailNotification('award_notification');return false;"
                        class="make-switch" name="award_notification" @if ($loggedAdmin->company->award_notification == 1) checked @endif
                        data-on-color="success" data-on-text="<i class='fa fa-bell-o'></i>"
                        data-off-text="<i class='fa fa-bell-slash-o'></i>" data-off-color="danger">
                    <span class="hidden-xs"><strong>{{ trans('core.emailNotification') }}</strong></span>
        </div> --}}

        <div class="panel-container show">
            <div class="panel-content">
                <!-- BEGIN FORM-->
                <form id="myForm">
                    @csrf
                    <div class="form-body">
                        <div class="row mx-md-n5">
                            <div class="col px-md-5">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Name</label>
                                    <div class="col-md-12 input-group">
                                        <input type="text" id="name" name="name" class="form-control" value="{{$pages->name}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><br>
                    <div class="form-group">
                        <label class="col-md-2 form-label">Page<span class="required">
                            </span>
                        </label>

                        <div class="col-md-12">
                            <textarea class="form-control" id="description" name="description">{{$pages->page}}</textarea>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="form-group text-center">
                            <button type="button" class="btn btn-primary" onclick="UpdatePages()" id="pageSubmit"><i class="fa fa-check"></i>Save</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- END FORM-->
        </div>
    </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->
</div>

@stop

@section('page_js')



<script>
    $(document).ready(function (){
        $('#description').summernote({
                height: 300,
            });
    })
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function UpdatePages() {
        $.ajax({
            url: "{{route('admin.page.save', ['page_id' => $pages->id])}}",
            type: "POST",
            data: $("#myForm").serialize(),
            container: ".#myForm",
            success: function(responce) {
                toastr['success']('Updated Successfully!');
                var loc = window.location;
                window.location = "{{ url('/admin/pages/') }}";
            }
        });
    }
</script>
@stop