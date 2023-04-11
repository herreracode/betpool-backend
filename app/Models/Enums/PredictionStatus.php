<?php

namespace App\Models\Enums;

enum PredictionStatus: string
{
    case PENDING = "_PENDING_";

    case CLOSE = "_CLOSE_";
}
