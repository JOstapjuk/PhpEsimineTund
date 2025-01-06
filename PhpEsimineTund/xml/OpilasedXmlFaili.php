<?php
$opilased = simplexml_load_file("OpilasedXML.xml");

// Kontrollida, kas vorm on esitatud
if (isset($_POST['submit'])) {
    // XML-faili laadimine DOMDocumenti muutmiseks
    $xmlDoc = new DOMDocument("1.0", "UTF-8");
    $xmlDoc->preserveWhiteSpace = false;
    $xmlDoc->formatOutput = true;

    // Olemasoleva XML-struktuuri laadimine
    $xmlDoc->load('OpilasedXML.xml');

    // Uue <opilane> elemendi loomine
    $xml_opilane = $xmlDoc->createElement("opilane");

    // Lisa uue õpilase andmed uuele <opilane> elemendile
    foreach ($_POST as $key => $value) {
        if ($key !== 'submit') {
            // Looge uus lapselement vormivälja nime ja väärtusega.
            $element = $xmlDoc->createElement($key, $value);
            $xml_opilane->appendChild($element);
        }
    }

    // Lisa uus <opilane> juurelemendile <opilased>.
    $xmlDoc->documentElement->appendChild($xml_opilane);

    // Salvesta uuendatud XML tagasi faili
    $xmlDoc->save('OpilasedXML.xml');

    // Laadige andmed uuesti, et need kajastaksid muudatusi kohe.
    $opilased = simplexml_load_file("OpilasedXML.xml");
}
?>
<!DOCTYPE>
<html lang="et">
<head>
    <title>TARpv23 rühmaleht</title>
    <link rel="stylesheet" href="OpilasedXML.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            // Korruta iga õpilase ristküliku üle ja määra taustavärv vastavalt nende juuste värvile.
            $('.rectangle').each(function() {
                let color = $(this).data('color'); // Hangi juuste värv atribuudist data-color.
                let colorCode;

                switch (color.toLowerCase()) {
                    case 'blond':
                        colorCode = '#FAEBD7';
                        break;
                    case 'pruun':
                        colorCode = '#6B3F2F';
                        break;
                    case 'must':
                        colorCode = '#000000';
                        break;
                    case 'heleblond':
                        colorCode = '#FFFACD';
                        break;
                    case 'tumeblond':
                        colorCode = `#F0E2B6`;
                        break;
                    default:
                        colorCode = '#D3D3D3';
                }

                // Salvesta värvikood andmeatribuuti, et seda hiljem hõljumisel kasutada.
                $(this).data('colorCode', colorCode);
            });

            // Muuta hõljumisel ristküliku taustavärvi.
            $('.rectangle').hover(function() {
                let colorCode = $(this).data('colorCode');

                // Muuta ristküliku taustavärvi
                $(this).css('background-color', colorCode);

                // Kui taustavärv on must, muudame teksti värvi valgeks.
                if (colorCode === '#000000') {
                    $(this).css('color', 'white');
                }else if (colorCode === '#6B3F2F') {
                    $(this).css('color', 'white');
                } else {
                    $(this).css('color', '');
                }
            }, function() {
                // Kui hiir lahkub, lähtestage taustavärv ja tekstivärv oma vaikimisi väärtusele.
                $(this).css('background-color', '');
                $(this).css('color', '');
            });
        });
    </script>
</head>
<body>
    <h2>TARpv23 rühmaleht</h2>
    <div class="Text">
        Palun valige õpilane kelle lehe te tahate vaadata
        <br>
        Kui hõljutate kursoorit õpilase nime kohal, kuvatakse tema juuksevärv
    </div>
    <div class="rectangle-container">
        <?php
        foreach ($opilased->opilane as $opilane) {
            $juksevarv = $opilane->juksevarv;
            $opilaneleht = $opilane->leht;
            //https://www.w3schools.com/jsref/met_win_open.asp
            echo "<div class='rectangle' data-color='".$juksevarv."' onclick=\"window.open('https://".$opilaneleht."', '_blank')\">";
            echo "<h3 class='opilane-nimi'>".$opilane->nimi."</h3>";
            echo "</div>";
        }
        ?>
    </div>
    <br>

    <div class="AddForm">
        <h3>Lisa uus õpilane</h3>
        <form action="?" method="post">
            <table>
                <tr>
                    <td><label for="nimi">Opilanne nimi:</label></td>
                    <td><input type="text" name="nimi" id="nimi" placeholder="Nimi"></td>
                </tr>
                <br>
                <tr>
                    <td><label for="perekonnanimi">Opilanne perekonnanimi:</label></td>
                    <td><input type="text" name="perekonnanimi" id="perekonnanimi" placeholder="Perekonnanimi"></td>
                </tr>
                <br>
                <tr>
                    <td><label for="leht">Opilanne leht:</label></td>
                    <td><input type="text" name="leht" id="leht" placeholder="Leht"></td>
                </tr>
                <br>
                <tr>
                    <td><label for="juksevarv">Opilanne juksevarv:</label></td>
                    <td>
                        <select name="juksevarv" id="juksevarv" required>
                            <option value="Blond">Blond</option>
                            <option value="Pruun">Pruun</option>
                            <option value="Must">Must</option>
                            <option value="Heleblond">Heleblond</option>
                            <option value="Tumeblond">Tumeblond</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" name="submit" id="submit" value="Lisada"></td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>
