<section id="limo-proses" hidden>
    <form>
        <div class="mb-3">
            <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
            <input type="text" id="nama" name="nama" class="form-control"/>

            <small id="error-nama" class="text-danger msg-error"></small>
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
            <input type="text" id="alamat" name="alamat" class="form-control"/>

            <small id="error-alamat" class="text-danger msg-error"></small>
        </div>

        <div class="mb-3">
            <label for="telepon" class="form-label">Telepon <span class="text-danger">*</span></label>
            <input type="text" id="telepon" name="telepon" class="form-control"/>

            <small id="error-telepon" class="text-danger msg-error"></small>
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
            <x-slot name="entity">customer</x-slot>
        </x-backend.btn-proses>
    </form>
</section>