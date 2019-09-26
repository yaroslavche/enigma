<?php
declare(strict_types=1);

namespace Yaroslavche\Enigma\Reflector;

/**
 * Interface ReflectorInterface
 * @package Yaroslavche\Enigma\Reflector
 */
interface ReflectorInterface
{
    /**
     * @param int $index
     * @return int
     */
    public function map(int $index): int;
}
