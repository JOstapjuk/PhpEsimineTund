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
echo "Sõnade arv lauses - ".str_word_count($tekst);
// teksti kärpimine
$tekst2 = '   Põhitoetus võetakse ära 11.11 kui võlgnevused ei ole parandatud   ';
echo "<br>";
echo trim($tekst2, "P ");
echo "<br>";
echo ltrim($tekst2);
echo "<br>";
echo rtrim($tekst2);

// tekst kui massiiv
$tekst3 = 'Taindev info opilase kohta';
echo '<br>';
echo "Esimine täht - ".$tekst3[0]; // Esimine täht tekstist
echo '<br>';
echo "Neljas täht - ".$tekst3[4]; // Neljas täht tekstist
echo '<br>';
echo substr($tekst3, 3, 5); // Teksti osa alates indeksist 3, pikkus 5
echo '<br>';
echo substr($tekst3, 4, -13); // Teksti osa alates indeksist 4, pikkus -13 (viib lõpuks)
echo '<br>';
echo substr($tekst3, -8, 7); // Teksti osa 8 indeksi eest, pikkus 7
echo '<br>';
print_r(str_word_count($tekst3, 1)); // Sõnad jaotatud indeksidega
echo '<br>';
$sona = str_word_count($tekst3, 1);
echo "Kolmas sõna - ".$sona[3]; // Kolmas sõna
echo '<br>';
print_r(str_word_count($tekst3, 2)); // määratakse sõna indeks vastava sümboli indeksiga kogu massiivis

