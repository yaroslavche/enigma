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
    private $rotated = false;
    /** @var bool $turnover */
    private $turnover = false;
    /** @var int $ringIndex */
    private $ringIndex = 0;
    /** @var int $startIndex */
    private $startIndex = 0;
    /** @var int $currentIndex */
    private $currentIndex = 0;

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

    /**
     * @return bool
     */
    public function isTurnover(): bool
    {
        return $this->turnover;
    }

    /**
     * @param bool $turnover
     */
    public function setTurnover(bool $turnover): void
    {
        $this->turnover = $turnover;
    }

    /**
     * @return int
     */
    public function getRingIndex(): int
    {
        return $this->ringIndex;
    }

    /**
     * @param int $ringIndex
     */
    public function setRingIndex(int $ringIndex): void
    {
        $this->ringIndex = $ringIndex;
    }

    /**
     * @return int
     */
    public function getStartIndex(): int
    {
        return $this->startIndex;
    }

    /**
     * @param int $startIndex
     */
    public function setStartIndex(int $startIndex): void
    {
        $this->startIndex = $startIndex;
    }

    /**
     * @return int
     */
    public function getCurrentIndex(): int
    {
        return $this->currentIndex;
    }

    /**
     * @param int $currentIndex
     */
    public function setCurrentIndex(int $currentIndex): void
    {
        $this->currentIndex = $currentIndex;
    }
}
