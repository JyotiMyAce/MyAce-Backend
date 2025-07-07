<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Banner extends Model
{
    use HasFactory , HasUuids;
    protected $fillable = ['user_id','redirect_url','image','type','status'];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}
