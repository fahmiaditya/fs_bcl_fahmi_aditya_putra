<?php

namespace App\Services;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Repositories\RoleRepository;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class RoleService
{
    protected $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;    
    }

    /* ==========================================================================================================
    ------------------------------------------ MEMPROSES DATA KE VIEW -------------------------------------------
    ===========================================================================================================*/
    public function viewComboBox($all, $tipe_value)
    {
        // NOTE TIPE VALUE 0:VALUE ID 1:VALUE NAME
        $data = $this->roleRepository->getDataAll();

        $output = $all == 1 ? '<option value="0">Semua</option>' : '<option value=""></option>';
        foreach ($data as $item) {
            $output .= $tipe_value == 0 ? '<option value="'.$item->id.'">'.$item->name.'</option>' : '<option value="'.$item->name.'">'.$item->name.'</option>';
        }

        return $output;
    }

    public function viewCheckbox($user)
    {
        // NOTE JIKA $USER ADA DATA MAKA PROSES EDIT JIKA TIDAK MAKA CREATE
        $data = $this->roleRepository->getDataAll();

        $item_role = '';
        foreach ($data as $item) {
            $checked = '';
            if ($user) {
                $checked = $user->hasRole($item->name) ? 'checked' : '';
            }

            $item_role .= '<div class="col-md-2 col-xxl-12">
                            <div class="form-check mb-2 form-check-success">
                                <input class="form-check-input" '.$checked.' type="checkbox" id="role_'.$item->name.'" name="roles[]" value="'.$item->name.'">
                                <label class="form-check-label" for="role_'.$item->name.'"> '.$item->name.'</label>
                            </div>
                        </div>';
        }

        $output = '<div class="row">
                    '.$item_role.'
                </div>';

        return $output;
    }

    public function viewData()
    {
        $roles       = $this->roleRepository->getDataAll();
        $permissions = $this->roleRepository->getDataPermission();

        $output = null;
        foreach ($roles as $role) {
            $parameter  = Crypt::encrypt($role->id);
            $url_update = $this->itemFormatOnClick(route('roles.update', $parameter));
            $url_delete = $this->itemFormatOnClick(route('roles.destroy', $parameter));
            $target     = Str()->slug($role->name);
            $title      = $role->name. ' Permissions';

            // PENGECEKAN HAK AKSES EDIT DI IZINKAN
            $btn_update = null;
            if (Auth()->user()->can('edit_roles')) {
                $btn_update = '<button type="button" onclick="update('.$url_update.', '.$this->itemFormatOnClick($target).')" class="btn btn-success btn-sm">Ubah '.$role->name.'</button>';
            }

            // PENGECEKAN HAK AKSES HAPUS DI IZINKAN
            $btn_delete = null;
            if (Auth()->user()->can('delete_roles')) {
                $btn_delete = '<button type="button" onclick="hapus('.$url_delete.')" class="btn btn-danger btn-sm btn-delete">Hapus '.$role->name.'</button>';
            }

            $item_perm = null;
            foreach ($permissions as $perm) {
                $per_found = $role->hasPermissionTo($perm->name);
                $checked   = $per_found ? 'checked' : '';
                $view_id   = $perm->name.'_'.Str()->slug($title);
                $view_del  = str_contains($perm->name, 'delete') ? 'text-danger' : '';

                $item_perm .=
                    '<div class="col-md-3 col-xxl-12">
                        <div class="form-check mb-2 form-check-success">
                            <input class="form-check-input permission-'.$target.'" '.$checked.' type="checkbox" id="'.$view_id.'" name="permissions[]" value="'.$perm->name.'">
                            <label class="form-check-label '.$view_del.'" for="'.$view_id.'"> '.$perm->name.'</label>
                        </div>
                    </div>';
            }

            $output .= '<div class="accordion custom-accordion" id="custom-accordion-one">
                            <div class="card mb-0">
                                <div class="card-header" id="heading'.$target.'">
                                    <h5 class="m-0 position-relative">
                                        <a class="custom-accordion-title text-reset d-block" data-bs-toggle="collapse" href="#'.$target.'" aria-expanded="true" aria-controls="'.$target.'">
                                        '.$title.' <i class="mdi mdi-chevron-down accordion-arrow"></i>
                                        </a>
                                    </h5>
                                </div>

                                <div id="'.$target.'" class="collapse" aria-labelledby="heading'.$target.'" data-bs-parent="#custom-accordion-one">
                                    <div class="card-body">
                                        <div class="row">
                                            '.$item_perm.'
                                        </div>
                                        <div class="mt-2">
                                            '.$btn_update.'
                                            '.$btn_delete.'
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
        }

        return $output;
    }

    public function itemFormatOnClick($value)
    {
        return "'".$value."'";
    }

    /* ==========================================================================================================
    ------------------------------------------- MEMPROSES DATA KE DB ---------------------------------------------
    ===========================================================================================================*/
    public function store($request)
    {
        $rules['nama'] = 'required|unique:roles,name';

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            DB::beginTransaction();
            try {
                $this->roleRepository->store($request);

                DB::commit();
                return ['result' => Response::HTTP_CREATED];
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }
        }

        return [
            'error' => $validator->errors()
        ];
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $id = Crypt::decrypt($id);
            $this->roleRepository->update($request, $id);

            DB::commit();
            return ['result' => Response::HTTP_OK];
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $id = Crypt::decrypt($id);
            $this->roleRepository->delete($id);

            DB::commit();
            return ['result' => Response::HTTP_OK];
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}