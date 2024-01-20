<section id="limo-proses" hidden>
    <form>
        <div class="mb-3">
            <label for="jenis" class="form-label">Jenis Armada <span class="text-danger">*</span></label>
            <select class="form-control" id="jenis" name="jenis" data-toggle="select2" data-width="100%">
            </select>

            <small id="error-jenis" class="text-danger msg-error"></small>
        </div>

        <div class="mb-3">
            <label for="nomor" class="form-label">Nomor <span class="text-danger">*</span></label>
            <input type="text" id="nomor" name="nomor" class="form-control"/>

            <small id="error-nomor" class="text-danger msg-error"></small>
        </div>

        <div class="mb-3">
            <label for="kapasitas" class="form-label">Kapasitas <span class="text-danger">*</span></label>
            <input type="number" id="kapasitas" name="kapasitas" class="form-control" value="0"/>

            <small id="error-kapasitas" class="text-danger msg-error"></small>
        </div>

        <div class="mb-3">
            <label class="form-label">Ketersediaan</label><br>
            <div class="form-check form-check-inline mb-2 form-check-success">
                <input checked class="form-check-input" type="radio" name="ketersediaan" id="ketersediaan-true" value="1">
                <label class="form-check-label" for="ketersediaan-true">Tersedia</label>
            </div>
            <div class="form-check form-check-inline mb-2 form-check-danger">
                <input class="form-check-input" type="radio" name="ketersediaan" id="ketersediaan-false" value="0">
                <label class="form-check-label" for="ketersediaan-false">Tidak Tersedia</label>
            </div>
        </div>

        <div class="mb-3">
            <label for="nama" class="form-label">Penanggung Jawab <span class="text-danger">*</span></label>
            <input type="text" id="nama" name="nama" placeholder="Masukkan Nama PJ" class="form-control" required/>

            <small id="error-nama" class="text-danger msg-error"></small>
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
            <input type="text" id="username" name="username" placeholder="Masukkan Username" class="form-control" required/>

            <small id="error-username" class="text-danger msg-error"></small>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" id="email" name="email" placeholder="Masukkan Email" class="form-control" required/>

            <small id="error-email" class="text-danger msg-error"></small>
        </div>
        
        <div id="group-password">
            <div class="mb-3">
                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                <input type="password" id="password" name="password" placeholder="Masukkan Password" class="form-control" required/>
    
                <small id="error-password" class="text-danger msg-error"></small>
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Ulangi Password <span class="text-danger">*</span></label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi Password" class="form-control" required/>
    
                <small id="error-password_confirmation" class="text-danger msg-error"></small>
            </div>
        </div>
        
        <x-backend.loading></x-backend.loading>
        <x-backend.btn-proses>
            <x-slot name="entity">armada</x-slot>
        </x-backend.btn-proses>
    </form>
</section>