<?php /*?>DI CODE - Start<?php */?>
<!doctype html>
<?php /*?><html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{app()->getLocale() == 'ar' ? 'rtl' : 'ltr'}}"><?php */?>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{app()->getLocale() == 'ar' ? 'rtl' : 'ltr'}}">
<head>
    @include('layouts.partials.front.header')

    @section('social-meta')

    @show
</head>
	
<body class="{{app()->getLocale() == 'en' ? '' : 'rtl'}} main-body">
	
<?php /*?> Loader <?php */?>
@include('layouts.partials.front.loader')
<?php /*?> Topbar <?php */?>
@include('layouts.partials.front.topbar')

@yield('content')

@include('layouts.partials.front.footer')

<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
</script>
@yield('extra-scripts')
</body>
</html>
<?php /*?>DI CODE - End<?php */?>