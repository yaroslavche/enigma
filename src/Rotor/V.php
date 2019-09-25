<?php

namespace Yaroslavche\Enigma\Rotor;

class V extends AbstractRotor
{
    /**
     * VZBRGITYUPSDNHLXAWMJQOFECK
     *
     * @var array $map
     */
    protected $map = [21, 25, 1, 17, 6, 8, 19, 24, 20, 15, 18, 3, 13, 7, 11, 23, 0, 22, 12, 9, 16, 14, 5, 4, 2, 10];

    /**
     * K -> V (Z -> A)
     *
     * @var array<int, int> $turnover
     */
    protected $turnover = [25];
}
