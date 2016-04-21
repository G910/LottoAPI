<?php

require("./Lotto.php");							// Załadowanie pliku z klasą Lotto API

$lotto = new Lotto("1", "zxc");					// Połączenie podając ID klienta i Client Secret

var_dump($lotto->getLotto());					// Wyświetli wyniki z ostatniego losowania Lotto

var_dump($lotto->getLotto("2014-03-13"));		// Wyświetli wyniki losowania Lotto z dnia 2014-03-13
												// wymagany jest format daty YYYY-MM-DD

var_dump($lotto->getLottoPlus());				// Wyświetli wyniki z ostatniego losowania Lotto Plus

var_dump($lotto->getLottoPlus("2014-03-13"));	// Wyświetli wyniki losowania Lotto Plus z dnia 2014-03-13
												// wymagany jest format daty YYYY-MM-DD

var_dump($lotto->getLastError());