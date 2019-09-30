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
    /** @var int $ringIndex */
    private $ringIndex = 0;
    /** @var int $currentPosition */
    private $currentIndex = 0;

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
        if (empty($this->map)) {
            throw new Exception('Map can\'t be empty');
        }
        $this->mapLength = count($this->map);
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
        $this->setRingIndex($ringIndex);
        $this->setStartIndex($startIndex ?? 0);
    }

    /**
     * @param int $index
     */
    public function setRingIndex(int $index): void
    {
        # "remove" existing ring index and add the new one
        $this->currentIndex = $this->currentIndex - $this->ringIndex + $index;
        $this->ringIndex = $index;
    }

    /**
     * @param int $index
     */
    public function setStartIndex(int $index): void
    {
        $this->currentIndex = $index + $this->ringIndex;
    }

    /**
     * @inheritDoc
     */
    public function rotate(): void
    {
        $this->currentIndex = ($this->currentIndex + 1) % $this->mapLength;
    }

    /**
     * @return bool
     */
    public function isRotated(): bool
    {
        /** @var RotorState $rotorState */
        $rotorState = $this->enigma->getRotorState($this->slot);
        return $rotorState->isRotated();
    }

    /**
     * @inheritDoc
     */
    public function isInTurnoverPosition(): bool
    {
        return in_array($this->currentIndex, $this->turnover, true);
    }

    /**
     * @inheritDoc
     */
    public function wire(int $inputIndex): int
    {
        $inputIndexTmp = $inputIndex;
        $inputIndex += $this->currentIndex - $this->ringIndex;
        /** @var RotorState $rotorState */
        $rotorState = $this->enigma->getRotorState($this->slot);
        $rotated = $rotorState->isRotated();
        if ($this->slot > 0) {
            /** @var RotorState $previousRotorState */
            $previousRotorState = $this->enigma->getRotorState($this->slot - 1);
            if ($previousRotorState->isRotated()) {
//                $inputIndex--;
            }
        }
        if ($inputIndex < 0) {
            $inputIndex = $this->mapLength - $inputIndex;
        }
        $inputIndex %= $this->mapLength;
        $outputIndex = $this->map[$inputIndex] - $this->currentIndex;
        if ($outputIndex < 0) {
            $outputIndex = $this->mapLength - $outputIndex;
        }
        $outputIndex %= $this->mapLength;
//        $dbg = PHP_EOL .
//            sprintf(
//                'ROTOR %s%s (current %s) %s -> %s (%d) -> %s (%d)',
//                static::class,
//                $rotated ? '+' : '-',
//                $this->currentIndex,
//                chr($inputIndexTmp + 65),
//                chr($inputIndex + 65),
//                $inputIndex,
//                chr($outputIndex + 65),
//                $outputIndex
//            );
//        echo $dbg;
        return $outputIndex;
    }

    /**
     * @inheritDoc
     */
    public function wireReverse(int $inputIndex): int
    {
        $tmp = $inputIndex;
        $inputIndex += $this->currentIndex;
        $inputIndex %= $this->mapLength;
        $outputIndex = array_search($inputIndex, $this->map);
        /** @var RotorState $previousRotorState */
        $rotorState = $this->enigma->getRotorState($this->slot);
        if ($outputIndex < 0) {
            $outputIndex = $this->mapLength - $outputIndex;
        }
        $outputIndex %= $this->mapLength;
        if ($rotorState->isRotated()) {
            $outputIndex -= $this->currentIndex;
        }
//        $dbg = PHP_EOL .
//            sprintf(
//                'ROTOR %s%s (current %s) %s (%d) -> %s (%d)',
//                static::class,
//                $rotorState->isRotated() ? '+' : '-',
//                $this->currentIndex,
//                chr($inputIndex + 65),
//                $inputIndex,
//                chr($outputIndex + 65),
//                $outputIndex
//            );
//        echo $dbg;
        return $outputIndex;
    }
}
