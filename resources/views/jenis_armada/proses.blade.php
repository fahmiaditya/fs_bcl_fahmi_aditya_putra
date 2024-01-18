<section id="limo-proses" hidden>
    <form>
        <div class="mb-3">
            <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
            <input type="text" id="nama" name="nama" class="form-control"/>

            <small id="error-nama" class="text-danger msg-error"></small>
        </div>
        
        <x-backend.loading></x-backend.loading>
        <x-backend.btn-proses>
            <x-slot name="entity">jenis-armada</x-slot>
        </x-backend.btn-proses>
    </form>
</section>