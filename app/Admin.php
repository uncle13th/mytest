<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $guard = 'admin';

    protected $fillable = [
        'username', 'password', 'name', 'avatar'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $guard_name = 'admin';
}
