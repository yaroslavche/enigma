<?php
declare(strict_types=1);

namespace Yaroslavche\Enigma\Tests\Rotor;

use PHPUnit\Framework\TestCase;
use Yaroslavche\Enigma\Rotor\AbstractRotor;
use Yaroslavche\Enigma\Rotor\RotorInterface;

/**
 * Class AbstractRotorTest
 * @package Yaroslavche\Enigma\Tests\Rotor
 */
class AbstractRotorTest extends TestCase
{
    public function testAbstractRotor()
    {
        $abstractRotor = new AbstractRotor([1, 2, 3]);
        $this->assertInstanceOf(RotorInterface::class, $abstractRotor);
    }

    public function testRotorMap()
    {
        $this->expectExceptionMessage('Map can\'t be empty');
        new AbstractRotor([]);
    }

    public function testRotorRotated()
    {
        $rotor = new AbstractRotor([1]);
        $this->assertFalse($rotor->isRotated());
        $rotor->rotate();
        $this->assertTrue($rotor->isRotated());
        $this->expectExceptionMessage('Invalid input index.');
        $rotor->wireReverse(-26);
    }

    public function testRotorWireReverseInvalidIndex()
    {
        $rotor = new AbstractRotor([1]);
        $this->expectExceptionMessage('Invalid input index.');
        $rotor->wireReverse(-26);
    }
}
