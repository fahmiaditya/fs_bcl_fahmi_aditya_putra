<?php

namespace App\Repositories;

use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransaksiRepository
{
    public function getDataView($request)
    {
        $search = $request->search;
        $data   = Transaksi::where(function($s) use ($search) {
                        $s->where('kode', 'like', '%'.$search.'%')
                        ->orWhere('lokasi_tujuan', 'like', '%'.$search.'%');
                    })
                    ->with('detail')
                    ->with('customer')
                    ->with(['armada' => function($q) {
                        $q->select('*', DB::raw('(select nama from jenis_armadas ja where ja.id = armadas.jenis_armada_id) as jenis_armada'));
                    }]);

        $request->filter_status != 'All' ? $data->where('status_pengiriman', $request->filter_status) : '';

        Auth()->user()->hasRole('Customer') ? $data->where('customer_id', Auth()->user()->customer->id) : '';
        Auth()->user()->hasRole('Armada') ? $data->where('armada_id', Auth()->user()->armada->id) : '';
        
        return $data->orderBy($request->sort_field, $request->sort_asc ? 'asc' : 'desc')
                    ->paginate($request->per_page);
    }

    public function getDataById($id)
    {
        return Transaksi::with('detail')->find($id);
    }

    public function code($infix)
    {
        return Transaksi::select('kode')->where(DB::raw('CONVERT(SUBSTRING(kode, 3, 8), INT)'), '=', $infix)->orderBy('id', 'desc')->first();
    }

    public function store($request)
    {
        $tgl_pemesanan = new Carbon($request->tgl_pemesanan);
        $trans = Transaksi::create([
            'kode'          => $request->kode,
            'armada_id'     => $request->armada_id,
            'customer_id'   => $request->customer,
            'lokasi_asal'   => $request->lokasi_asal,
            'lokasi_tujuan' => $request->lokasi_tujuan,
            'ttl_muatan'    => $request->ttl_muatan,
            'tgl_pemesanan' => $tgl_pemesanan->format('Y-m-d H:i:s'),
        ]);

        $this->storeDetail($request, $trans);
    }

    public function storeDetail($request, $trans)
    {
        foreach ($request->barang as $key => $item) {
            TransaksiDetail::create([
                'transaksi_id' => $trans->id,
                'barang'       => $item,
                'muatan'       => $request->muatan[$key],
            ]);
        }
    }

    public function update($request, $id)
    {
        $trans = Transaksi::find($id);

        if ($request->tgl_pengiriman) {
            $tgl_pengiriman        = new Carbon($request->tgl_pengiriman);
            $trans->tgl_pengiriman = $tgl_pengiriman->format('Y-m-d H:i:s');
        }

        if ($request->tgl_tiba) {
            $tgl_tiba        = new Carbon($request->tgl_tiba);
            $trans->tgl_tiba = $tgl_tiba->format('Y-m-d H:i:s');
        }

        $trans->status_pengiriman = $request->status;
        $trans->deskripsi         = $request->deskripsi;
        $trans->save();
    }

    public function updateLokasi($request, $id)
    {
        Transaksi::find($id)->update(['lokasi_update' => $request->lokasi_update]);
    }

    public function delete($id)
    {
        Transaksi::destroy($id);
    }
}