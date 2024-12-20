<?php
$autod = simplexml_load_file("autod.xml");

//otsingu funktsioon
function OtsingAutonumbriJargi($paring)
{
    global $autod;
    $paringVastus = array();
    foreach ($autod -> auto as $auto) {
        if (substr(strtolower($auto -> autonumber), 0, strlen($paring)) == strtolower($paring)) {
            array_push($paringVastus, $auto);
        }
    }
    return $paringVastus;
}

?>
<!DOCTYPE html>
<html lang="et">
<head>
    <title>Autode andmed XML failist</title>
    <link rel="stylesheet" href="XMLstyle.css">
</head>
<body>
    <h2>Autode andmed XML failist</h2>
    <div>
        Esimine auto andmed:
        <?php
        echo $autod->auto[0]->mark;
        echo ", ";
        echo $autod->auto[0]->autonumber;
        echo ", ";
        echo $autod->auto[0]->omanik;
        echo ", ";
        echo $autod->auto[0]->v_aasta;
        ?>
    </div>
    <!--Otsing-->
    <form action="?" method="post" >
        <label for="otsing">Otsing:</label>
        <input type="text" id="otsing" name="otsing" placeholder="autonumber">
        <input type="submit" value="OK">
    </form>
    <br>
    <br>
    <?php
        if(!empty($_POST['otsing'])) {
            $paringVastus = OtsingAutonumbriJargi($_POST['otsing']);
            echo "<table border='1'>";
            echo "<tr>";
            echo "<th>Mark</th>";
            echo "<th>Autonumber</th>";
            echo "<th>Omanik</th>";
            echo "<th>Väljastamise aasta</th>";
            echo "</tr>";

            foreach ($paringVastus as $auto) {
                echo "<tr>";
                echo "<td>".$auto->mark . "</td>";
                echo "<td>".$auto->autonumber . "</td>";
                echo "<td>".$auto->omanik . "</td>";
                echo "<td>".$auto->v_aasta . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<table border='1'>";
            echo "<tr>";
            echo "<th>Mark</th>";
            echo "<th>Autonumber</th>";
            echo "<th>Omanik</th>";
            echo "<th>Väljastamise aasta</th>";
            echo "</tr>";
            foreach ($autod as $auto) {
                echo "<tr>";
                echo "<td>".$auto->mark."</td>";
                echo "<td>".$auto->autonumber."</td>";
                echo "<td>".$auto->omanik."</td>";
                echo "<td>".$auto->v_aasta."</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    ?>
</body>
</html>