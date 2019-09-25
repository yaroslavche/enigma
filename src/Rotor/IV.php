<?php

namespace Yaroslavche\Enigma\Rotor;

class IV extends AbstractRotor
{
    /**
     * ESOVPZJAYQUIRHXLNFTGKDCMWB
     *
     * @var array $map
     */
    protected $map = [4, 18, 14, 21, 15, 25, 9, 0, 24, 16, 20, 8, 17, 7, 23, 11, 13, 5, 19, 6, 10, 3, 2, 12, 22, 1];

    /**
     * Q -> U (J -> K)
     *
     * @var array<int, int> $turnover
     */
    protected $turnover = [10];
}
