<?php
declare(strict_types=1);

namespace Yaroslavche\Enigma\Rotor;

/**
 * Class II
 * @package Yaroslavche\Enigma\Rotor
 */
class II extends AbstractRotor
{
    /**
     * AJDKSIRUXBLHWTMCQGZNPYFVOE
     *
     * @var array $map
     */
    protected $map = [0, 9, 3, 10, 18, 8, 17, 20, 23, 1, 11, 7, 22, 19, 12, 2, 16, 6, 25, 13, 15, 24, 5, 21, 14, 4];

    /**
     * S -> I (E -> F)
     *
     * @var array<int, int> $turnover
     */
    protected $turnover = [5];
}
