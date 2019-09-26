<?php
declare(strict_types=1);

namespace Yaroslavche\Enigma\Rotor;

/**
 * Class I
 * @package Yaroslavche\Enigma\Rotor
 */
class I extends AbstractRotor
{
    /**
     * EKMFLGDQVZNTOWYHXUSPAIBRCJ
     *
     * @var array $map
     */
    protected $map = [4, 10, 12, 5, 11, 6, 3, 16, 21, 25, 13, 19, 14, 22, 24, 7, 23, 20, 18, 15, 0, 8, 1, 17, 2, 9];

    /**
     * X -> U (Q -> R)
     *
     * @var array<int, int> $turnover
     */
    protected $turnover = [17];
}
