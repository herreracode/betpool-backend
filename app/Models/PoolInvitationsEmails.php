<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $pool_id
 * @property string $email
 * @property boolean $effective
 * @property boolean|null $accepted
 * @property Pool $pool
 * @property string $created_at
 * @property string $updated_at
 */
class PoolInvitationsEmails extends Model
{
    use HasFactory;

    protected $fillable = [
        'email'
    ];

    /**
     * get Pools user
     */
    public function pool()
    {
        return $this->belongsTo(Pool::class);
    }
}
