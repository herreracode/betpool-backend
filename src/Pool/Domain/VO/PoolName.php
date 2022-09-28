<?php

declare(strict_types=1);

namespace BetPoolCore\Pool\Domain\VO;

use BetPoolCore\Shared\Domain\Contracts\ValueObject;

Class PoolName implements ValueObject
{

    public function __construct(
        public string $name
    )
    {
    }

    public function get(): string
    {
        return $this->name;
    }
    
}
