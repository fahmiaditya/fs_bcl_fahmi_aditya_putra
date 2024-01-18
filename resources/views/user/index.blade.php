@extends('layouts.app')
@section('title', 'User')
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
                                            <x-slot name="entity">users</x-slot>
                                        </x-backend.btn-index>
                                    </div>
                                    <div id="group_search" class="mb-3">
                                        <x-backend.search>
                                            <x-slot name="route">{{ route('users.load-data') }}</x-slot>
                                        </x-backend.search>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h5 class="card-title text-secondary text-center">Hak Akses</h5>
                                                <input hidden type="text" name="url_role_filter" id="url_role_filter" value="{{ route('users.load-role') }}">
                                                <div class="mb-2 filter-role">
                                                    <select class="form-control" id="filter_role" name="filter_role" data-toggle="select2" data-width="100%">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
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
                                                    <th>Status</th>
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
                        @include('user.proses')
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

    <!-- Init js -->
    <script src="{{ asset('backend/assets/js/pages/responsive-table.init.js') }}"></script>
@endsection

@section('script-custom')
    <script src="{{ asset('backend/custom/user-module.js') }}"></script>
@endsection
