# 
[![Build Status](https://travis-ci.org/yaroslavche/enigma.svg?branch=master)](https://travis-ci.org/yaroslavche/enigma)
[![License](https://poser.pugx.org/yaroslavche/enigma/license?format=flat)](https://packagist.org/packages/yaroslavche/enigma)
[![Latest Stable Version](https://poser.pugx.org/yaroslavche/enigma/v/stable?format=flat)](https://packagist.org/packages/yaroslavche/enigma)
[![PHP Version](https://img.shields.io/packagist/php-v/yaroslavche/enigma/dev-master)](https://www.php.net/)


Clean PHP project with dev tools.

## Installation

Download and install
```bash
$ composer create-project yaroslavche/enigma projectName --prefer-source
```

or manually

```bash
$ git clone yaroslavche/enigma
$ composer install --prefer-source
```

<details>
  <summary>Post cmd</summary>
  
  In `composer.json` you can see `post-install-cmd` and `post-create-project-cmd`, which will: 
   - ask needed information
   - change `composer.json`
   - replace all occurrences (vendor, package) in `README.md`
   - uncomment lines in `.gitattributes`
   - remove self in `composer.json` (if remove installer after complete)
   - remove installer (whole `internal` directory, by default)
</details>

## Tools

<details>
  <summary>PHP_CodeSniffer</summary>
    
  [squizlabs/PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)
  > PHP_CodeSniffer is a set of two PHP scripts; the main phpcs script that tokenizes PHP, JavaScript and CSS files to detect violations of a defined coding standard, and a second phpcbf script to automatically correct coding standard violations. PHP_CodeSniffer is an essential development tool that ensures your code remains clean and consistent.
  
  Check:
  ```bash
  $ composer phpcs
  ```

  Fix:
  ```bash
  $ composer phpcbf
  ```
</details>

<details>
  <summary>PHPMD - PHP Mess Detector</summary>
    
  [phpmd/phpmd](https://github.com/phpmd/phpmd)
  > What PHPMD does is: It takes a given PHP source code base and look for several potential problems within that source. These problems can be things like:
  > Possible bugs,
  > Suboptimal code,
  > Overcomplicated expressions,
  > Unused parameters, methods, properties.

  
  ```bash
  $ composer phpmd
  ```
</details>

<details>
  <summary>PHPStan - PHP Static Analysis Tool</summary>
  
  [phpstan/phpstan](https://github.com/phpstan/phpstan)
  > PHPStan focuses on finding errors in your code without actually running it. It catches whole classes of bugs even before you write tests for the code. It moves PHP closer to compiled languages in the sense that the correctness of each line of the code can be checked before you run the actual line.
  
  ```bash
  $ composer phpstan
  ```
</details>

<details>
  <summary>PHPUnit</summary>
    
  [sebastianbergmann/phpunit](https://github.com/sebastianbergmann/phpunit) | [Writing Tests](https://phpunit.readthedocs.io/en/8.3/writing-tests-for-phpunit.html)
  > PHPUnit is a programmer-oriented testing framework for PHP. It is an instance of the xUnit architecture for unit testing frameworks.
  
  Run tests:
  ```bash
  $ composer phpunit
  ```
  
  Code coverage
  ```bash
  $ composer coverage
  ```
  Will show results in console and if success, then generate `build/coverage/html/` directory (see `index.html` in browser) and `build/coverage/clover.xml` (which can be useful in some cases).
</details>

<details>
  <summary>Infection - Mutation Testing framework</summary>
  
  [infection/infection](https://github.com/infection/infection)
  > Infection is a PHP mutation testing framework based on AST (Abstract Syntax Tree) mutations. It works as a CLI tool and can be executed from your project’s root.
  >
  > Mutation testing is a testing methodology that involves modifying a program in small ways and analyzing reactions of the test suite on these modifications. If tests pass after the code is changed, then we have either not covered line of code or the tests are not very efficient for the mutated piece of code.
    
  ```bash
  $ composer infection
  ```
</details>

<details>
  <summary>Roave Backward Compatibility Check</summary>
    
  [Roave/BackwardCompatibilityCheck](https://github.com/Roave/BackwardCompatibilityCheck)
  > A tool that can be used to verify BC breaks between two versions of a PHP library.
  >
  > Backward compatible (or sometimes backward-compatible or backwards compatible) refers to a hardware or software system that can successfully use interfaces and data from earlier versions of the system or with other systems.
 
  ```bash
  $ composer bccheck
  ```
</details>

<details>
  <summary>Roave Security Advisories</summary>
    
  [Roave/SecurityAdvisories](https://github.com/Roave/SecurityAdvisories)
  > Does not provide any API or usable classes: its only purpose is to prevent installation of software with known and documented security issues.
</details> 

## Travis CI
[docs](https://docs.travis-ci.com/)
> Continuous Integration is the practice of merging in small code changes frequently - rather than merging in a large change at the end of a development cycle. The goal is to build healthier software by developing and testing in smaller increments. This is where Travis CI comes in.

If need, uncomment in `.travis.yml` needed checks (lines in `script` section) and [enable travis builds](https://travis-ci.org) for repository.
