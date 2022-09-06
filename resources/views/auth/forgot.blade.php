@include('layouts.admin.loginHeader')
<div class="blankpage-form-field">
    <div class="page-logo m-0 w-100 align-items-center justify-content-center rounded border-bottom-left-radius-0 border-bottom-right-radius-0 px-4">
        <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
            <img src="{{ URL::asset('admin_assets/img/logo.png')}}" alt="SmartAdmin WebApp" aria-roledescription="logo">
            <span class="page-logo-text mr-1">{{ config('app.name') }}</span>
            <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
        </a>
    </div>
    <div class="card p-4 border-top-left-radius-0 border-top-right-radius-0">
        <form id="loginForm" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label" for="username">Email</label>
                <input type="email" id="email" class="form-control" placeholder="email">
                <span class="help-block">
                    Your email
                </span>
            </div>
            
            <button type="submit" class="btn btn-default float-right">Send</button>
        </form>
        
        <div class="blankpage-footer text-center">
            <a href="{{ route('login') }}"><strong>Login</strong></a>
        </div>
    </div>
    
</div>
{{-- <div class="login-footer p-2">
    <div class="row">
        <div class="col col-sm-12 text-center">
            <i><strong>System Message:</strong> You were logged out from 198.164.246.1 on Saturday, March, 2017 at 10.56AM</i>
        </div>
    </div>
</div> --}}
<video poster="{{ URL::asset('admin_assets/img/backgrounds/clouds.png')}}" id="bgvid" playsinline autoplay muted loop>
    <source src="{{ URL::asset('admin_assets/media/video/cc.webm')}}" type="video/webm">
    <source src="{{ URL::asset('admin_assets/media/video/cc.mp4')}}" type="video/mp4">
</video>
<script src="{{ URL::asset('admin_assets/js/vendors.bundle.js')}}"></script>
<script src="{{ URL::asset('admin_assets/js/app.bundle.js')}}"></script>
<script src="{{ URL::asset('admin_assets/js/notifications/sweetalert2/sweetalert2.bundle.js')}}"></script>
<script src="{{ URL::asset('admin_assets/js/notifications/toastr/toastr.js')}}"></script>

<script>
    $(document).ready(function()
            {
                toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": 300,
                "hideDuration": 100,
                "timeOut": 5000,
                "extendedTimeOut": 1000,
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
                }
            });
        
     
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#loginForm').submit(function(e) {
            e.preventDefault();
            var formData = {
                email: $('#email').val(),
            };
            var ajaxurl = "{{ route('admin.forgot.mail') }}";
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
                        toastr['success']('Sent mail successfully!');
                        $('#email').val('');
                    }
                    if(data.status == 'error')
                    {
                        toastr['error'](data.message);
                    }
                },
                error: function (data) {
                    toastr['error']('Something went wrong, Please try again!');
                }
            });
        });
    });

</script>
</body>


</html>