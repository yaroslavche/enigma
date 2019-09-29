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
    /** @var int $ringPosition */
    private $ringPosition = 0;
    /** @var int $currentPosition */
    private $currentPosition = 0;
    /** @var int $rotations */
    private $rotations = 0;

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
        $this->rotations++;
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
    public function map(int $position): int
    {
        $map = $this->map;
        $mapPosition = ($position + $this->currentPosition) % $this->mapLength;
        $rotated = $position !== $mapPosition;
        if (!$rotated) {
            $mapPosition -= $this->ringPosition;
        }
        if ($mapPosition < 0) {
            $mapPosition = ($this->mapLength - $mapPosition) % $this->mapLength;
        }
        $index = $map[$mapPosition] - $this->ringPosition - (!$rotated ? $this->ringPosition : 0);
        if ($index < 0) {
            $index = $this->mapLength - $index;
        }
        $index %= $this->mapLength;
//        $dbg = PHP_EOL .
//            sprintf(
//                'ROTOR %s%s %s -> %s -> %s',
//                static::class,
//                $rotated ? ' (rotated)' : '',
//                chr($position + 65),
//                chr($mapPosition + 65),
//                chr($index + 65)
//            );
//        echo $dbg;
        return $index;
    }

    /**
     * @inheritDoc
     */
    public function mapReverse(int $position): int
    {
        $map = array_flip($this->map);
        $mapPosition = ($position + $this->currentPosition) % $this->mapLength;
        $rotated = $position !== $mapPosition;
        $index = $map[$mapPosition];
        if ($index < 0) {
            $index = $this->mapLength - $index;
        }
        $index %= $this->mapLength;
//        $dbg = PHP_EOL .
//            sprintf(
//                'REVERSE ROTOR %s%s %s -> %s -> %s (p %s c %s r %s m %s)',
//                static::class,
//                $rotated ? ' (rotated)' : '',
//                chr($position + 65),
//                chr($mapPosition + 65),
//                chr($index + 65),
//                $position,
//                $this->currentPosition,
//                $this->ringPosition,
//                $mapPosition
//            );
//        echo $dbg;
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
