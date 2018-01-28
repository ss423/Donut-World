<?php

if (!isAdmin()) {
    $_SESSION['msg'] = "Du musst dich erst einloggen";
    header('location: ../account/login.php');
}


echo "
<div id='donuts'>
    <br><h1>Produkte bearbeiten</h1><br><br>
</div>
";

include_once ("../../config.php");
$stmt = $db->prepare("SELECT * FROM artikel");      //DB Verbindung herstellen & alles von artikel auslesen

if(!$stmt->execute()) {
    echo "Datenbank-Fehler ";
    $error = $stmt->errorInfo();
    print_r($error);
    die();
}

echo"
<div class='row'>
    <div class='col-sm-12'>
        <a href='admin.php?page=hinzufuegen' id='hinzufügen'><button class='rosabutton'>+ Neuen Donut hinzufügen</button></a>
    </div>
</div>

<br>
<br>
";


while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { //einzelne ELemente pro Artikel auslesen
    $id = $row["id"];
    echo "<div class='row'>
            <div class='col-sm-12'>
                <h2>" . $row["donutname"] . "</h2>
            </div>
           </div>
          <div class='row'>
            <div class='col-sm-4'>
                <img class='img-responsive' src='../../bilder/" . $row["ean"] . ".".$row["ende"]."' width='70%' alt='Bild: ".$row['donutname']."' title='".$row['donutname']."'><br>
            </div>
            <div class='col-sm-8'>
                <h4>Produktbeschreibung:</h4>
                <br>" . $row["beschreibung"] . "<br>
                <h4>Füllung: </h4>" . $row["fuellung"] . "<br>
                <h4>EAN-Code: </h4>" . $row["ean"] . "<br>
                <h4>Preis: </h4> " . $row["preis"] . "€ <br>
                <br><br>
                <a href='admin.php?page=bearbeiten&id=" . $id . "' id='bearbeiten'><button class='bearbeitenbutton'>bearbeiten</button></a>";
    /*braucht switch funktion für id übertragung*/
    echo "      <a href='admin.php?page=loeschen&id=" . $id . "' id='löschen'><button class='loeschenbutton'>löschen</button></a>
            </div>
          </div>";
    echo "<br><br>
            <div class='row strich'></div>";
}


