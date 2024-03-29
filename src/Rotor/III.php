<?php
declare(strict_types=1);

namespace Yaroslavche\Enigma\Rotor;

/**
 * Class III
 * @package Yaroslavche\Enigma\Rotor
 */
class III extends AbstractRotor
{
    /**
     * BDFHJLCPRTXVZNYEIWGAKMUSQO
     *
     * @var array $map
     */
    protected $map = [1, 3, 5, 7, 9, 11, 2, 15, 17, 19, 23, 21, 25, 13, 24, 4, 8, 22, 6, 0, 10, 12, 20, 18, 16, 14];

    /**
     * M -> U (V -> W)
     *
     * @var array<int, int> $turnover
     */
    protected $turnover = [22];
}
