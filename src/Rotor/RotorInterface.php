<?php
declare(strict_types=1);

namespace Yaroslavche\Enigma\Rotor;

use Yaroslavche\Enigma\Enigma;

/**
 * Interface RotorInterface
 * @package Yaroslavche\Enigma\Rotor
 */
interface RotorInterface
{
    /**
     * @param Enigma $enigma
     * @param int $slot
     * @param int|null $ringIndex
     * @param int|null $startIndex
     */
    public function set(Enigma $enigma, int $slot, ?int $ringIndex = null, ?int $startIndex = null): void;

    /** */
    public function rotate(): void;

    /**
     * @return bool
     */
    public function isRotated(): bool;

    /**
     * @return bool
     */
    public function isTurnover(): bool;

    /**
     * @param int $inputIndex
     * @return int
     */
    public function wire(int $inputIndex): int;

    /**
     * @param int $inputIndex
     * @return int
     */
    public function wireReverse(int $inputIndex): int;

    /**
     * @return RotorState
     */
    public function getState(): RotorState;
}
