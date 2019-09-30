<?php
declare(strict_types=1);

namespace Yaroslavche\Enigma\Rotor;

/**
 * Class RotorState
 * @package Yaroslavche\Enigma\Rotor
 */
class RotorState
{
    /** @var bool $rotated */
    private $rotated;

    /**
     * @return bool
     */
    public function isRotated(): bool
    {
        return $this->rotated;
    }

    /**
     * @param bool $rotated
     */
    public function setRotated(bool $rotated): void
    {
        $this->rotated = $rotated;
    }
}
