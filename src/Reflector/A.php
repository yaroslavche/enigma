<?php
declare(strict_types=1);

namespace Yaroslavche\Enigma\Reflector;

/**
 * Class A
 * @package Yaroslavche\Enigma\Reflector
 */
class A implements ReflectorInterface
{
    /** @var array<int, int> $map */
    protected $map = [];

    /**
     * @inheritDoc
     */
    public function map(int $index): int
    {
        return $this->map[$index] ?? $index;
    }
}
