<?php

namespace App\Models;

use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Silber\Bouncer\Database\HasRolesAndAbilities;

class User extends Authenticatable
{
    use Notifiable;
    use HasRolesAndAbilities;
    use GeneratesUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Full Name attribute
     * @return [string] [full name]
     */
    public function getNameAttribute()
    {
        return sprintf('%s %s', $this->first_name, $this->last_name);
    }

    /**
     * Morph user type
     *
     * @return void
     */
    public function userable()
    {
        return $this->morphTo();
    }

    /**
     * Checks if this user instance is a manager
     *
     * @return boolean
     */
    public function isManager()
    {
        return ($this->userable instanceof Manager);
    }

    /**
     * Checks if this user instance is a member
     *
     * @return boolean
     */
    public function isMember()
    {
        return ($this->userable instanceof Member);
    }
}
