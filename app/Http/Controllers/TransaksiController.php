<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Services\CustomerService;
use App\Services\TransaksiService;

class TransaksiController extends Controller
{
    protected $transaksiService, $customerService;
    public function __construct(TransaksiService $transaksiService, CustomerService $customerService)
    {
        $this->transaksiService = $transaksiService;
        $this->customerService  = $customerService;
    }

    // ================ DEFAULT LARAVEL ================ //
    public function index()
    {
        return view('transaksi.index');
    }

    public function create()
    {
        return [
            'kode'     => $this->transaksiService->makeCode(),
            'customer' => Auth()->user()->hasRole('Super Admin|Admin') ? $this->customerService->viewCombobox(0) : null,
        ];
    }
    
    public function store(Request $request)
    {
        return $this->transaksiService->store($request);
    }

    public function show(Transaksi $transaksi)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        return $this->transaksiService->update($request, $id);
    }

    public function destroy(Transaksi $transaksi)
    {
        //
    }
    // ================ END DEFAULT LARAVEL ================ //

    public function loadData(Request $request)
    {
        return $this->transaksiService->viewData($request);
    }

    public function delete(Request $request)
    {
        return $this->transaksiService->delete($request);
    }

    public function loadLokasi($id)
    {
        return $this->transaksiService->getDataById($id)->lokasi_update;
    }

    public function updateLokasi(Request $request, $id)
    {
        return $this->transaksiService->updateLokasi($request, $id);
    }

    public function loadDetail($id)
    {
        return $this->transaksiService->getDataById($id);
    }
}
