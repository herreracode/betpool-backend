<?php

namespace App\Models;

use App\Exceptions\Pool\CompetitionMustBeUniqueInAPool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * @property Collection $poolInvitationsEmails
 * @property string $name
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

    public static function create(string $namePool)
    {
        $Pool = new static();

        $Pool->name = $namePool;

        if (! $Pool->save()) {
            throw new \Exception('dont save Pool');
        }

        return $Pool;
    }

    public function addUser(User $User)
    {
        $this->users()->attach($User);
    }

    public function addCompetitions($competitions)
    {
        $this->haveCompetitionUnique($competitions);

        $this->competitions()->attach($competitions);
    }

    protected function haveCompetitionUnique(iterable $competitions = null)
    {
        $competitionsCollect = collect($competitions);

        $haveMoreThanOne = $competitionsCollect->count() > 1;

        $haveUniqueCompetition = $competitionsCollect->filter(function (Competition $competition){
                return $competition->must_be_unique;
            })->count() > 0;

        if($haveMoreThanOne && $haveUniqueCompetition)
            throw new CompetitionMustBeUniqueInAPool('Have competition unique');
    }

    public function createInvitationsPoolEmails(iterable $emails)
    {
        foreach ($emails as $email){
            $this->poolInvitationsEmails()->create([
                'email' => $email,
            ]);
        }
    }
}
