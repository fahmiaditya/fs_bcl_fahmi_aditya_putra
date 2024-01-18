<?php

namespace App\Services;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Repositories\CustomerRepository;
use Illuminate\Support\Facades\Validator;

class CustomerService
{
    protected $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;    
    }

    /* ==========================================================================================================
    ------------------------------------------ MEMPROSES DATA KE VIEW -------------------------------------------
    ===========================================================================================================*/
    public function viewData($request)
    {
        $data       = $this->customerRepository->getDataView($request);
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
                $parameter  = Crypt::encrypt($item->id);
                $url_update = $this->itemFormatOnClick(route('customer.update', $parameter).'/edit');

                // PENGECEKAN HAK AKSES EDIT DI IZINKAN
                $btn_update = '-';
                if (Auth()->user()->can('edit_customer')) {
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
                        <td>'.$item->nama.'</td>
                        <td>'.$item->username.'</td>
                        <td>'.$item->email.'</td>
                        <td>'.$item->alamat.'</td>
                        <td>'.$item->telepon.'</td>
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
        $data        = $this->jenisArmadaRepository->getDataById($data_id);
        $data['key'] = $id;

        return $data;
    }

    /* ==========================================================================================================
    ------------------------------------------- MEMPROSES DATA KE DB --------------------------------------------
    ===========================================================================================================*/
    public function store($request)
    {
        $rules = [];
        $rules['nama']     = 'required|min:2';
        $rules['alamat']   = 'required|min:2';
        $rules['telepon']  = 'required|min:2';
        $rules['username'] = 'required|min:2|unique:users,username';
        $rules['email']    = 'required|email|unique:users';
        $rules['password'] = 'required|confirmed|min:6';

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            DB::beginTransaction();
            try {
                $this->customerRepository->store($request);
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
}