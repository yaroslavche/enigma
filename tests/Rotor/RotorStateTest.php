<?php
declare(strict_types=1);

namespace Yaroslavche\Enigma\Tests\Rotor;

use PHPUnit\Framework\TestCase;
use Yaroslavche\Enigma\Rotor\RotorState;

/**
 * Class RotorStateTest
 * @package Yaroslavche\Enigma\Tests\Rotor
 */
class RotorStateTest extends TestCase
{
    public function testRotorState()
    {
        $rotorState = new RotorState();
        $this->assertSame(0, $rotorState->getRingIndex());
        $this->assertSame(0, $rotorState->getStartIndex());
        $this->assertSame(0, $rotorState->getCurrentIndex());
        $this->assertFalse($rotorState->isRotated());
        $this->assertFalse($rotorState->isTurnover());
        $rotorState->setRingIndex(1);
        $rotorState->setStartIndex(1);
        $rotorState->setCurrentIndex(1);
        $rotorState->setRotated(true);
        $rotorState->setTurnover(true);
        $this->assertSame(1, $rotorState->getRingIndex());
        $this->assertSame(1, $rotorState->getStartIndex());
        $this->assertSame(1, $rotorState->getCurrentIndex());
        $this->assertTrue($rotorState->isRotated());
        $this->assertTrue($rotorState->isTurnover());
    }
}
