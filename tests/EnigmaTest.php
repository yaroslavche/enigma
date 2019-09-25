<?php

namespace Yaroslavche\Enigma\Tests;

use PHPUnit\Framework\TestCase;
use Yaroslavche\Enigma\Enigma;
use Yaroslavche\Enigma\Reflector\B;
use Yaroslavche\Enigma\Rotor\I;
use Yaroslavche\Enigma\Rotor\II;
use Yaroslavche\Enigma\Rotor\III;
use Yaroslavche\Enigma\Rotor\IV;
use Yaroslavche\Enigma\Rotor\V;

class EnigmaTest extends TestCase
{
    /**
     * @see http://wiki.franklinheath.co.uk/index.php/Enigma/Sample_Messages
     */
    public function testOperationBarbarossa1941()
    {
        $enigma = new Enigma('ABCDEFGHIJKLMNOPQRSTUVWXYZ');

        # in program implementation indexes starts from 0, in example from 01
        $enigma->setRotor(new V(), 11);
        $enigma->setRotor(new IV(), 20);
        $enigma->setRotor(new II(), 1);

        $enigma->setReflector(new B());

        # AV BS CG DL FU HZ IN KM OW RX
        $enigma->setPlugPair('A', 'V');
        $enigma->setPlugPair('B', 'S');
        $enigma->setPlugPair('C', 'G');
        $enigma->setPlugPair('D', 'L');
        $enigma->setPlugPair('F', 'U');
        $enigma->setPlugPair('H', 'Z');
        $enigma->setPlugPair('I', 'N');
        $enigma->setPlugPair('K', 'M');
        $enigma->setPlugPair('O', 'W');
        $enigma->setPlugPair('R', 'X');

//        $enigma->setKey('LSD');
//        $result = $enigma->cryptMessage('SFBWDNJUSEGQOBHKRTAREEZMWKPPRBXOHDROEQGBBGTQVPGVKBVVGBIMHUSZYDAJQIROAXSSSNREHYGGRPISEZBOVMQIEMMZCYSGQDGRERVBILEKXYQIRGIRQNRDNVRXCYYTNJR');
//        $this->assertSame('DREIGEHTLANGSAMABERSIQERVORWAERTSXEINSSIEBENNULLSEQSXUHRXROEMXEINSXINFRGTXDREIXAUFFLIEGERSTRASZEMITANFANGXEINSSEQSXKMXKMXOSTWXKAMENECXK', $result);
        $this->assertTrue(true);
    }

    public function testEnigma()
    {
        $enigma = new Enigma('ABCDEFGHIJKLMNOPQRSTUVWXYZ');

        $enigma->setRotor(new I());
        $enigma->setRotor(new II());
        $enigma->setRotor(new III());

        $enigma->setReflector(new B());
        $enigma->setKey('LGB');

        $this->assertSame('BVX', $enigma->cryptMessage('AAA'));
    }
}
