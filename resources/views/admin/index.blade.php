@extends('layouts.admin-master')

@section('content')

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Dashboard Ecommerce Starts -->
                <section id="dashboard-ecommerce">
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 col-12">
                            <a href="#">
                                <div class="card">
                                    <div class="card-header d-flex flex-column align-items-start pb-0">
                                        <div class="avatar bg-rgba-primary p-50 m-0">
                                            <div class="avatar-content">
                                                <i class="feather icon-users text-primary font-medium-5"></i>
                                            </div>
                                        </div>
                                        <h2 class="text-bold-700 mt-1">{{$totals['totalUser']}}</h2>
                                        <p class="mb-0">Users</p>
                                    </div>
                                    <div class="card-content">
                                        <div id="line-area-chart-1"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <a href="#">
                                <div class="card">
                                    <div class="card-header d-flex flex-column align-items-start pb-0">
                                        <div class="avatar bg-rgba-success p-50 m-0">
                                            <div class="avatar-content">
                                                <i class="feather icon-shopping-cart text-success font-medium-5"></i>
                                            </div>
                                        </div>
                                        <h2 class="text-bold-700 mt-1">0</h2>
                                        <p class="mb-0">Ads</p>
                                    </div>
                                    <div class="card-content">
                                        <div id="line-area-chart-2"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header d-flex flex-column align-items-start pb-0">
                                    <div class="avatar bg-rgba-danger p-50 m-0">
                                        <div class="avatar-content">
                                            <i class="feather icon-credit-card text-danger font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="text-bold-700 mt-1">0</h2>
                                    <p class="mb-0">Ads this month</p>
                                </div>
                                <div class="card-content">
                                    <div id="line-area-chart-3"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header d-flex flex-column align-items-start pb-0">
                                    <div class="avatar bg-rgba-warning p-50 m-0">
                                        <div class="avatar-content">
                                            <i class="feather icon-package text-warning font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="text-bold-700 mt-1">0(25)</h2>
                                    <p class="mb-0">Orders Received</p>
                                </div>
                                <div class="card-content">
                                    <div id="line-area-chart-4"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </section>
                <!-- Dashboard Ecommerce ends -->

            </div>
        </div>
    </div>

@endsection


@section('scripts')
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('adminlayout/vendors/js/charts/apexcharts.min.js')}}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{asset('adminlayout/js/scripts/pages/dashboard-ecommerce.js')}}"></script>
    <!-- END: Page JS-->
@endsection
