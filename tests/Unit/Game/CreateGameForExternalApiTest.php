<?php

namespace Game;

use App\Actions\Game\CreateGamesForExternalApi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutEvents;
use Tests\TestCase;

class CreateGameForExternalApiTest extends TestCase
{
    use RefreshDatabase;
    use WithoutEvents;

    protected function setUp(): void
    {
        parent::setup();

        $this->CreateGameForExternalApi = app(CreateGamesForExternalApi::class);
    }

}
