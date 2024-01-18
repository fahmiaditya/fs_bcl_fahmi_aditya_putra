<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;

class UserRepository 
{
    public function getDataView($request)
    {
        $search = $request->search;
        $users  = User::where('id', '>', 1)
                    ->where(function($s) use ($search) {
                        $s->where('name', 'like', '%'.$search.'%')
                        ->orWhere('username', 'like', '%'.$search.'%')
                        ->orWhere('email', 'like', '%'.$search.'%');
                    })->with('roles');

        $role = $request->filter_role;
        if ($role != 0) {
            $users->whereHas("roles", function($q) use ($role) { $q->where("id", $role); });
        }

        return $users->orderBy($request->sort_field, $request->sort_asc ? 'asc' : 'desc')
                    ->paginate($request->per_page);
    }

    public function getDataById($id)
    {
        return User::with('roles')->find($id);
    }

    public function getDataPermissions()
    {
        return Permission::select('id', 'name')->orderBy('id', 'asc')->get();
    }

    public function store($request)
    {
        $user = User::create([
            'name'     => $request->name,
            'username' => trim($request->username),
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->fill($request->except('roles', 'permissions'));
        $this->syncPermissions($request, $user);
    }

    public function update($request, $id)
    {
        $user           = User::find($id);
        $user->name     = $request->name;
        $user->username = trim($request->username);
        $user->email    = trim($request->email);
        $user->save();

        $user->fill($request->except('roles', 'permissions'));
        $this->syncPermissions($request, $user);
    }

    public function delete($id)
    {
        return User::destroy($id);
    }

    private function syncPermissions($request, $user)
    {
        // Get the submitted roles
        $roles = $request->get('roles', []);
        $permissions = $request->get('permissions', []);

        // Get the roles
        $roles = Role::whereIn('name', $roles)->get();

        // check for current role changes
        if( ! $user->hasAllRoles( $roles ) ) {
        // reset all direct permissions for user
            $user->permissions()->sync([]);
        } else {
        // handle permissions
            $user->syncPermissions($permissions);
        }

        $user->syncRoles($roles);
        return $user;
    }
}