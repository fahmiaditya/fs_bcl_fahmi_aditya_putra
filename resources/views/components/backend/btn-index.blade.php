<h5 class="card-title text-secondary text-center">PROSES DATA</h5>
<div class="row">
    <div class="col-lg-12">
        <div class="mb-2">
            <button id="limo-btn-tambah" type="button" onclick="create('{{ route(''.$entity.'.create') }}')" class="btn btn-primary btn-sm waves-effect waves-light form-control">Tambah</button>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="mb-2">
            <button id="limo-btn-hapus" disabled type="button" onclick="hapus('{{ route(''.$entity.'.delete') }}')" class="btn btn-danger btn-sm waves-effect waves-light form-control">Hapus (<span id="count-hapus">0</span>)</button>
        </div>
    </div>
</div>