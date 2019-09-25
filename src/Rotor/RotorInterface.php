<?php

namespace Yaroslavche\Enigma\Rotor;

interface RotorInterface
{
    public function setRingPosition(int $position): void;
    public function setStartPosition(int $position): void;
    public function rotate(): void;
    public function isInTurnoverPosition(): bool;
    public function map(int $position, bool $reverse = false): int;
    public function getCurrentPosition(): int;
}
