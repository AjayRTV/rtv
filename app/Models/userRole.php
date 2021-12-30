<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userRole extends Model {
    use HasFactory;

    /**
    * @var mixed table
    */
    protected $table = 'userrole';
    protected $fillable = [
        'firstName', 'lastName', 'contact', 'email', 'password', 'role',
    ];
}
