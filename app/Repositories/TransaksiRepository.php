<?php

namespace App\Repositories;

use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class TransaksiRepository
{
    public function getDataView($request)
    {
        $search = $request->search;
        $data   = Transaksi::where(function($s) use ($search) {
                        $s->where('kode', 'like', '%'.$search.'%');
                    })
                    ->with('customer')
                    ->with(['armada' => function($q) {
                        $q->select('*', DB::raw('(select nama from jenis_armadas ja where ja.id = armadas.jenis_armada_id) as jenis_armada'));
                    }]);

        Auth()->user()->hasRole('Customer') ? $data->where('customer_id', Auth()->user()->customer->id) : '';
        
        return $data->orderBy($request->sort_field, $request->sort_asc ? 'asc' : 'desc')
                    ->paginate($request->per_page);
    }

    public function code($infix)
    {
        return Transaksi::select('kode')->where(DB::raw('CONVERT(SUBSTRING(kode, 3, 8), INT)'), '=', $infix)->orderBy('id', 'desc')->first();
    }

    public function store($request)
    {
        Transaksi::create([
            'kode'          => $request->kode,
            'armada_id'     => $request->armada_id,
            'customer_id'   => $request->customer,
            'lokasi_asal'   => $request->lokasi_asal,
            'lokasi_tujuan' => $request->lokasi_tujuan,
            'ttl_muatan'    => $request->ttl_muatan,
        ]);
    }
}