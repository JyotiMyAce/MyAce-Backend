<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasRoles , Notifiable , HasUuids;
    protected $fillable = [
        'name', 'phone' ,'email', 'status', 'password',
    ];

    public function banner():HasMany{
        return $this->hasMany(Banner::class);
    }
}
