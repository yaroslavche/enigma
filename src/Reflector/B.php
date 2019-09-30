<?php
declare(strict_types=1);

namespace Yaroslavche\Enigma\Reflector;

/**
 * Class B
 * @package Yaroslavche\Enigma\Reflector
 */
class B implements ReflectorInterface
{
    /** @var array<int, int> $map */
    protected $map = [24, 17, 20, 7, 16, 18, 11, 3, 15, 23, 13, 6, 14, 10, 12, 8, 4, 1, 5, 25, 2, 22, 21, 9, 0, 19];

    /**
     * @inheritDoc
     */
    public function wire(int $index): int
    {
        return $this->map[$index] ?? $index;
    }
}
