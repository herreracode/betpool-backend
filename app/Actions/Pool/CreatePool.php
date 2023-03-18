<?php

namespace App\Actions\Pool;

use App\Exceptions\Pool\CompetitionMustBeUniqueInAPool;
use App\Models\Competition;
use App\Models\Enums\RoleUsers;
use App\Models\Pool;
use App\Models\User;
use Exception;
use Spatie\Permission\Models\Role;

/**
 * Class CreatePool
 *
 * @package App\Actions\Pool
 */
class CreatePool
{

    public function __invoke(
        User $UserCreator,
        string $namePool,
        iterable $competitions = null
    ): Pool {

        $this->haveCompetitionUnique($competitions);

        $Pool = $this->createPool($namePool);

        $this->assingRoleUserCreator($UserCreator, $Pool);

        //add user creator
        $Pool->users()->attach($UserCreator);

        //add competitions to pool
        $competitions && $Pool->competitions()->attach($competitions);

        return $Pool;
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

    protected function createPool(string $namePool)
    {
        $Pool = new Pool();

        $Pool->name = $namePool;

        if (! $Pool->save()) {
            throw new Exception('dont save Pool');
        }

        return $Pool;
    }

    protected function assingRoleUserCreator(User $UserCreator, Pool $Pool)
    {
        setPermissionsTeamId($Pool->id);

        $RolePoolAdmin = Role::create([
            'name' => RoleUsers::PoolAdmin
        ]);

        $UserCreator->assignRole($RolePoolAdmin);
    }
}
