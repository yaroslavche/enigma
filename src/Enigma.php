<?php

namespace Yaroslavche\Enigma;

use Exception;
use Yaroslavche\Enigma\Reflector\ReflectorInterface;
use Yaroslavche\Enigma\Rotor\RotorInterface;

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
     * @param int|null $ringPosition
     * @param int|null $slot RTL, REFLECTOR [B] <-> ROTORS [II (2), IV (1), V (0)] <-> INPUT
     * @throws Exception
     */
    public function setRotor(RotorInterface $rotor, ?int $ringPosition = null, ?int $slot = null): void
    {
        $slot = $slot ?? count($this->rotors ?? []);
        if ($slot < 0 || $slot > mb_strlen($this->alphabet)) {
            throw new Exception(sprintf('Invalid rotor position %d', $slot));
        }
        $rotor->setRingPosition($ringPosition ?? 0);
        $this->rotors[$slot] = $rotor;
        ksort($this->rotors);
    }

    public function setReflector(ReflectorInterface $reflector): void
    {
        $this->reflector = $reflector;
    }

    public function cryptChar(string $char): string
    {
        $this->rotate();
        $charIndex = $this->getCharIndex($char);
        $charIndex = $this->makePath($charIndex);
        return $this->translate{$charIndex};
    }


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
        foreach ($this->rotors as $rotor) {
            if ($rotate) {
                $rotor->rotate();
            }
            $rotate = $rotate && $rotor->isInTurnoverPosition();
        }
    }

    private function makePath(int $charIndex): int
    {
        # plugboard
        $charIndex = $this->plugboard[$charIndex] ?? $charIndex;

        # rotors
        /** @var RotorInterface $rotor */
        foreach ($this->rotors as $rotor) {
            $charIndex = $rotor->map($charIndex);
        }

        # reflector
        if ($this->reflector instanceof ReflectorInterface) {
            $charIndex = $this->reflector->map($charIndex);
        }

        # rotors backward
        foreach (array_reverse($this->rotors) as $rotor) {
            $charIndex = $rotor->map($charIndex, true);
        }

        # plugboard
        $charIndex = $this->plugboard[$charIndex] ?? $charIndex;

        return $charIndex;
    }

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

    public function setKey(string $key): void
    {
        foreach (array_reverse(mb_str_split($key)) as $index => $char) {
            /** @var RotorInterface $rotor */
            $rotor = $this->rotors[$index];
            $rotor->setStartPosition($this->getCharIndex($char));
        }
    }
}
