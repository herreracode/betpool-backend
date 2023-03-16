<?php

namespace Tests\Unit\Game\Actions;

use App\Actions\Pool\CreatePool;
use App\Exceptions\Pool\CompetitionMustBeUniqueInAPool;
use App\Models\Competition;
use App\Models\Pool;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutEvents;
use Tests\TestCase;

class CreatePoolActionTest extends TestCase
{
    use RefreshDatabase;
    use WithoutEvents;

    protected function setUp(): void
    {
        parent::setup();

        $this->CreatePoolAction = app(CreatePool::class);
    }

    /**
     * todo: assert para que el usuario guardado tenga rol creador
     * todo: agregar competitions
     *
     * @return void
     */
    public function testCreatePoolHappyPath()
    {
        $UserCreator = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $competitions = Competition::factory(2)->create();

        $namePool = "liverpool FC";

        $Pool = $this->CreatePoolAction->__invoke(
            $UserCreator,
            $namePool,
            $competitions
        );

        $PoolCreated = Pool::find($Pool->id);

        $this->assertInstanceOf(Pool::class, $PoolCreated);
        $this->assertSame($namePool, $PoolCreated->name);
        $this->assertSame($UserCreator->id, $Pool->users->first()->id);
        $this->assertSame(2, $Pool->competitions->count());
    }

    /**
     * todo: assert para que el usuario guardado tenga rol creador
     * todo: agregar competitions
     *
     * @return void
     */
    public function testCreatePoolWithoutCompetitionsIterable()
    {
        $UserCreator = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $namePool = "liverpool FC";

        $Pool = $this->CreatePoolAction->__invoke(
            $UserCreator,
            $namePool
        );

        $PoolCreated = Pool::find($Pool->id);

        $this->assertInstanceOf(Pool::class, $PoolCreated);
        $this->assertSame($namePool, $PoolCreated->name);
        $this->assertSame($UserCreator->id, $Pool->users->first()->id);
    }

    /**
     * @return void
     */
    public function testThrowExceptionWhenCreatePoolWithVariousCompetitionIncludingSingleCompetition()
    {
        $this->expectException(CompetitionMustBeUniqueInAPool::class);
        
        $CompetitionUnique = Competition::factory()->mustBeUnique()->create();

        $competitions = Competition::factory(2)->create();

        $competitions = $competitions->push($CompetitionUnique);

        $namePool = "liverpool FC";

        $UserCreator = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->CreatePoolAction->__invoke(
            $UserCreator,
            $namePool,
            competitions : $competitions
        );
    }


}