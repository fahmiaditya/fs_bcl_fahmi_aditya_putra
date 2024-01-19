<section id="limo-proses" hidden>
    <form>
        <div class="mb-3">
            <label for="kode" class="form-label">Kode</label>
            <input type="text" id="kode" name="kode" readonly class="form-control" required/>
        </div>

        <div class="mb-3">
            <label for="customer" class="form-label">Customer <span class="text-danger">*</span></label>
            @if (Auth()->user()->hasRole('Super Admin|Admin'))
                <select class="form-control" id="customer" name="customer" data-toggle="select2" data-width="100%">
                </select>
            @else
                <input type="text" id="customer_name" name="customer_name" class="form-control" value="{{ Auth()->user()->name }}" readonly/>
                <input hidden type="text" id="customer" name="customer" class="form-control" value="{{ Auth()->user()->customer->nama }}" readonly/>
            @endif

            <small id="error-customer" class="text-danger msg-error"></small>
        </div>

        <div class="mb-3">
            <label for="armada_id" class="form-label">Pilih Armada <span class="text-danger">*</span></label>
            <div class="input-group">
                <input readonly type="text" id="armada" name="armada" class="form-control" placeholder="Pilih Armada" aria-label="Pilih Armada">
                <input readonly hidden type="text" id="armada_id" name="armada_id" class="form-control">
                <input readonly hidden type="text" id="armada_kapasitas" name="armada_kapasitas" class="form-control">
                <button onclick="showModalArmada()" class="btn input-group-text btn-dark waves-effect waves-light" type="button"><i class="fe-search"></i></button>
            </div>

            <small id="error-armada" class="text-danger msg-error"></small>
        </div>

        <div class="mb-3">
            <label for="nomor" class="form-label">Barang <span class="text-danger">*</span> <small id="view-max-muatan"></small></label>
            <div id="view-barang">
                <div class="input-group">
                    <input readonly type="text" name="barang[]" class="form-control" placeholder="Nama Barang"/>
                    <input readonly type="text" name="muatan[]" class="form-control" placeholder="Perkiraan Muatan"/>
                    <button disabled id="btn-add-barang" onclick="addBarang()" class="btn input-group-text btn-dark waves-effect waves-light" type="button"><i class="fe-plus"></i></button>
                </div>
            </div>

            <small id="error-barang" class="text-danger msg-error"></small>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="lokasi_asal" class="form-label">Lokasi Asal <span class="text-danger">*</span></label>
                    <input type="text" id="lokasi_asal" name="lokasi_asal" placeholder="Ex: Sidoarjo" class="form-control" required/>
        
                    <small id="error-lokasi_asal" class="text-danger msg-error"></small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="lokasi_tujuan" class="form-label">Lokasi Tujuan <span class="text-danger">*</span></label>
                    <input type="text" id="lokasi_tujuan" name="lokasi_tujuan" placeholder="Ex: Surabaya" class="form-control" required/>
        
                    <small id="error-lokasi_tujuan" class="text-danger msg-error"></small>
                </div>
            </div>
        </div>
        
        <x-backend.loading></x-backend.loading>
        <x-backend.btn-proses>
            <x-slot name="entity">transaksi</x-slot>
        </x-backend.btn-proses>
    </form>
</section>

<x-backend.modal-armada>
    <x-slot name="route_jenis">{{ route('jenis-armada.show-combobox') }}</x-slot>
    <x-slot name="route">{{ route('armada.load-data.modal') }}</x-slot>
</x-backend.modal-armada>