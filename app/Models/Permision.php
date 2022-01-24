<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

class Permision extends Model {
     use HasApiTokens, HasFactory, Notifiable,HasRoles;
    protected $table = 'permissions';
    protected $fillable = [
        'name'
    ];

     public function comptes()
    {
        return $this->hasMany('App\Compte') ;
    }
}
