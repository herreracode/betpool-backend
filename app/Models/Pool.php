<?php

namespace App\Models;

use App\Events\CreatedPool;
use App\Exceptions\Pool\CompetitionMustBeUniqueInAPool;
use App\Exceptions\Pool\PoolHasPredictions;
use App\Exceptions\Pool\UserDoesntBelongToThePool;
use App\Exceptions\PoolRound\AlreadyHavePoolRoundPending;
use App\Exceptions\PoolRound\GameIsNotPending;
use App\Exceptions\PoolRound\UserDoesNotHaveTheRequiredRole;
use App\Models\Common\AggregateRoot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use App\Models\Enums\PoolRoundStatus;

/**
 * @property Collection $poolInvitationsEmails
 * @property string $name
 */
class Pool extends AggregateRoot
{
    use HasFactory, SoftDeletes;

    protected const NAME_TABLE_INTERMEDIATE_USER = 'users_pools';

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
        return $this->belongsToMany(User::class,static::NAME_TABLE_INTERMEDIATE_USER);
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
    public function poolRound()
    {
        return $this->hasMany(PoolRound::class);
    }

    public function predictions()
    {
        return $this->hasMany(Prediction::class);
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

        $Pool->record(new CreatedPool($Pool));

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

        $haveUniqueCompetition = $competitionsCollect
                ->filter(fn (Competition $competition) => $competition->must_be_unique)
                ->count() > 0;

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

    /**
     * @return bool
     */
    public function doesItbelongsToThePool(User $User) :bool
    {
        $doesItBelongsToThePool = $this->users()->where([
            static::NAME_TABLE_INTERMEDIATE_USER .'.user_id' => $User->id
        ])->count() > 0;

        if (!$doesItBelongsToThePool)
            throw UserDoesntBelongToThePool::create("User {$User->id} doesnt belong to pool {$this->id}");

        return true;
    }

    public function createRound(User $UserCreator, iterable $Games) :PoolRound
    {
        $this->alreadyHaveOnePending();

        $this->someGameIsInNonPendingState($Games);

        $this->userCreatorIsPoolAdmin($UserCreator);

        $PoolRound = $this->poolRound()->create();

        $PoolRound->games()->attach($Games);

        return $PoolRound->refresh();
    }

    /**
     * @return bool
     */
    protected function someGameIsInNonPendingState(iterable $Games):bool
    {
        $someGameIsInNonPendingState = collect($Games)
                ->filter(fn (Game $Game) => !$Game->itIsPending())
                ->count() > 0;

        if($someGameIsInNonPendingState)
            throw GameIsNotPending::create("some game is not pending");

        return true;
    }

    protected function userCreatorIsPoolAdmin(User $UserCreator):bool
    {
        if(!$UserCreator->hasRolePoolAdmin($this))
            throw UserDoesNotHaveTheRequiredRole::create('the user dont have the require role');

        return true;
    }

    protected function alreadyHaveOnePending():bool
    {
        $haveAlreadyOneRoundPending = $this
        ->poolRound()
        ->where('status', '=', PoolRoundStatus::PENDING->value)
        ->get()
        ->count() > 0;

        if ($haveAlreadyOneRoundPending)
            throw AlreadyHavePoolRoundPending::create('already have one pool round pending');

        return true;
    }

    public function delete():bool
    {
        if($this->hasPredictions())
            throw new PoolHasPredictions("pool has predictions");

        return parent::delete();
    }

    protected function hasPredictions(): bool
    {
        return $this->predictions->count() > 0;
    }
}
