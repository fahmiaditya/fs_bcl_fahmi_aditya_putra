<?php

namespace App\Http\Controllers;

use App\Models\JenisArmada;
use App\Models\Authorizable;
use Illuminate\Http\Request;
use App\Services\JenisArmadaService;

class JenisArmadaController extends Controller
{
    use Authorizable;
    protected $jenisArmadaService;

    public function __construct(JenisArmadaService $jenisArmadaService)
    {
        $this->jenisArmadaService = $jenisArmadaService;
    }

    // ================ DEFAULT LARAVEL ================ //
    public function index()
    {
        return view('jenis_armada.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        return $this->jenisArmadaService->store($request);
    }

    public function show(JenisArmada $jenisArmada)
    {
        //
    }

    public function edit($id)
    {
        return $this->jenisArmadaService->getDataById($id);
    }

    public function update(Request $request, $id)
    {
        return $this->jenisArmadaService->update($request, $id);
    }

    public function destroy(JenisArmada $jenisArmada)
    {
        //
    }
    // ================ END DEFAULT LARAVEL ================ //

    public function loadData(Request $request)
    {
        return $this->jenisArmadaService->viewData($request);
    }

    public function delete(Request $request)
    {
        return $this->jenisArmadaService->delete($request);
    }
}
