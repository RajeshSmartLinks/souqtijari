@extends('layouts.admin-master')

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <h3>Oops! You have no permission to access this Page.</h3>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('vendors/js/charts/apexcharts.min.js')}}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{asset('js/scripts/pages/dashboard-ecommerce.js')}}"></script>
    <!-- END: Page JS-->
@endsection
