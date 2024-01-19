<?php

namespace App\Repositories;

use App\Models\Armada;

class ArmadaRepository
{
    public function getDataView($request)
    {
        $search = $request->search;
        $data   = Armada::where(function($s) use ($search) {
                        $s->where('nomor', 'like', '%'.$search.'%');
                    })->with('jenisArmada');
        
        $request->filter_ketersediaan != 'All' ? $data->where('ketersediaan', $request->filter_ketersediaan) : '';

        return $data->orderBy($request->sort_field, $request->sort_asc ? 'asc' : 'desc')
                    ->paginate($request->per_page);
    }

    public function getDataById($id)
    {
        return Armada::with('jenisArmada')->find($id);
    }

    public function store($request)
    {
        Armada::create([
            'jenis_armada_id' => $request->jenis,
            'nomor'           => $request->nomor,
            'kapasitas'       => $request->kapasitas,
            'ketersediaan'    => $request->ketersediaan,
        ]);
    }

    public function update($request, $id)
    {
        Armada::find($id)->update([
            'jenis_armada_id' => $request->jenis,
            'nomor'           => $request->nomor,
            'kapasitas'       => $request->kapasitas,
            'ketersediaan'    => $request->ketersediaan,
        ]);
    }

    public function delete($id)
    {
        Armada::destroy($id);
    }
}