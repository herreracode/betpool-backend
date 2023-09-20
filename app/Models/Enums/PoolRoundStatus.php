<?php

namespace App\Models\Enums;

enum PoolRoundStatus: string
{
    case PENDING = "_PENDING_";

    case FINISH = "_FINISH_";
}
