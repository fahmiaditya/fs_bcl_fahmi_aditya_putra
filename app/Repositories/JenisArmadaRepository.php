<?php

namespace App\Repositories;

use App\Models\JenisArmada;

class JenisArmadaRepository
{
    public function getDataView($request)
    {
        $search = $request->search;
        $data   = JenisArmada::where(function($s) use ($search) {
                        $s->where('nama', 'like', '%'.$search.'%');
                    });

        return $data->orderBy($request->sort_field, $request->sort_asc ? 'asc' : 'desc')
                    ->paginate($request->per_page);
    }

    public function getDataAll()
    {
        return JenisArmada::all();
    }

    public function getDataById($id)
    {
        return JenisArmada::find($id);
    }

    public function store($request)
    {
        JenisArmada::create([
            'nama' => $request->nama,
        ]);
    }

    public function update($request, $id)
    {
        JenisArmada::where('id', $id)->update([
            'nama' => $request->nama,
        ]);
    }

    public function delete($id)
    {
        JenisArmada::destroy($id);
    }
}