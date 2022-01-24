<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class role_has_permissions extends Model
{
    use HasFactory;

    protected $table = 'role_has_permissions';
    protected $fillable = [
        'model_id', 'model_type',
    ];

     public function comptes()
    {
        return $this->hasMany('App\Compte') ;
    }


}
