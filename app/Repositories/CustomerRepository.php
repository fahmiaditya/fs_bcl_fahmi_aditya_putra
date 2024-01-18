<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Customer;

class CustomerRepository
{
    public function getDataView($request)
    {
        $search = $request->search;
        $data   = Customer::select('customers.*', 'users.username', 'users.email')
                    ->join('users', 'users.id', 'customers.user_id')
                    ->where(function($s) use ($search) {
                        $s->where('customers.nama', 'like', '%'.$search.'%')
                        ->orWhere('customers.alamat', 'like', '%'.$search.'%')
                        ->orWhere('customers.telepon', 'like', '%'.$search.'%')
                        ->orWhere('users.username', 'like', '%'.$search.'%')
                        ->orWhere('users.email', 'like', '%'.$search.'%');
                    });

        return $data->orderBy($request->sort_field, $request->sort_asc ? 'asc' : 'desc')
                    ->paginate($request->per_page);
    }

    public function getDataById($id)
    {
        return Customer::find($id);
    }

    public function store($request)
    {
        $user = User::create([
            'name'     => $request->nama,
            'username' => trim($request->username),
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->syncRoles('Customer');

        Customer::create([
            'user_id' => $user->id,
            'nama'    => $request->nama,
            'alamat'  => $request->alamat,
            'telepon' => $request->telepon,
        ]);
    }

    public function update($request, $id)
    {
        Customer::where('id', $id)->update([
            'nama'    => $request->nama,
            'alamat'  => $request->alamat,
            'telepon' => $request->telepon,
        ]);
    }

    public function delete($id)
    {
        Customer::destroy($id);
    }
}