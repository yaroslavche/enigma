<?php
declare(strict_types=1);

namespace Yaroslavche\Enigma\Rotor;

/**
 * Class AbstractRotor
 * @package Yaroslavche\Enigma\Rotor
 */
class AbstractRotor implements RotorInterface
{
    /** @var array<int, int> $map */
    protected $map = [];
    /** @var array<int, int> $turnover */
    protected $turnover = [];
    /** @var int $ringPosition */
    private $ringPosition = 0;
    /** @var int $currentPosition */
    private $currentPosition = 0;

    /**
     * @inheritDoc
     */
    public function setRingPosition(int $position): void
    {
        $this->ringPosition = $position;
    }

    /**
     * @inheritDoc
     */
    public function setStartPosition(int $position): void
    {
        $this->currentPosition = $position;
    }

    /**
     * @inheritDoc
     */
    public function rotate(): void
    {
        $this->currentPosition = ($this->currentPosition + 1) % count($this->map);
    }

    /**
     * @inheritDoc
     */
    public function isInTurnoverPosition(): bool
    {
        return in_array($this->currentPosition, $this->turnover, true);
    }

    /**
     * @inheritDoc
     */
    public function map(int $position, bool $reverse = false): int
    {
        $map = $reverse ? array_flip($this->map) : $this->map;
        $itemsCount = count($map);
        $mapPosition = ($position + $this->currentPosition) % $itemsCount;
        $offset = $mapPosition - $position;
        $index = $map[$mapPosition] - $offset;
        if ($offset !== 0) {
            $index = $itemsCount + $index;
            $index %= $itemsCount;
        }
        return $index;
    }


    /**
     * @inheritDoc
     */
    public function getCurrentPosition(): int
    {
        return $this->currentPosition;
    }
}
