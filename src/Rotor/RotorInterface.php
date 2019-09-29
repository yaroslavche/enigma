<?php
declare(strict_types=1);

namespace Yaroslavche\Enigma\Rotor;

/**
 * Interface RotorInterface
 * @package Yaroslavche\Enigma\Rotor
 */
interface RotorInterface
{
    /**
     * @param int $position
     */
    public function setRingPosition(int $position): void;

    /**
     * @param int $position
     */
    public function setStartPosition(int $position): void;

    /**
     *
     */
    public function rotate(): void;

    /**
     * @return bool
     */
    public function isInTurnoverPosition(): bool;

    /**
     * @param int $position
     * @return int
     */
    public function map(int $position): int;

    /**
     * @param int $position
     * @return int
     */
    public function mapReverse(int $position): int;

    /**
     * @return int
     */
    public function getCurrentPosition(): int;
}
