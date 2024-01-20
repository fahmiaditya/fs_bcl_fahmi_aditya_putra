<?php

namespace App\Repositories;

use App\Models\Armada;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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

    public function getDataViewModal($request)
    {
        $search = $request->modal_search;
        $data   = Armada::where(function($s) use ($search) {
                        $s->where('nomor', 'like', '%'.$search.'%');
                    })->with('jenisArmada')->where('ketersediaan', 1);

        $request->modal_jenis != 'All' ? $data->where('jenis_armada_id', $request->modal_jenis) : '';

        return $data->paginate(10);
    }

    public function getDataById($id)
    {
        return Armada::select('*', DB::raw('(select username from users u where u.id = armadas.user_id) as username'),
            DB::raw('(select email from users u where u.id = armadas.user_id) as email'), 
            DB::raw('(select name from users u where u.id = armadas.user_id) as nama')
        )->with('jenisArmada')->find($id);
    }

    public function store($request)
    {
        $user = User::create([
            'name'     => $request->nama,
            'username' => trim($request->username),
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->syncRoles('Armada');

        Armada::create([
            'user_id'         => $user->id,
            'jenis_armada_id' => $request->jenis,
            'nomor'           => $request->nomor,
            'kapasitas'       => $request->kapasitas,
            'ketersediaan'    => $request->ketersediaan,
        ]);
    }

    public function update($request, $id)
    {
        $armada = Armada::find($id);
        $armada->jenis_armada_id = $request->jenis;
        $armada->nomor           = $request->nomor;
        $armada->kapasitas       = $request->kapasitas;
        $armada->ketersediaan    = $request->ketersediaan;
        $armada->save();

        User::where('id', $armada->user_id)->update([
            'name'     => $request->nama,
            'username' => trim($request->username),
            'email'    => $request->email,
        ]);
    }

    public function delete($id)
    {
        Armada::destroy($id);
    }

    public function updateKetersediaan($id, $value)
    {
        Armada::find($id)->update([
            'ketersediaan' => $value,
        ]);
    }
}