@extends('layouts.app')
@section('title', 'Transaksi')
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
                                        <h5 class="card-title text-secondary text-center">PROSES DATA</h5>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-2">
                                                    <button id="limo-btn-tambah" type="button" onclick="create('{{ route('transaksi.create') }}')" class="btn btn-primary btn-sm waves-effect waves-light form-control">Tambah</button>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="mb-2">
                                                    <button id="limo-btn-hapus" disabled type="button" onclick="hapus('{{ route('transaksi.delete') }}')" class="btn btn-danger btn-sm waves-effect waves-light form-control">Hapus (<span id="count-hapus">0</span>)</button>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <x-backend.btn-index>
                                            <x-slot name="entity">transaksi</x-slot>
                                        </x-backend.btn-index> --}}
                                    </div>
                                    <div id="group_search" class="mb-3">
                                        <x-backend.search>
                                            <x-slot name="route">{{ route('transaksi.load-data') }}</x-slot>
                                        </x-backend.search>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h5 class="card-title text-secondary text-center">Status Pengiriman</h5>
                                                <div class="mb-2">
                                                    <select class="form-control" id="filter_status" name="filter_status" data-toggle="select2" data-width="100%">
                                                        <option value="All">Semua</option>
                                                        <option value="0">Ditunda</option>
                                                        <option value="1">Dalam Perjalanan</option>
                                                        <option value="2">Telah Tiba</option>
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
                                                    <th>Kode</th>
                                                    <th>Customer</th>
                                                    <th>Armada</th>
                                                    <th>Tgl Pemesanan</th>
                                                    <th>Lokasi Asal</th>
                                                    <th>Lokasi Tujuan</th>
                                                    <th>Status Pengiriman</th>
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
                        @include('transaksi.proses')

                        <div class="modal fade" id="modal-pengiriman" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myLargeModalLabel">Update Pengiriman</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="mb-2">
                                                <input class="form-control" type="text" id="url_update" name="url_update" hidden>
                                                <input class="form-control" type="text" id="armada" name="armada" hidden>
                                                <label for="deskripsi" class="form-label">Barang</label>
                                                <div id="view-barang"></div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-2">
                                                        <label for="tgl_pengiriman" class="form-label">Tanggal Pengiriman</label>
                                                        <input class="form-control" type="date" id="tgl_pengiriman" name="tgl_pengiriman">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-2">
                                                        <label for="tgl_tiba" class="form-label">Tanggal Tiba</label>
                                                        <input class="form-control" type="date" id="tgl_tiba" name="tgl_tiba">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label">Status Pengiriman</label><br>
                                                <div class="form-check form-check-inline mb-2 form-check-danger">
                                                    <input class="form-check-input" type="radio" name="status" id="status-tunda" value="0">
                                                    <label class="form-check-label" for="status-tunda">Tertunda</label>
                                                </div>
                                                <div class="form-check form-check-inline mb-2 form-check-warning">
                                                    <input class="form-check-input" type="radio" name="status" id="status-jalan" value="1">
                                                    <label class="form-check-label" for="status-jalan">Dalam Perjalanan</label>
                                                </div>
                                                <div class="form-check form-check-inline mb-2 form-check-danger">
                                                    <input class="form-check-input" type="radio" name="status" id="status-tiba" value="2">
                                                    <label class="form-check-label" for="status-tiba">Telah Tiba</label>
                                                </div>
                                            </div>
                                            <div class="mb-2">
                                                <label for="deskripsi" class="form-label">Catatan</label>
                                                <textarea class="form-control" type="date" id="deskripsi" name="deskripsi"></textarea>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary waves-effect float-end" data-bs-dismiss="modal">Close</button>
                                        <button id="btn-simpan-pengiriman" onclick="update()" type="button" class="btn btn-info waves-effect waves-light float-end">Update</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

                        <div class="modal fade" id="modal-lokasi" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myLargeModalLabel">Update Lokasi</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <input class="form-control" type="text" id="url_update_lokasi" name="url_update_lokasi" hidden>
                                            <div id="view-map" class="mb-2 text-center"></div>
                                            <div class="mb-2">
                                                <label for="lokasi_update" class="form-label">Embed / Salin Link Google Maps</label>
                                                <textarea rows="6" class="form-control" type="date" id="lokasi_update" name="lokasi_update"></textarea>

                                                <small id="error-lokasi_update" class="text-danger msg-error"></small>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary waves-effect float-end" data-bs-dismiss="modal">Close</button>
                                        <button id="btn-update-lokasi" onclick="updateLokasi()" type="button" class="btn btn-info waves-effect waves-light float-end">Update</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

                        <div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myLargeModalLabel">Detail Pengiriman</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <li class="list-group-item">
                                                        <a href="javascript:void(0);" class="user-list-item">
                                                            <div class="user float-start me-3">
                                                                <i class="mdi mdi-circle text-primary"></i>
                                                            </div>
                                                            <div class="user-desc overflow-hidden">
                                                                <h5 class="name mt-0 mb-1">Tanggal Pengiriman</h5>
                                                                <span id="view-tgl-pengiriman" class="desc text-muted font-12 text-truncate d-block">...</span>
                                                            </div>
                                                        </a>
                                                    </li>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <li class="list-group-item">
                                                        <a href="javascript:void(0);" class="user-list-item">
                                                            <div class="user float-start me-3">
                                                                <i class="mdi mdi-circle text-success"></i>
                                                            </div>
                                                            <div class="user-desc overflow-hidden">
                                                                <h5 class="name mt-0 mb-1">Tanggal Tiba</h5>
                                                                <span id="view-tgl-tiba" class="desc text-muted font-12 text-truncate d-block">...</span>
                                                            </div>
                                                        </a>
                                                    </li>
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <div class="mb-2">
                                            <h5>Detail Barang</h5>
                                            <div class="table-responsive">
                                                <table id="table-load-barang-modal-detail" class="table table-hover mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Barang</th>
                                                            <th>Muatan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="mb-2">
                                            <h5>Lokasi Terupdate</h5>
                                            <div id="view-map-update" class="text-center">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary waves-effect float-end" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
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

    <!-- Plugins css -->
    <link href="{{ asset('backend/assets/libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/libs/clockpicker/bootstrap-clockpicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('script-template')
    <!-- Plugin js-->
    <script src="{{ asset('backend/assets/libs/admin-resources/rwd-table/rwd-table.min.js') }}"></script>

    <script src="{{ asset('backend/assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/clockpicker/bootstrap-clockpicker.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

    <!-- Init js-->
    <script src="{{ asset('backend/assets/js/pages/form-pickers.init.js') }}"></script>
@endsection

@section('script-custom')
    <script src="{{ asset('backend/custom/modal-armada.js') }}"></script>
    <script src="{{ asset('backend/custom/transaksi-module.js') }}"></script>
@endsection
