<div class="text-end">
    <button id="limo-btn-simpan" type="button" onclick="store('{{ route(''.$entity.'.store') }}')" class="btn btn-primary waves-effect waves-light" >Simpan</button>
    <button id="limo-btn-ubah" type="button" onclick="update('{{ route(''.$entity.'.update', '') }}')" class="btn btn-info waves-effect waves-light" >Ubah</button>
    <button id="limo-btn-kembali" type="button" onclick="formIndex(0)" class="btn btn-secondary waves-effect">Kembali</button>
</div>