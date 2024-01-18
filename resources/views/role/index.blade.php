@extends('layouts.app')
@section('title', 'Hak Akses')
@section('content')
<div class="content">
    <!-- Start Content-->
    <div class="container-fluid">
         <!-- start page title -->
         <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <button type="button" class="btn btn-primary waves-effect waves-light form-control" data-bs-toggle="modal" data-bs-target="#modalRoleProses">Tambah</button>
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
                                <div class="col-md-12">
                                    <x-backend.loading></x-backend.loading>
                                    <input type="text" id="url_first" name="url_first" value="{{ route('roles.load-data') }}" hidden>
                                    <div id="limo-view-role">
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section id="limo-proses">
                            <div id="modalRoleProses" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="#">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Tambah Hak Akses</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Ex: Admin">
                                                            <span id="error-nama" class="text-danger msg-error"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <x-backend.loading></x-backend.loading>
                                                <button id="limo-btn-kembali" type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Kembali</button>
                                                <button id="limo-btn-simpan" type="button" onclick="store('{{ route('roles.store') }}')" class="btn btn-info waves-effect waves-light">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div><!-- /.modal -->
                        </section>
                    </div>
                </div> <!-- end card -->
            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div> <!-- container -->
</div> <!-- content -->
@endsection

@section('script-custom')
    <script src="{{ asset('backend/custom/role-module.js') }}"></script>
@endsection
