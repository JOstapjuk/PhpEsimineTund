<?php

echo "Tere hommikust!";
echo "<br>";
$muutuja = 'PHP on skriptikeel';
echo "<strong>";
echo $muutuja;
echo "</strong>";
echo "<br>";

// Tekstifunktsioonid
echo "<h2>Tekstifunktsioonid</h2>";
$tekst = 'Esmaspäev on 4.November';
echo $tekst;
// kõik tähed on suured
echo "<br>";
echo mb_strtoupper($tekst); // mb_ tunneb ä täht
// kõik tähed on väiksed
echo "<br>";
echo strtolower($tekst);
//iga sõna algab suure tähega
echo "<br>";
echo ucwords($tekst);
//teksti pikkus
echo "<br>";
echo strlen($tekst);
//eraldame esimesed 5 tähte
echo "<br>";
echo "Esimesed 5 tähte - " . substr($tekst, 0, 5);
//leiame "on" positsiooni
echo "<br>";
$otsing = 'on';
echo "On asukoht lauses on - " . strpos($tekst, $otsing);
// eralda esimine sõna kuni $otsing
echo "<br>";
echo "Esimine sõna on - " . substr($tekst, 0, strpos($tekst, $otsing));

echo "<h2>Kasutame veebis kasutavad näidised</h2>>";
//sõnade arv lauses
echo "Sõnade arv lauses - " . str_word_count($tekst);
// teksti kärpimine
$tekst2 = '   Põhitoetus võetakse ära 11.11 kui võlgnevused ei ole parandatud   ';
echo "<br>";
echo trim($tekst2, "P, t..k");
echo "<br>";
echo ltrim($tekst2);
echo "<br>";
echo rtrim($tekst2);

// tekst kui massiiv