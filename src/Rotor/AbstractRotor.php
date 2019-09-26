<?php

namespace Yaroslavche\Enigma\Rotor;

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

    public function setRingPosition(int $position): void
    {
        $this->ringPosition = $position;
    }

    public function setStartPosition(int $position): void
    {
        $this->currentPosition = $position;
    }

    public function rotate(): void
    {
        $this->currentPosition = ($this->currentPosition + 1) % count($this->map);
    }

    public function isInTurnoverPosition(): bool
    {
        return in_array($this->currentPosition, $this->turnover, true);
    }

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

    public function getCurrentPosition(): int
    {
        return $this->currentPosition;
    }
}
