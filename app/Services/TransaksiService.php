<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Repositories\ArmadaRepository;
use App\Repositories\TransaksiRepository;
use Illuminate\Support\Facades\Validator;

class TransaksiService
{
    protected $transaksiRepository, $armadaRepository;

    public function __construct(TransaksiRepository $transaksiRepository, ArmadaRepository $armadaRepository)
    {
        $this->transaksiRepository = $transaksiRepository;    
        $this->armadaRepository    = $armadaRepository;
    }

    /* ==========================================================================================================
    ------------------------------------------ MEMPROSES DATA KE VIEW -------------------------------------------
    ===========================================================================================================*/
    public function viewData($request)
    {
        $data       = $this->transaksiRepository->getDataView($request);
        $item_table = $this->itemTable($data);
        $pagination = $this->pagination($data, 0);

        return [
            'item_table' => $item_table,
            'pagination' => $pagination,
            'count_page' => count($data->items()),
        ];
    }

    public function itemTable($data)
    {
        $item_table = null;
        if (count($data->items()) > 0) {
            foreach ($data as $key => $item) {
                $parameter         = Crypt::encrypt($item->id);
                $url_update        = $this->itemFormatOnClick(route('transaksi.update', $parameter));
                $url_lokasi        = $this->itemFormatOnClick(route('transaksi.loadLokasi', $parameter));
                $url_update_lokasi = $this->itemFormatOnClick(route('transaksi.update-lokasi', $parameter));
                $url_detail        = $this->itemFormatOnClick(route('transaksi.load-detail', $parameter));
                
                if ($item->status_pengiriman == 0) {
                    $status = '<span class="badge badge-outline-danger rounded-pill">Tertunda</span>';
                } elseif ($item->status_pengiriman == 1) {
                    $status = '<span class="badge badge-outline-warning rounded-pill">Dalam Perjalanan</span>';
                } else {
                    $status = '<span class="badge badge-outline-success rounded-pill">Telah Tiba</span>';
                }

                // DETAIL BARANG
                $detail_barang = '';
                foreach ($item->detail as $item_detail) {
                    $detail_barang .= '<li>'.$item_detail->barang.' | <small>Muatan</small> : '.$item_detail->muatan.'</li>';
                }

                // PENGECEKAN HAK AKSES BUTTON
                // $btn_update        = '';
                $btn_pengiriman    = '';
                $btn_update_lokasi = '';
                $btn_detail        = '';
                $tgl_pemesanan     = $this->itemFormatOnClick($item->tgl_pemesanan);
                $tgl_pengiriman    = $this->itemFormatOnClick($item->tgl_pengiriman);
                $tgl_tiba          = $this->itemFormatOnClick($item->tgl_tiba);
                $deskripsi         = $this->itemFormatOnClick($item->deskripsi);

                if (Auth()->user()->can('edit_transaksi')) {
                    if (Auth()->user()->hasRole('Super Admin|Admin|Customer')) {
                        // $btn_update = '<button onclick="edit('.$url_update.')" class="btn btn-success btn-sm btn-ubah">Ubah</button>';
                        $btn_detail = '<button onclick="showModalDetail('.$url_detail.')" class="btn btn-warning btn-sm btn-ubah mt-1">Detail</button>';
                    }
                }

                if (Auth()->user()->hasRole('Super Admin|Admin')) {
                    $btn_pengiriman    = '<button onclick="showModalPengiriman('.$url_update.', '.$tgl_pemesanan.', '.$tgl_pengiriman.', '.$tgl_tiba.', '.$this->itemFormatOnClick($detail_barang).', '.$item->status_pengiriman.', '.$deskripsi.', '.$item->armada_id.')" class="btn btn-primary btn-sm btn-ubah mt-1">Pengiriman</button>';
                    $btn_update_lokasi = '<button onclick="showModalLokasi('.$url_lokasi.', '.$url_update_lokasi.')" class="btn btn-secondary btn-sm btn-ubah mt-1">Update Lokasi</button>';
                }

                if (Auth()->user()->hasRole('Armada')) {
                    $btn_update_lokasi = '<button onclick="showModalLokasi('.$url_lokasi.', '.$url_update_lokasi.')" class="btn btn-secondary btn-sm btn-ubah mt-1">Update Lokasi</button>';
                }

                $item_table .=
                    '<tr>
                        <td>
                            <div class="form-check form-check-success">
                                <input onclick="cb_click()" class="form-check-input cb_id" type="checkbox" value="'.$parameter.'" id="check_'.$item->id.'">
                            </div>
                        </td>
                        <td>'.$data->firstItem() + $key.'</td>
                        <td>'.$item->kode.'</td>
                        <td>'.$item->customer->nama.'</td>
                        <td>'.$item->armada->jenis_armada.' | <b>'.$item->armada->nomor.'</b></td>
                        <td>'.Carbon::parse($item->tgl_pemesanan)->translatedFormat('d M Y H:i:s').'</td>
                        <td>'.$item->lokasi_asal.'</td>
                        <td>'.$item->lokasi_tujuan.'</td>
                        <td>'.$status.'</td>
                        <td>
                            '.$btn_detail.'
                            '.$btn_pengiriman.'
                            '.$btn_update_lokasi.'
                        </td>
                    </tr>';
            }
        } else {
            $item_table = '<tr><td class="border px-4 py-2 text-center" colspan="12">Empty data</td></tr>';
        }

        return $item_table;
    }

