# Enigma machine 

```php
<?php
use Yaroslavche\Enigma\Enigma;
use Yaroslavche\Enigma\Rotor\I;
use Yaroslavche\Enigma\Rotor\II;
use Yaroslavche\Enigma\Rotor\III;
use Yaroslavche\Enigma\Reflector\B;

$enigma = new Enigma('ABCDEFGHIJKLMNOPQRSTUVWXYZ');

# RTL [B][I II III][ENTRY]
$enigma->setRotor(new III());
$enigma->setRotor(new II());
$enigma->setRotor(new I());

$enigma->setReflector(new B());

$enigma->setPlugPair('A', 'B');

$enigma->setKey('AAA');
$cipher = $enigma->cryptMessage('TESTMESSAGE'); // 'OLPFHNVFFYN'

$enigma->setKey('AAA');
$message = $enigma->cryptMessage($cipher); // 'TESTMESSAGE'
```

## TODO
 - [ ] `Ring setting` (`Ringstellung`) [The Rotors](http://users.telenet.be/d.rijmenants/en/enigmatech.htm#rotors), [Rotor Encryption Process](http://users.telenet.be/d.rijmenants/en/enigmatech.htm#rotorencryption)
 - [ ] Wiring tables 
 - [ ] `The method AbstractRotor::map has a boolean flag argument $reverse, which is a certain sign of a Single Responsibility Principle violation.` (`composer phpmd`)
 - [ ] Coverage (`composer coverage` -> `build/coverage/html/index.html`)
 - [ ] MSI (`composer infection` -> `build/infection`)

### Tests
```bash
$ composer phpunit
```
[Test data](tests/EnigmaTest.php#L94) for ring settings. When this test will be passed (seems that valid expected cipher, but need to check) - should be passed all other which are commented out.
