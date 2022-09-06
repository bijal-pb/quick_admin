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
        <i class='subheader-icon fal fa-user'></i> Users <span class='fw-300'></span> <sup class='badge badge-primary fw-500'></sup>
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
                    Users <span class="fw-300"><i></i></span>
                </h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    {{-- <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button> --}}
                </div>
            </div>
            <div class="panel-container show">
                {{-- <button type="button" id="btn-add" class="btn btn-primary float-right m-3" data-toggle="modal" data-target="#default-example-modal">Add User</button> --}}
                <div class="panel-content" >
                    <div id="categoryData">
                        <table id="user-table" class="table table-bordered table-hover table-striped w-100 dataTable dtr-inline">
                            <thead class="bg-primary-600">
                                <tr>
                                    <th>Id </th>
                                    <th>First Name </th>
                                    <th>Last Name</th>
                                    <th>User Name</th>
                                    <th>Email </th>
                                    <th>Active</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
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

        var table =  $('#user-table').DataTable(
                {
                    responsive: true,
                    serverSide: true,
                    ajax: "{{ route('admin.users.list') }}",
                    columns: [
                        {data: 'id', name: 'Id'},
                        {data: 'first_name', name: 'First Name'},
                        {data: 'last_name', name: 'Last Name'},
                        {data: 'user_name', name: 'User Name'},
                        {data: 'email', name: 'Email'},
                        {data: 'status', name: 'Active', orderable: false, searchable: false},
                        {data: 'action', name: 'Action', orderable: false, searchable: false},
                    ],
                    lengthChange: true,
                    dom: '<"float-left"B><"float-right"f>rt<"row"<"col-sm-4"l><"col-sm-4"i><"col-sm-4"p>>',
                        // "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
                        // "<'row'<'col-sm-12'tr>>" +
                        // "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    buttons: [
                        {
                            extend: 'pdfHtml5',
                            text: 'PDF',
                            titleAttr: 'Generate PDF',
                            className: 'btn-outline-primary btn-sm mr-1'
                        },
                        {
                            extend: 'excelHtml5',
                            text: 'Excel',
                            titleAttr: 'Generate Excel',
                            className: 'btn-outline-primary btn-sm mr-1'
                        },
                        {
                            extend: 'csvHtml5',
                            text: 'CSV',
                            titleAttr: 'Generate CSV',
                            className: 'btn-outline-primary btn-sm mr-1'
                        },
                        {
                            extend: 'copyHtml5',
                            text: 'Copy',
                            titleAttr: 'Copy to clipboard',
                            className: 'btn-outline-primary btn-sm mr-1'
                        },
                        {
                            extend: 'print',
                            text: 'Print',
                            titleAttr: 'Print Table',
                            className: 'btn-outline-primary btn-sm'
                        }
                    ]
                });

        $('#btn-add').click(function () {
            $('#catForm').trigger("reset");
        });

        // Clicking the save button on the open modal for both CREATE and UPDATE
        $("#save").click(function (e) {
            var formData = {
                user_id: $('#user_id').val(),
                first_name: $('#first_name').val(),
                last_name: $('#last_name').val(),
                status: $('#status').val(),
            };
            var ajaxurl = "{{ route('admin.user.store') }}";
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
                        toastr['success']('Save successfully!');
                        $('#default-example-modal').modal('hide');
                        $('#catForm').trigger("reset");
                        table.ajax.reload( null, false);
                    }
                },
                error: function (data) {
                    toastr['error']('Something went wrong, Please try again!');
                    console.log('Error:', data);
                }
            });
        });

        $(document).on("click", ".edit-cat" , function () {
            var ajaxurl = $(this).data('url');
            $.ajax({
                type: "GET",
                url: ajaxurl,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                },
                success: function (data) {
                    $('#catForm').trigger("reset");
                    $('#user_id').val(data.data.id);
                    $('#first_name').val(data.data.first_name);
                    $('#last_name').val(data.data.last_name);
                    $('#email').val(data.data.email);
                    $('#status').val(data.data.status);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
            
        });

        $(document).on('click', '.active', function(){
            var ajaxurl = $(this).data('url');
            $.ajax({
                type: "GET",
                url: ajaxurl,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                },
                success: function (data) {
                    if(data.status == 'success')
                    {
                        toastr['success']('Change status successfully!');
                        table.ajax.reload( null, false);
                    }
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });
       
    });

</script>
@endsection