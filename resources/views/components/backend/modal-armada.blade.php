<div class="modal fade" id="modal-armada" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <input type="text" name="url_jenis_modal" id="url_jenis_modal" value="{{ $route_jenis }}" hidden>
    <input type="text" name="url_first_modal" id="url_first_modal" value="{{ $route }}?page=1" hidden>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Pilih Armada</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="group_search_modal" class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="jenis" class="form-label">Jenis Armada</label>
                            <select class="form-control" id="modal_jenis" name="modal_jenis" data-width="100%">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="modal_search" class="form-label">Pencarian</label>
                            <input type="text" class="form-control" id="modal_search" name="modal_search" placeholder="Nomor">
                        </div>
                    </div>
                </div>
                <x-backend.loading></x-backend.loading>
                <div class="table-responsive">
                    <table id="table-modal-load" class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>
                                    &nbsp;
                                </th>
                                <th>No</th>
                                <th>Jenis</th>
                                <th>Nomor</th>
                                <th>Kapasitas</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div id="pagination-modal" class="mt-2"></div>
            </div>
            <div class="modal-footer" style="display: block">
                <small class="float-start text-danger">Note* Data armada yang tampil hanya armada yang tersedia saja</small>
                <button type="button" class="btn btn-secondary waves-effect float-end" data-bs-dismiss="modal">Close</button>
                <button id="btn-pilih" type="button" class="btn btn-info waves-effect waves-light float-end">Pilih Armada</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->