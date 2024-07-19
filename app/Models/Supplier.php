<?php

namespace App\Models;

class Supplier extends User
{
    protected $table = 'users';

    protected $fillable = ['name', 'email', 'password', 'store_name', 'type'];
}
