<?php

declare(strict_types=1);

namespace BetPoolCore\Shared\Domain\Utils;

/**
 * Class Collection
 *
 * @package QualityReportsManagement\Shared\Domain
 */
abstract class Collection
{
    /**
     * @param array $items
     */
    public function __construct(private array $items)
    {
        Assert::arrayOf($this->type(), $items);
    }

    /**
     * @return string
     */
    abstract protected function type(): string;

    /**
     * @return \ArrayIterator
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->items());
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->items());
    }

    /**
     * @return array
     */
    protected function items(): array
    {
        return $this->items;
    }
}
