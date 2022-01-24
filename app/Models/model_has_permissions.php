<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class model_has_permissions extends Model
{
    use HasFactory,HasRoles;

     protected $table = 'role_has_permissions';
    protected $fillable = [
        'permission_id ', 'role_id',
    ];

     public function comptes()
    {
        return $this->hasMany('App\Compte') ;
    }
}
