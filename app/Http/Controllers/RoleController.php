<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Authorizable;
use Illuminate\Http\Request;
use App\Services\RoleService;

class RoleController extends Controller
{
    use Authorizable;
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    // ================ DEFAULT LARAVEL ================ //
    public function index()
    {
        return view('role.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        return $this->roleService->store($request);
    }

    public function show(Role $role)
    {
        //
    }

    public function edit(Role $role)
    {
        //
    }

    public function update(Request $request, $id)
    {
        return $this->roleService->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->roleService->delete($id);
    }
    // ================ END DEFAULT LARAVEL ================ //

    public function loadData()
    {
        return $this->roleService->viewData();
    }
}