    public function pagination($data, $tipe)
    {
        // PAGINATION
        $pagination = null;
        if ($data->hasPages()) {

            // NOTE TYPE 0:INDEX DEFAULT 1:INDEX MODAL
            
            if ($tipe == 0) {
                // PREVIOUS PAGE
                if ($data->onFirstPage()) {
                    $previous =
                        '<li class="page-item disabled" aria-disabled="true">'.
                            '<span class="page-link">« Previous</span>'.
                        '</li>';
                } else {
                    $previous =
                        '<li class="page-item">'.
                            '<a class="page-link" href="javascript:void(0)" data-link="'.$data->previousPageUrl().'" rel="previous">« Previous</a>'.
                        '</li>';
                }

                // NEXT PAGE
                if ($data->hasMorePages()) {
                    $next =
                        '<li class="page-item">'.
                            '<a class="page-link" href="javascript:void(0)" data-link="'.$data->nextPageUrl().'" rel="next">Next »</a>'.
                        '</li>';
                } else {
                    $next =
                        '<li class="page-item disabled" aria-disabled="true">'.
                            '<span class="page-link">Next »</span>'.
                        '</li>';
                }

                $item_paginate = null;
                $conv_data     = (object) $data->toArray();
                foreach ($conv_data->links as $item) {
                    $active = null;

                    if ($item['active']) {
                        $active = 'active';
                    }

                    if ($item['url'] == null) {
                        $item_paginate .=
                                '<li class="page-item '.$active.'" aria-current="page">'.
                                    '<span class="page-link">'.$item["label"].'</span>'.
                                '</li>';
                    } else {
                        $item_paginate .=
                                '<li class="page-item '.$active.'" aria-current="page">'.
                                    '<a class="page-link" data-link="'.$item["url"].'" href="javascript:void(0)">'.$item["label"].'</a>'.
                                '</li>';
                    }
                }

                $pagination =
                        '<nav class="d-flex justify-items-center justify-content-between">'.
                            '<div class="d-flex justify-content-center flex-fill d-sm-none">'.
                                '<ul class="pagination">'.
                                    $previous.
                                    $next.
                                '</ul>'.
                            '</div>'.
                            '<div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">'.
                                '<div>'.
                                    '<p class="small text-muted">'.
                                        'Showing'.
                                        '<span class="font-medium"> '.$data->firstItem().' </span>'.
                                        'to'.
                                        '<span class="font-medium"> '.$data->lastItem().' </span>'.
                                        'of'.
                                        '<span class="font-medium"> '.$data->total().' </span>'.
                                        'results'.
                                    '</p>'.
                                '</div>'.
                                '<div>'.
                                    '<ul class="pagination">'.
                                        $item_paginate.
                                    '</ul>'.
                                '</div>'.
                            '</div>'.
                        '</nav>';
            } else {
                // PREVIOUS PAGE
                if ($data->onFirstPage()) {
                    $previous = '<span class="page-link">« Previous</span>';
                } else {
                    $previous = '<a class="page-link" href="javascript:void(0)" data-link="'.$data->previousPageUrl().'" rel="previous">« Previous</a>';
                }

                // NEXT PAGE
                if ($data->hasMorePages()) {
                    $next = '<a class="page-link" href="javascript:void(0)" data-link="'.$data->nextPageUrl().'" rel="next">Next »</a>';
                } else {
                    $next = '<span class="page-link">Next »</span>';
                }

                $pagination =
                        '<nav>'.
                            '<div class="pagination-modal-dosen text-center">'.
                                $previous.
                                $next.
                            '</div>'.
                        '</nav>';
            }
        }

        return $pagination;
    }

