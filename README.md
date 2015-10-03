Testovanie posielania emailov
===
Testovanie posielania emailov v eshope pomocou PHP Unit.

tests
  `
  |-- Makefile              - test harness
  |-- README                - tento soubor
  |-- bootstrap.php         - globalni definice pro phpunit
  |-- <ClassName>Test.php   - testovaci pripady pro ClassName
  |-- unittest.log.json     - log z testovani
  |-- coverage-report/      - adresar s reportem
  |    `
  |    |-- index.html       - indexovy soubor reportu
  |    ...
  |-- Mail.php              - definice testovacich dvojniku
  |-- Mail_mime.php         - definice testovacich dvojniku
  |-- doubles.php           - definice testovacich dvojniku
  |-- ex_mailTest.php       - priklad testovaciho pripadu
  |-- Popis                 - vyvojaruv strucny popis chovani testovane funkce
  `-- ex_mail.php           - testovany soubor


Spousteni testu
===============

    make

    nebo

    make test

Vytvoreni novych testu
======================

    # edit newClassNameTest.php
    make

Vytvoreni reportu pokryti
=========================

    make report
    # zkontrolujte indexovy soubor: coverage-report/index.html
