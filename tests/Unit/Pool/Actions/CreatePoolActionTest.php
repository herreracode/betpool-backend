<?php

namespace Tests\Unit\Game\Actions;

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

        //$this->CreatePoolAction = app(CreateGame::class);
    }

    public function testCreatePool()
    {
        
    }

}