<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admin'; 

    protected $fillable = ['idadmin', 'nama', 'usernameadmin', 'passwordadmin'];

    protected $hidden = ['passwordadmin'];

    public function getAuthIdentifierName()
    {
        return 'usernameadmin';
    }

    public function getAuthPassword()
    {
        return $this->passwordadmin;
    }
}
