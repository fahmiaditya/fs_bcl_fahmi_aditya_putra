<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\Permission;

class RoleRepository
{
    public function getDataAll()
    {
        return Role::whereNotIn('name', ['Super Admin'])->get();
    }

    public function getDataPermission()
    {
        return Permission::all();
    }

    public function store($request)
    {
        $role       = new Role;
        $role->name = $request->nama;
        $role->save();
    }

    public function update($request, $id)
    {
        $role = Role::find($id);
        $role->syncPermissions($request->permissions);
    }

    public function delete($id)
    {
        Role::destroy($id);
    }
}