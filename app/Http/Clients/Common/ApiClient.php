<?php

namespace App\Http\Clients\Common;

use App\Models\Competition;

interface ApiClient
{
    public function get(Competition $Competition, $date): array;
}
