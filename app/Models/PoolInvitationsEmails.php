<?php

namespace App\Models;

use App\Events\AcceptInvitationPool;
use App\Models\Common\AggregateRoot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $pool_id
 * @property string $email
 * @property boolean $effective
 * @property boolean|null $accepted
 * @property Pool $pool
 * @property string $created_at
 * @property string $updated_at
 */
class PoolInvitationsEmails extends AggregateRoot
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

    public function accept($userId)
    {
        $this->accepted = true;

        $this->user_id = $userId;

        $this->save();

        //record event
        $this->record(new AcceptInvitationPool($this));
    }

    public function reject($userId)
    {
        $this->accepted = false;

        $this->user_id = $userId;

        $this->save();
    }
}
