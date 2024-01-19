<?php

namespace App\Http\Controllers;

use App\Models\Armada;
use App\Models\Authorizable;
use Illuminate\Http\Request;
use App\Services\ArmadaService;
use App\Services\JenisArmadaService;

class ArmadaController extends Controller
{
    use Authorizable;
    protected $armadaService, $jenisArmadaService;

    public function __construct(ArmadaService $armadaService, JenisArmadaService $jenisArmadaService)
    {
        $this->armadaService      = $armadaService;
        $this->jenisArmadaService = $jenisArmadaService;
    }

    // ================ DEFAULT LARAVEL ================ //
    public function index()
    {
        return view('armada.index');
    }

    public function create()
    {
        return $this->jenisArmadaService->viewCombobox();
    }

    public function store(Request $request)
    {
        return $this->armadaService->store($request);
    }

    public function show(Armada $armada)
    {
        //
    }

    public function edit($id)
    {
        return [
            'jenis' => $this->jenisArmadaService->viewCombobox(),
            'data'  => $this->armadaService->getDataById($id),
        ];
    }

    public function update(Request $request, $id)
    {
        return $this->armadaService->update($request, $id);
    }

    public function destroy(Armada $armada)
    {
        //
    }
    // ================ END DEFAULT LARAVEL ================ //

    public function loadData(Request $request)
    {
        return $this->armadaService->viewData($request);
    }

    public function delete(Request $request)
    {
        return $this->armadaService->delete($request);
    }
}
