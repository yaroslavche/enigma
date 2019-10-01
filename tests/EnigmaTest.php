<?php

namespace Yaroslavche\Enigma\Tests;

use PHPUnit\Framework\TestCase;
use Yaroslavche\Enigma\Enigma;
use Yaroslavche\Enigma\Reflector\A;
use Yaroslavche\Enigma\Reflector\B;
use Yaroslavche\Enigma\Reflector\ReflectorInterface;
use Yaroslavche\Enigma\Rotor\I;
use Yaroslavche\Enigma\Rotor\II;
use Yaroslavche\Enigma\Rotor\III;
use Yaroslavche\Enigma\Rotor\IV;
use Yaroslavche\Enigma\Rotor\RotorInterface;
use Yaroslavche\Enigma\Rotor\V;

class EnigmaTest extends TestCase
{
    /**
     * @dataProvider configDataProvider
     * @param array $rotors
     * @param array $rings
     * @param ReflectorInterface $reflector
     * @param array $plugboard
     * @param array $start
     * @param string $encoded
     * @param string $decoded
     * @throws \Exception
     */
    public function testEnigma(
        array $rotors,
        array $rings,
        ReflectorInterface $reflector,
        array $plugboard,
        array $start,
        string $encoded,
        string $decoded
    )
    {
        $enigma = new Enigma('ABCDEFGHIJKLMNOPQRSTUVWXYZ');

        /** @var RotorInterface $rotor */
        foreach (array_reverse($rotors) as $index => $rotor) {
            $ringIndex = array_reverse($rings)[$index];
            $enigma->setRotor($rotor, $index, $ringIndex);
        }

        $enigma->setReflector($reflector);

        foreach ($plugboard as $pair) {
            $enigma->setPlugPair($pair{0}, $pair{1});
        }

        $key = implode('', $start);
        $enigma->setKey($key);
        $this->assertSame($decoded, $enigma->cryptMessage($encoded));

        $enigma->setKey($key);
        $this->assertSame($encoded, $enigma->cryptMessage($decoded));
    }

    public function configDataProvider()
    {
        $I = new I();
        $II = new II();
        $III = new III();
        $IV = new IV();
        $V = new V();

        $A = new A();
        $B = new B();

        yield [
            'rotors' => [$I, $II, $III],
            'rings' => [0, 0, 0],
            'reflector' => $B,
            'plugboard' => [],
            'start' => ['A', 'A', 'A'],
//            'encoded' => 'SAGE',
//            'decoded' => 'FLYN',
            'encoded' => 'TESTMESSAGE',
            'decoded' => 'OLPFHNVFLYN',
        ];
//
//        # maybe wrong
//        yield [
//            'rotors' => [$I, $II, $III],
//            'rings' => [0, 0, 0],
//            'reflector' => $A,
//            'plugboard' => [],
//            'start' => ['A', 'B', 'C'],
//            'encoded' => 'TESTMESSAGE',
//            'decoded' => 'TESTMESSAGE',
//        ];

//        yield [
//            'rotors' => [$I, $II, $III],
//            'rings' => [0, 2, 2],
//            'reflector' => $B,
//            'plugboard' => [],
//            'start' => ['A', 'A', 'A'],
//            'encoded' => 'TEST',
//            'decoded' => 'IINL',
//        ];

        /**
         * @see http://wiki.franklinheath.co.uk/index.php/Enigma/Sample_Messages
         */
//        yield [
//            'rotors' => [$II, $I, $III],
//            'rings' => [23, 12, 21],
//            'reflector' => $A,
//            'plugboard' => ['AM', 'FI', 'NV', 'PS', 'TU', 'WZ'],
//            'start' => ['A', 'B', 'L'],
//            'encoded' => 'FEINDLIQEINFANTERIEKOLONNEBEOBAQTETXANFANGSUEDAUSGANGBAERWALDEXENDEDREIKMOSTWAERTSNEUSTADT',
//            'decoded' => 'GCDSEAHUGWTQGRKVLFGXUCALXVYMIGMMNMFDXTGNVHVRMMEVOUYFZSLRHDRRXFJWCFHUHMUNZEFRDISIKBGPMYVXUZ',
//        ];

//        yield [
//            'rotors' => [$II, $IV, $V],
//            'rings' => [1, 20, 11],
//            'reflector' => $B,
//            'plugboard' => ['AV', 'BS', 'CG', 'DL', 'FU', 'HZ', 'IN', 'KM', 'OW', 'RX'],
//            'start' => ['B', 'L', 'A'],
//            'encoded' => 'DREIGEHTLANGSAMABERSIQERVORWAERTSXEINSSIEBENNULLSEQSXUHRXROEMXEINSXINFRGTXDREIXAUFFLIEGERSTRASZEMITANFANGXEINSSEQSXKMXKMXOSTWXKAMENECXK',
//            'decoded' => 'SFBWDNJUSEGQOBHKRTAREEZMWKPPRBXOHDROEQGBBGTQVPGVKBVVGBIMHUSZYDAJQIROAXSSSNREHYGGRPISEZBOVMQIEMMZCYSGQDGRERVBILEKXYQIRGIRQNRDNVRXCYYTNJR',
//        ];
    }

    public function testInvalidTranslate()
    {
        $this->expectExceptionMessage('Translate must contains same char count');
        new Enigma('ABC', '1234');
    }

    public function testGetCharIndexInvalidChar()
    {
        $enigma = new Enigma('ABC');
        $this->expectExceptionMessage('"AB" is not valid char.');
        $enigma->getCharIndex('AB');
    }

    public function testGetCharIndexNotFoundChar()
    {
        $enigma = new Enigma('ABC');
        $this->expectExceptionMessage('Unknown char " " for alphabet.');
        $enigma->getCharIndex(' ');
    }

    public function testSetPlugPairFirst()
    {
        $enigma = new Enigma('ABC');
        $enigma->setPlugPair('A', 'B');
        $this->expectExceptionMessage('Plugboard component "A" already in use.');
        $enigma->setPlugPair('A', 'C');
    }

    public function testSetPlugPairSecond()
    {
        $enigma = new Enigma('ABC');
        $enigma->setPlugPair('A', 'B');
        $this->expectExceptionMessage('Plugboard component "B" already in use.');
        $enigma->setPlugPair('C', 'B');
    }
}
