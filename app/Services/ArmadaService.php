<?php

namespace App\Services;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Repositories\ArmadaRepository;
use Illuminate\Support\Facades\Validator;

class ArmadaService
{
    protected $armadaRepository;

    public function __construct(ArmadaRepository $armadaRepository)
    {
        $this->armadaRepository = $armadaRepository;    
    }

    /* ==========================================================================================================
    ------------------------------------------ MEMPROSES DATA KE VIEW -------------------------------------------
    ===========================================================================================================*/
    public function viewData($request)
    {
        $data       = $this->armadaRepository->getDataView($request);
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
                $parameter    = Crypt::encrypt($item->id);
                $url_update   = $this->itemFormatOnClick(route('armada.update', $parameter).'/edit');
                $ketersediaan = $item->ketersediaan == 1 ? '<span class="badge badge-outline-success rounded-pill">Tersedia</span>' 
                                    : '<span class="badge badge-outline-danger rounded-pill">Tidak Tersedia</span>';

                // PENGECEKAN HAK AKSES EDIT DI IZINKAN
                $btn_update = '-';
                if (Auth()->user()->can('edit_armada')) {
                    $btn_update = '<button onclick="edit('.$url_update.')" class="btn btn-success btn-sm btn-ubah">Ubah</button>';
                }

                $item_table .=
                    '<tr>
                        <td>
                            <div class="form-check form-check-success">
                                <input onclick="cb_click()" class="form-check-input cb_id" type="checkbox" value="'.$parameter.'" id="check_'.$item->id.'">
                            </div>
                        </td>
                        <td>'.$data->firstItem() + $key.'</td>
                        <td>'.$item->jenisArmada->nama.'</td>
                        <td>'.$item->nomor.'</td>
                        <td>'.number_format($item->kapasitas, 0, ",", ".").'</td>
                        <td>'.$ketersediaan.'</td>
                        <td>
                            '.$btn_update.'
                        </td>
                    </tr>';
            }
        } else {
            $item_table = '<tr><td class="border px-4 py-2 text-center" colspan="8">Empty data</td></tr>';
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
                            '<div class="pagination-modal-armada text-center">'.
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
        $data        = $this->armadaRepository->getDataById($data_id);
        $data['key'] = $id;

        return $data;
    }

    public function viewDataModal($request)
    {
        $data       = $this->armadaRepository->getDataViewModal($request);
        $item_table = $this->itemTableModal($data);
        $pagination = $this->pagination($data, 1);

        return [
            'item_table' => $item_table,
            'pagination' => $pagination
        ];
    }

    public function itemTableModal($data)
    {
        $item_table = null;
        if (count($data->items()) > 0) {
            foreach ($data as $key => $item) {
                $item_table .=
                    '<tr>
                        <td>
                            <div class="form-check form-check-inline mb-2 form-check-success">
                                <input id="rb_modal'.$item->id.'" data-kapasitas="'.$item->kapasitas.'" data-armada="'.$item->jenisArmada->nama.' | '.$item->nomor.'" name="rb_modal" class="form-check-input" type="radio" value="'.$item->id.'">
                                <label class="form-check-label" for="rb_modal'.$item->id.'">&nbsp;</label>
                            </div>
                        </td>
                        <td>'.$data->firstItem() + $key.'</td>
                        <td>'.$item->jenisArmada->nama.'</td>
                        <td>'.$item->nomor.'</td>
                        <td>'.number_format($item->kapasitas, 0, ",", ".").'</td>
                    </tr>';
            }
        } else {
            $item_table = '<tr><td class="border px-4 py-2 text-center" colspan="8">Empty data</td></tr>';
        }

        return $item_table;
    }

    /* ==========================================================================================================
    ------------------------------------------- MEMPROSES DATA KE DB --------------------------------------------
    ===========================================================================================================*/

    public function store($request)
    {
        $rules = [];
        $rules['nomor']     = 'required|min:2|unique:armadas,nomor';
        $rules['jenis']     = 'required';
        $rules['kapasitas'] = 'required|numeric|min:1';

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            DB::beginTransaction();
            try {
                $this->armadaRepository->store($request);
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
        $rules = [];
        $rules['jenis']     = 'required';
        $rules['kapasitas'] = 'required|numeric|min:1';
        
        $id = Crypt::decrypt($id);
        if ($this->armadaRepository->getDataById($id)->nomor != $request->nomor) {
            $rules['nomor'] = 'required|min:2|unique:armadas,nomor';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            DB::beginTransaction();
            try {
                $this->armadaRepository->update($request, $id);
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
                $this->armadaRepository->delete($id);
            }

            DB::commit();
            return ['result' => Response::HTTP_OK];
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}