<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class HomeVideo extends Model
{
    use HasUuids;

    protected $keyType = 'string'; 
    public $incrementing = false;  

    protected $fillable = [
        'first_video',
        'second_video',
        'third_video',
    ];

}
