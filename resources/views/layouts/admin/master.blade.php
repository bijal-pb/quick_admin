@include('layouts.admin.header', ['some' => 'data'])

{{-- <div id="main" role="main">
    @yield('content')
</div> --}}
<main role="main" class="page-content">
    @yield('content')
</main>

@include('layouts.admin.footer')
@yield('page_js')