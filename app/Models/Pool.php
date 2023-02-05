<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pool extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * get Pools user
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
