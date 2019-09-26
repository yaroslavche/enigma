<?php

namespace Yaroslavche\Enigma\Reflector;

class A implements ReflectorInterface
{
    /** @var array<int, int> $map */
    protected $map = [];

    public function map(int $index): int
    {
        return $this->map[$index] ?? $index;
    }
}
