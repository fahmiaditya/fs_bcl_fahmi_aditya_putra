<section id="limo-proses" hidden>
    <form action="#">
        <div class="mb-3">
            <label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
            <input type="text" id="name" name="name" class="form-control"/>

            <small id="error-name" class="text-danger msg-error"></small>
        </div>
        
        <x-backend.loading></x-backend.loading>
        <x-backend.btn-proses>
            <x-slot name="entity">category</x-slot>
        </x-backend.btn-proses>
    </form>
</section>