    public function itemFormatOnClick($value)
    {
        return "'".$value."'";
    }

    public function getDataById($id)
    {
        $data_id     = Crypt::decrypt($id);
        $data        = $this->transaksiRepository->getDataById($data_id);
        $data['key'] = $id;

        $tgl_kirim   = $data->tgl_pengiriman ? Carbon::parse($data->tgl_pengiriman)->translatedFormat('l, d M Y H:i:s') : 'Data Kosong';
        $tgl_tiba    = $data->tgl_tiba ? Carbon::parse($data->tgl_tiba)->translatedFormat('l, d M Y H:i:s') : 'Data Kosong';
        $view_barang = $this->viewDetailBarang($data->detail); 

        $data['view_tgl_kirim']     = $tgl_kirim;
        $data['view_tgl_tiba']      = $tgl_tiba;
        $data['view_barang']        = $view_barang;
        $data['view_lokasi_update'] = $data->lokasi_update ? $data->lokasi_update : '<div class="border text-center">Data Kosong</div>'; 

        return $data;
    }

    public function viewDetailBarang($barang)
    {
        $output = '';
        foreach ($barang as $item) {
            $output .= '<tr>
                            <td>'.$item->barang.'</td>
                            <td>'.$item->muatan.'</td>
                        </tr>';
        }

        return $output;
    }

    public function makeCode()
    {
        // MEMBUAT CODE
        $date   = Carbon::now();
        $prefix = "TR";
        $infix  = $date->format('Ymd');
        $temp   = $this->transaksiRepository->code($infix);

        if ($temp) {
            $id = substr($temp->kode,11,4) + 1;

            if( $id < 10){
                $code = $prefix.$infix."000".$id;
            }elseif( $id < 100){
                $code = $prefix.$infix."00".$id;
            }elseif( $id < 1000){
                $code = $prefix.$infix."0".$id;
            }else{
                $code = $prefix.$infix.$id;
            }
        } else {
            $code = $prefix.$infix."0001";
        }

        return $code;
    }

    /* ==========================================================================================================
    ------------------------------------------- MEMPROSES DATA KE DB --------------------------------------------
    ===========================================================================================================*/
    public function store($request)
    {
        $rules = [];
        $rules['armada']        = 'required';
        $rules['barang']        = 'required|array|min:1';
        $rules['barang.*']      = 'required';
        $rules['muatan']        = 'required|array|min:1';
        $rules['muatan.*']      = 'required';
        $rules['lokasi_asal']   = 'required';
        $rules['lokasi_tujuan'] = 'required';

        if (Auth()->user()->hasRole('Super Admin|Admin')) {
            $rules['customer'] = 'required';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            DB::beginTransaction();
            try {
                $this->transaksiRepository->store($request);
                $this->armadaRepository->updateKetersediaan($request->armada_id, 0);
                
                DB::commit();
                return ['result' => Response::HTTP_CREATED];
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }
        }

        return [
            'error' => $validator->errors(),
        ];
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $id = Crypt::decrypt($id);
            $this->transaksiRepository->update($request, $id);

            if ($request->status == 2) {
                $this->armadaRepository->updateKetersediaan($request->armada, 1);
            }
            
            DB::commit();
            return ['result' => Response::HTTP_CREATED];
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updateLokasi($request, $id)
    {
        $rules = [];
        $rules['lokasi_update'] = 'required';
        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            DB::beginTransaction();
            try {
                $id = Crypt::decrypt($id);
                $this->transaksiRepository->updateLokasi($request, $id);
                
                DB::commit();
                return ['result' => Response::HTTP_CREATED];
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }
        }

        return [
            'error' => $validator->errors(),
        ];
    }

    public function delete($request)
    {
        DB::beginTransaction();
        try {
            foreach ($request->id as $item_id) {
                $id = Crypt::decrypt($item_id);
                $trans = $this->transaksiRepository->getDataById($id);

                if ($trans->status_pengiriman == 0) {
                    $this->armadaRepository->updateKetersediaan($trans->armada_id, 1);
                    $this->transaksiRepository->delete($id);
                } else {
                    return ['result' => Response::HTTP_UNAVAILABLE_FOR_LEGAL_REASONS];
                }
            }

            DB::commit();
            return ['result' => Response::HTTP_OK];
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}