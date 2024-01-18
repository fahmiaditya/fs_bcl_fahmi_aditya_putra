@extends('layouts.app')
@section('title', 'Pelanggan')
@section('content')
<div class="content">
    <!-- Start Content-->
    <div class="container-fluid">
         <!-- start page title -->
         <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">@yield('title')</a></li>
                            <li id="limo-breadcrumb" class="breadcrumb-item active"></li>
                        </ol>
                    </div>
                    <h4 id="limo-title" class="page-title">Data @yield('title')</h4>
                </div>
            </div>
        </div>     
        <!-- end page title --> 

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <section id="limo-index">
                            <div class="row">
                                <div class="col-md-3">
                                    <div id="group_button" class="mb-3">
                                        <x-backend.btn-index>
                                            <x-slot name="entity">customer</x-slot>
                                        </x-backend.btn-index>
                                    </div>
                                    <div id="group_search" class="mb-3">
                                        <x-backend.search>
                                            <x-slot name="route">{{ route('customer.load-data') }}</x-slot>
                                        </x-backend.search>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <x-backend.loading></x-backend.loading>
                                    <div class="table-responsive">
                                        <table id="table-load" class="table table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <div class="form-check form-check-success">
                                                            <input class="form-check-input" type="checkbox" value="" id="checkAll">
                                                        </div>
                                                    </th>
                                                    <th>No</th>
                                                    <th>Nama</th>
                                                    <th>Username</th>
                                                    <th>Email</th>
                                                    <th>Alamat</th>
                                                    <th>Telepon</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="pagination" class="mt-2 mb-2"></div>
                                </div>
                            </div>
                        </section>
                        @include('customer.proses')
                    </div>
                </div> <!-- end card -->
            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div> <!-- container -->
</div> <!-- content -->
@endsection

@section('css-template')
    <!-- Responsive Table css -->
    <link href="{{ asset('backend/assets/libs/admin-resources/rwd-table/rwd-table.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('script-template')
    <!-- Plugin js-->
    <script src="{{ asset('backend/assets/libs/admin-resources/rwd-table/rwd-table.min.js') }}"></script>
@endsection

@section('script-custom')
    <script src="{{ asset('backend/custom/customer-module.js') }}"></script>
@endsection
