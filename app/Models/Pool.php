<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * @property Collection $poolInvitationsEmails
 */
class Pool extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'isClosed',
    ];

    /**
     * get Pools user
     */
    public function users()
    {
        return $this->belongsToMany(User::class,'users_pools');
    }

    /**
     * get Pools user
     */
    public function competitions()
    {
        return $this->belongsToMany(Competition::class,'pools_competitions');
    }

    /**
     * get Pools user
     */
    public function poolInvitationsEmails()
    {
        return $this->hasMany(PoolInvitationsEmails::class);
    }
}
