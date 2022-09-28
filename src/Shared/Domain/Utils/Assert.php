<?php

declare(strict_types=1);

namespace BetPoolCore\Shared\Domain\Utils;

/**
 * Class Assert
 *
 * @package QualityReportsManagement\Shared\Domain
 */
final class Assert
{
    /**
     * @param string $class
     * @param array $items
     * @return void
     */
    public static function arrayOf(string $class, array $items): void
    {
        foreach ($items as $item) {
            self::instanceOf($class, $item);
        }
    }

    /**
     * @param string $class
     * @param $item
     * @return void
     */
    public static function instanceOf(string $class, $item): void
    {
        if (!$item instanceof $class) {
            throw new \InvalidArgumentException(
                sprintf('The object <%s> is not an instance of <%s>', $class, $item::class)
            );
        }
    }
}
