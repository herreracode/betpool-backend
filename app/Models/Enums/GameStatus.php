<?php

namespace App\Models\Enums;

enum GameStatus: string
{
    case PENDING = "_PENDING_";

    case IN_PROGRESS = "_IN_PROGRESS_";

    case FINISH = "_FINISH_";

    case POSTPONED = "_POSTPONED_";
}
