<?php
declare(strict_types=1);

namespace Yaroslavche\Enigma;

use Exception;
use Yaroslavche\Enigma\Reflector\ReflectorInterface;
use Yaroslavche\Enigma\Rotor\RotorInterface;
use Yaroslavche\Enigma\Rotor\RotorState;

/**
 * Class Enigma
 * @package Yaroslavche\Enigma
 */
class Enigma
{
    /** @var string $alphabet */
    private $alphabet;
    /** @var string $translate */
    private $translate;
    /** @var array<int, RotorInterface> $rotors */
    private $rotors = [];
    /** @var ReflectorInterface $reflector */
    private $reflector;
    /** @var array<int, int> $plugboard */
    private $plugboard = [];
    /** @var array<int, array<string, string|bool|int>> $state maybe need class */
    private $state = [];

    /**
     * Enigma constructor.
     * @param string $alphabet
     * @param string|null $translate
     * @throws Exception
     */
    public function __construct(string $alphabet, ?string $translate = null)
    {
        $this->alphabet = $alphabet;
        $this->translate = $translate ?? $alphabet;
        if (mb_strlen($this->translate) !== mb_strlen($this->alphabet)) {
            throw new Exception('Translate must contains same char count');
        }
    }

    /**
     * @param RotorInterface $rotor
     * @param int|null $slot RTL, REFLECTOR [B] <-> ROTORS [II (2), IV (1), V (0)] <-> INPUT
     * @param int|null $ringIndex
     * @param int|null $startIndex
     * @throws Exception
     */
    public function setRotor(RotorInterface $rotor, ?int $slot = null, ?int $ringIndex = null, ?int $startIndex = null): void
    {
        $slot = $slot ?? count($this->rotors ?? []);
        if ($slot < 0 || $slot > mb_strlen($this->alphabet)) {
            throw new Exception(sprintf('Invalid rotor position %d', $slot));
        }
        $rotor->set($this, $slot, $ringIndex, $startIndex);
        $this->rotors[$slot] = $rotor;
        $this->state['rotor'][$slot] = new RotorState();
        ksort($this->rotors);
    }

    /**
     * @param ReflectorInterface $reflector
     */
    public function setReflector(ReflectorInterface $reflector): void
    {
        $this->reflector = $reflector;
    }

    /**
     * @param string $char
     * @return string
     * @throws Exception
     */
    public function cryptChar(string $char): string
    {
        $this->rotate();
        $charIndex = $this->getCharIndex($char);
        $charIndex = $this->wire($charIndex);
        return $this->translate{$charIndex};
    }


    /**
     * @param string $message
     * @return string
     * @throws Exception
     */
    public function cryptMessage(string $message): string
    {
        $cipher = '';
        $chars = mb_str_split($message);
        foreach ($chars as $char) {
            $cipher .= $this->cryptChar($char);
        }
        return $cipher;
    }

    private function rotate(): void
    {
        $rotate = true;
        /** @var RotorInterface $rotor */
        foreach ($this->rotors as $slot => $rotor) {
            if ($rotate) {
                $rotor->rotate();
            }
            /** @var RotorState $rotorState */
            $rotorState = $this->state['rotor'][$slot];
            $rotorState->setRotated($rotate);
            $rotate = $rotate && $rotor->isInTurnoverPosition();
        }
    }

    /**
     * @param int $charIndex
     * @return int
     */
    private function wire(int $charIndex): int
    {
        # plugboard
        $charIndex = $this->plugboard[$charIndex] ?? $charIndex;

        # rotors
        /** @var RotorInterface $rotor */
        foreach ($this->rotors as $rotor) {
            $charIndex = $rotor->wire($charIndex);
        }

        # reflector
        if (null !== $this->reflector) {
            $charIndex = $this->reflector->wire($charIndex);
        }

        # rotors backward
        foreach (array_reverse($this->rotors) as $rotor) {
            $charIndex = $rotor->wireReverse($charIndex);
        }

        # plugboard
        $charIndex = $this->plugboard[$charIndex] ?? $charIndex;

        return $charIndex;
    }

    /**
     * @param string $char
     * @return int
     * @throws Exception
     */
    public function getCharIndex(string $char): int
    {
        if (mb_strlen($char) !== 1) {
            throw new Exception(sprintf('"%s" is not valid char.', $char));
        }
        $charIndex = mb_strpos($this->alphabet, $char);
        if ($charIndex === false) {
            throw new Exception(sprintf('Unknown char "%s" for alphabet.', $char));
        }
        return $charIndex;
    }

    /**
     * @param string $firstComponent
     * @param string $secondComponent
     * @throws Exception
     */
    public function setPlugPair(string $firstComponent, string $secondComponent): void
    {
        $firstCharIndex = $this->getCharIndex($firstComponent);
        if (array_key_exists($firstCharIndex, $this->plugboard)) {
            throw new Exception(sprintf('Plugboard component "%s" already in use.', $firstComponent));
        }
        $secondCharIndex = $this->getCharIndex($secondComponent);
        if (array_key_exists($secondCharIndex, $this->plugboard)) {
            throw new Exception(sprintf('Plugboard component "%s" already in use.', $secondComponent));
        }
        $this->plugboard[$firstCharIndex] = $secondCharIndex;
        $this->plugboard[$secondCharIndex] = $firstCharIndex;
    }

    /**
     * @param string $key
     * @throws Exception
     */
    public function setKey(string $key): void
    {
        foreach (array_reverse(mb_str_split($key)) as $index => $char) {
            /** @var RotorInterface $rotor */
            $rotor = $this->rotors[$index];
            $rotor->setStartIndex($this->getCharIndex($char));
        }
    }

    /**
     * @param int $slot
     * @return RotorState
     */
    public function getRotorState(int $slot): RotorState
    {
        return $this->state['rotor'][$slot];
    }
}
