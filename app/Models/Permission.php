<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends \Spatie\Permission\Models\Permission
{
    use HasFactory;

    public static function defaultPermissions()
    {
        return [
            'view_users',
            'add_users',
            'edit_users',
            'delete_users',

            'view_roles',
            'add_roles',
            'edit_roles',
            'delete_roles',

            'view_jenis-armada',
            'add_jenis-armada',
            'edit_jenis-armada',
            'delete_jenis-armada',

            'view_armada',
            'add_armada',
            'edit_armada',
            'delete_armada',

            'view_customer',
            'add_customer',
            'edit_customer',
            'delete_customer',
        ];
    }
}
