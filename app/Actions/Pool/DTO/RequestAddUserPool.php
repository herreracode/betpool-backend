<?php

namespace App\Actions\Pool\DTO;

readonly class RequestAddUserPool
{
    public function __construct(
        public string $poolId,
        public array $guestsEmails,
    ) {
    }
}
