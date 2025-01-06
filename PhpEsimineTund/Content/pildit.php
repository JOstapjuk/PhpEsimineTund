<h2>PHP – Töö pildifailidega</h2>
<a href="https://www.metshein.com/unit/php-pildifailidega-ulesanne-14/">Töö pildifailifega</a>
<form method="post" action="">
    <select name="pildid"> <!-- ripp loend -->
        <option value="">Vali pilt</option>
        <?php
        $kataloog = 'Content/img';
        $asukoht=opendir($kataloog); // võtab kaustast pildi failid
        while($rida = readdir($asukoht)){
            if($rida!='.' && $rida!='..'){
                echo "<option value='$rida'>$rida</option>\n";
            }
        }
        ?>
    </select>
    <input type="submit" value="Vaata">
    <input name="random" type="submit" value="Random pilt">
</form>
<?php
if (!empty($_POST['pildid'])) { //kui kasutaja vajutab "Vaata" nupp,siis näitame ripp loendist pilti
    $pilt = $_POST['pildid'];
    $pildi_aadress = 'content/img/' . $pilt;
    $pildi_andmed = getimagesize($pildi_aadress);

    // Pildi mõõtmete ja formaadi saamine
    $laius = $pildi_andmed[0];
    $korgus = $pildi_andmed[1];
    $formaat = $pildi_andmed[2];

    // Suhte arvutamine ja pilti suurenemine
    $max_laius = 120; // Maksimaalne laiuse piirang
    $max_korgus = 90; // Maksimaalne kõrguse piirang

    // Arvutame suhte sõltuvalt pildi mõõtmestest
    if ($laius <= $max_korgus && $korgus <= $max_korgus) {
        $ratio = 1; // Suhteline suurus
    } elseif ($laius > $korgus) {
        $ratio = $max_laius / $laius; // Laius on suurem, seega suletakse vertikaalselt
    } else {
        $ratio = $max_korgus / $korgus; // Kõrgus on suurem, seega suletakse horisontaalselt
    }

    // Arvutame uued mõõdud
    $pisi_laius = round($laius * $ratio);
    $pisi_korgus = round($korgus * $ratio);

    // Väljendame originaal- ja uue pildi andmeid
    echo '<h3>Originaal pildi andmed</h3>';
    echo "Laius: $laius<br>";
    echo "Kõrgus: $korgus<br>";
    echo "Formaat: $formaat<br>";

    echo '<h3>Uue pildi andmed</h3>';
    echo "Arvutatud suhe: $ratio <br>";
    echo "Laius: $pisi_laius<br>";
    echo "Kõrgus: $pisi_korgus<br>";
    echo "<img width='$pisi_laius' height='$pisi_korgus' src='$pildi_aadress'>";
}

elseif (isset($_POST['random'])) {
    // massiv kus pildid asuvad
    $pildimassiiv = array('Content/img/summer.jpg','Content/img/fall.jpg','Content/img/winter.jpg','Content/img/spring.jpg');
    $randnum = rand(0, 3); // juhuslikult pilt
    $pildi_aadress = $pildimassiiv[$randnum];
    $pildi_andmed = getimagesize($pildi_aadress);

    $laius = $pildi_andmed[0];
    $korgus = $pildi_andmed[1];
    $formaat = $pildi_andmed[2];

    $max_laius = 120;
    $max_korgus = 90;

    if ($laius <= $max_korgus && $korgus <= $max_korgus) {
        $ratio = 1;
    } elseif ($laius > $korgus) {
        $ratio = $max_laius / $laius;
    } else {
        $ratio = $max_korgus / $korgus;
    }

    $pisi_laius = round($laius * $ratio);
    $pisi_korgus = round($korgus * $ratio);

    echo '<h3>Originaal pildi andmed</h3>';
    echo "Laius: $laius<br>";
    echo "Kõrgus: $korgus<br>";
    echo "Formaat: $formaat<br>";

    echo '<h3>Uue pildi andmed</h3>';
    echo "Arvutatud suhe: $ratio <br>";
    echo "Laius: $pisi_laius<br>";
    echo "Kõrgus: $pisi_korgus<br>";
    echo "<img width='$pisi_laius' height='$pisi_korgus' src='$pildi_aadress'>";
}
?>

