<?php

namespace App\Http\Controllers;

use App\Models\Authorizable;
use Illuminate\Http\Request;
use App\Services\RoleService;
use App\Services\UserService;

class UserController extends Controller
{
    use Authorizable;
    protected $userService, $roleService;

    public function __construct(UserService $userService, RoleService $roleService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;  
    }

    // ================ DEFAULT LARAVEL ================ //
    public function index()
    {
        return view('user.index');
    }

    public function create()
    {
        return $this->roleService->viewCheckbox(null);
    }

    public function store(Request $request)
    {
        return $this->userService->store($request);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $data        = $this->userService->getDataById($id);
        $roles       = $this->roleService->viewCheckbox($data); // JIKA ALL 0:TIDAK PAKAI ALL 1:PAKAI ALL; JIKA VALUE_NAMA 0:ID 1:NAMA
        $permissions = $this->userService->viewPermissions($id);

        return [
            'data'        => $data,
            'roles'       => $roles,
            'permissions' => $permissions,
        ];
    }

    public function update(Request $request, string $id)
    {
        return $this->userService->update($request, $id);
    }

    public function destroy(string $id)
    {
        //
    }
    // ================ END DEFAULT LARAVEL ================ //

    public function loadRole()
    {
        return $this->roleService->viewComboBox(1, 0); // JIKA ALL 0:TIDAK PAKAI ALL 1:PAKAI ALL; JIKA VALUE_NAMA 0:ID 1:NAMA
    }

    public function loadData(Request $request)
    {
        return $this->userService->viewData($request);
    }

    public function delete(Request $request)
    {
        return $this->userService->delete($request);
    }
}
