<?php
declare(strict_types=1);

namespace Yaroslavche\Enigma\Rotor;

use Exception;
use Yaroslavche\Enigma\Enigma;

/**
 * Class AbstractRotor
 * @package Yaroslavche\Enigma\Rotor
 */
class AbstractRotor implements RotorInterface
{
    /** @var Enigma $enigma */
    private $enigma;
    /** @var int|null $slot */
    private $slot;
    /** @var array<int, int> $map */
    protected $map = [];
    /** @var int $mapLength */
    protected $mapLength = 0;
    /** @var array<int, int> $turnover */
    protected $turnover = [];
    /** @var RotorState $state */
    private $state;

    /**
     * AbstractRotor constructor.
     * @param array<int, int>|null $map
     * @throws Exception
     */
    public function __construct(?array $map = null)
    {
        if (is_array($map)) {
            $this->map = $map;
        }
        $this->mapLength = count($this->map);
        $this->state = new RotorState();
        if ($this->mapLength === 0) {
            throw new Exception('Map can\'t be empty');
        }
    }

    /**
     * @param Enigma $enigma
     * @param int $slot
     * @param int|null $ringIndex
     * @param int|null $startIndex
     */
    public function set(Enigma $enigma, int $slot, ?int $ringIndex = null, ?int $startIndex = null): void
    {
        $this->enigma = $enigma;
        $this->slot = $slot;
        $this->state->setRingIndex($ringIndex ?? 00);
        $this->state->setStartIndex($startIndex ?? 0);
    }

    /**
     * @return RotorState
     */
    public function getState(): RotorState
    {
        return $this->state;
    }

    /**
     * @inheritDoc
     */
    public function rotate(): void
    {
        $this->state->setRotated(true);
        $this->state->setTurnover(in_array($this->state->getCurrentIndex(), $this->turnover, true));
        $index = ($this->state->getCurrentIndex() + 1) % $this->mapLength;
        $this->state->setCurrentIndex($index);
    }

    /**
     * @return bool
     */
    public function isRotated(): bool
    {
        return $this->state->isRotated();
    }

    /**
     * @inheritDoc
     */
    public function isTurnover(): bool
    {
        return $this->state->isTurnover();
    }

    /**
     * @inheritDoc
     */
    public function wire(int $inputIndex): int
    {
        $inputIndex += $this->state->getCurrentIndex() + $this->state->getStartIndex();
        $inputIndex %= $this->mapLength;
        $outputIndex = $this->map[$inputIndex] - $this->state->getCurrentIndex() - $this->state->getStartIndex();
        if ($outputIndex < 0) {
            $outputIndex = $this->mapLength + $outputIndex;
        }
        $outputIndex %= $this->mapLength;
        return $outputIndex;
    }

    /**
     * @inheritDoc
     */
    public function wireReverse(int $inputIndex): int
    {
        $inputIndex += $this->state->getCurrentIndex() + $this->state->getStartIndex();
        $inputIndex %= $this->mapLength;
        $outputIndex = array_search($inputIndex, $this->map, true);
        if ($outputIndex === false) {
            throw new Exception('Invalid input index.');
        }
        $outputIndex = $outputIndex - $this->state->getCurrentIndex() + ($this->state->isRotated() ? 1 : 0);
        if ($this->slot === 0) {
            $outputIndex -= $this->state->getStartIndex() + 1;
        }
        if ($outputIndex < 0) {
            $outputIndex = $this->mapLength + $outputIndex;
        }
        $outputIndex %= $this->mapLength;

        return $outputIndex;
    }
}
