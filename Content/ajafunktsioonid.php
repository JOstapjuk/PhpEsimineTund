<?php
echo "<h2>Ajafunktsioonid</h2>";
echo "<div id='kuupaev'>";
echo "Täna on ".date("d-m-Y")."<br>";
date_default_timezone_set("Europe/Tallinn"); //mm.dd.yyyy h:mm
echo "<strong>";
echo "Tänane Tallinna kuupäev ja kellaaeg on ".date("d-m-Y G:i", time())."<br>";
echo "</strong>";
echo "Kuidas kirjutada kuupäeva php-s - date('d-m-Y G:i', time())";
echo "<br>";
echo "d - kuupäev 1-31";
echo "<br>";
echo "m - kuu numbrina 1-12";
echo "<br>";
echo "Y - aasta neljakohane";
echo "<br>";
echo "G - tunniformaat 0 - 23";
echo "<br>";
echo "i - minutid 0 - 59";
echo "</div>";
?>
<div class="container">
    <div id="hooajad" class="item">
        <h2>Väljasta vastavalt hooajale pilt</h2>
        <?php
        $today=new DateTime();
        echo "Täna on ".$today->format("m-d-Y");
        echo "<br>";
        //hooaeg punktid- сезон
        $spring = new DateTime('March 01');
        $summer = new DateTime('June 01');
        $fall = new DateTime('September 01');
        $winter = new DateTime('December 01');

        switch(true){
            //kevad
            case ($today>=$spring && $today<$summer):
                echo "Kevad";
                echo "<br>";
                $pildi_aadress='content/img/spring.jpg';
                break;
            //suvi
            case ($today>=$summer && $today<$fall):
                echo "Suvi";
                echo "<br>";
                $pildi_aadress='content/img/summer.jpg';
                break;
            //sügis
            case ($today>=$fall && $today<$winter):
                echo "Sügis";
                echo "<br>";
                $pildi_aadress='content/img/fall.jpg';
                break;
            //talv
            case ($today>=$winter && $today<$spring):
                echo "Talv";
                echo "<br>";
                $pildi_aadress='content/img/winter.jpg';
        }
        ?>
        <img src="<?=$pildi_aadress?>" alt='hooaja pilt'>
    </div>
    <div id="talvevaheag" class="item">
        <h2>Mitu päeva on talvevaheajani 23.12.2024</h2>
        <?php
        $kdate =date_create_from_format('d.m.Y', '23.12.2024');
        $date=date_create();
        $diff=date_diff($kdate,$date);
        echo "Jääb ".$diff->format("%a")." päeva";
        //echo "<br>";
        //echo "Jääb ".$diff->days." päeva";
        ?>
    </div>
        <div id="sunnipaev" class="item">
        <h2>Minu sünnipäev 12.06.2025</h2>
        <?php
        $kdate =date_create_from_format('d.m.Y', '12.06.2025');
        $date=date_create();
        $diff=date_diff($kdate,$date);
        echo "Jääb ".$diff->format("%a")." päeva";
        //echo "<br>";
        //echo "Jääb ".$diff->days." päeva";
        ?>
    </div>
    <div id="vanus" class="item">
        <h2>Kasutaja vanuse leidmine</h2>
        <form method="post" action="">
            Sisesta oma sünnikuupäev
            <input type="date" name="synd" placeholder="dd.mm.yyyy">
            <input type="submit" value="OK">
        </form>
        <?php
        if (isset($_REQUEST["synd"])){
            if(empty($_REQUEST["synd"])){
                echo "Sisesta oma sünnipäev kuupäev";
            }
            else{
                $sdate =date_create($_REQUEST["synd"]);
                $date=date_create();
                $interval=date_diff($sdate,$date);
                echo "Sa oled ".$interval->format("%y")." aastat vana";
            }
        }
        ?>
    </div>
    <div id="kupaevMasiiviAbil" class="item">
        <h2>Massivi abil näidata kuu nimega tänases kuupäevas</h2>
        <?php
        $kuud=array(1=>'jaanuar', 'veebruar', 'march','april','may','juni','juli', 'august', 'september', 'oktoober', 'november', 'december');
        $paev=date('d');
        $year=date('Y');
        $kuu=$kuud[date('n')];
        echo $paev.' '.$kuu.' '.$year;
        ?>
    </div>
</div>