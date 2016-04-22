<?php

require("./Lotto.php");                         // Załadowanie pliku z klasą Lotto API

$lotto = new Lotto("1", "zxc");                 // Połączenie podając ID klienta i Client Secret
                                                // KONTO TESTOWE! ID: 1 SECRET: zxc

var_dump($lotto->getLotto());                   // Wyświetli wyniki z ostatniego losowania Lotto

var_dump($lotto->getLotto("2014-03-13"));       // Wyświetli wyniki losowania Lotto z dnia 2014-03-13
                                                // wymagany jest format daty YYYY-MM-DD

var_dump($lotto->getLottoPlus());               // Wyświetli wyniki z ostatniego losowania Lotto Plus

var_dump($lotto->getLottoPlus("2014-03-13"));   // Wyświetli wyniki losowania Lotto Plus z dnia 2014-03-13
                                                // wymagany jest format daty YYYY-MM-DD

var_dump($lotto->getEkstraPensja());            // Wyświetli wyniki z ostatniego losowania Ekstra Pensja

var_dump($lotto->getLastError());


/*
***SAMPLE RESPONSE***

$lotto->getLotto();

array(2) {
  ["status"]=>
  int(1)
  ["lottery"]=>
  array(4) {
    ["number"]=>
    string(4) "5777"
    ["date"]=>
    string(10) "2016-04-21"
    ["day"]=>
    string(8) "czwartek"
    ["numbers"]=>
    array(6) {
      [0]=>
      string(1) "5"
      [1]=>
      string(2) "11"
      [2]=>
      string(2) "32"
      [3]=>
      string(2) "34"
      [4]=>
      string(2) "41"
      [5]=>
      string(2) "44"
    }
  }
}

*/
