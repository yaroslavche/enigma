<?php
declare(strict_types=1);

namespace Yaroslavche\Enigma\Rotor;

use Exception;

/**
 * Class AbstractRotor
 * @package Yaroslavche\Enigma\Rotor
 */
class AbstractRotor implements RotorInterface
{
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
     * @inheritDoc
     */
    public function setRingPosition(int $position): void
    {
        # "remove" existing ring offset and add the new one
        $this->currentIndex = $this->currentIndex - $this->ringIndex + $position;
        $this->ringPosition = $position;
    }

    /**
     * @inheritDoc
     */
    public function setStartPosition(int $position): void
    {
        $this->currentIndex = $position + $this->ringIndex;
    }

    /**
     * @inheritDoc
     */
    public function rotate(): void
    {
        $this->currentIndex = ($this->currentIndex + 1) % count($this->map);
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
    public function map(int $inputIndex): int
    {
        $inputIndexTmp = $inputIndex;
        $inputIndex += $this->currentIndex;
        $inputIndex %= $this->mapLength;
        $outputIndex = $this->map[$inputIndex] - $this->currentIndex + $this->ringIndex;
        if ($outputIndex < 0) {
            $outputIndex = $this->mapLength - $outputIndex;
        }
        $outputIndex %= $this->mapLength;
//        $dbg = PHP_EOL .
//            sprintf(
//                'ROTOR %s (current %s) %s -> %s (%d) -> %s',
//                static::class,
//                $this->currentIndex,
//                chr($inputIndexTmp + 65),
//                chr($inputIndex + 65),
//                $inputIndex,
//                chr($outputIndex + 65)
//            );
//        echo $dbg;
        return $outputIndex;
    }

    /**
     * @inheritDoc
     */
    public function mapReverse(int $inputIndex): int
    {
        $inputIndex += $this->currentIndex;
        $inputIndex %= $this->mapLength;
        $outputIndex = array_search($inputIndex, $this->map) - $this->currentIndex - $this->ringIndex;
        if ($outputIndex < 0) {
            $outputIndex = $this->mapLength - $outputIndex;
        }
        $outputIndex %= $this->mapLength;
//        $dbg = PHP_EOL .
//            sprintf(
//                'REVERSE ROTOR %s%s (current %s) %s (%d) -> %s %s',
//                static::class,
//                $rotated ? ' (rotated)' : '',
//                $this->currentIndex,
//                chr($inputIndex + 65),
//                $inputIndex,
//                chr($outputIndex + 65),
//                sprintf('%d %d', $inputIndex, $inputIndex - $this->currentIndex)
//            );
//        echo $dbg;
        return $outputIndex;
    }

    /**
     * @todo rename to getCurrentIndex
     * @inheritDoc
     */
    public function getCurrentPosition(): int
    {
        return $this->currentIndex;
    }
}
