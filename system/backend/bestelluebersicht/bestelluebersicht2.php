<?php
if (!isAdmin()) {
    $_SESSION['msg'] = "Du musst dich erst einloggen";
    header('location: ../account/login.php');
}
include_once "../../config.php";
echo "
<div class='row'>
    <div class='col-sm-12'>
        <div class='bestelluebersicht'>
            <br><h1>Alle Bestellungen</h1>
        </div>
    </div>
</div>
<br>
   <div class='row'>
        <div class='col-sm-12 strich'>
        </div>
    </div>
    <div class='row'>
        <br>
    </div>

";


$stmt = $db->prepare("SELECT bestellungen.id, bestellungen.endpreis, bestellungen.erstellt, benutzer.nachname, benutzer.vorname, benutzer.straße, benutzer.hausnummer, benutzer.ort, benutzer.plz 
FROM bestellungen LEFT JOIN benutzer 
ON bestellungen.benutzer_id=benutzer.id ORDER BY bestellungen.erstellt DESC");

if(!$stmt->execute()) {
    echo "Datenbank-Fehler ";
    $arr = $stmt->errorInfo();
    print_r($arr);
    die();
}

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "

    <div class='row'>
        <div class='col-sm-12'>
        <h3>Bestellungsnummer: " . $row["id"] . "</h3><br>
        </div>
    </div>
    <div class='row'>
        <div class='col-sm-4'>";
    echo "<h4>Name: </h4>" . $row["nachname"] . ", " . $row["vorname"] . "<br>
        </div>
        <div class='col-sm-4'>
    ";
    echo "<h4>Straße: </h4>" . $row["straße"] . " " . $row["hausnummer"] . "<br>
        </div>
        <div class='col-sm-4'>
        <h4>Bestellt am:</h4>" . $row["erstellt"] . "
        </div>
    </div><br>";
    $bestellung_id = $row["id"];


    $stmt2 = $db->prepare("SELECT * FROM bestellte_artikel ba LEFT JOIN artikel ON ba.artikel_id = artikel.id WHERE ba.bestellungen_id='" . $bestellung_id . "'");
    if (!$stmt2->execute()) {
        echo "Datenbank-Fehler ";
        $arr = $stmt->errorInfo();
        print_r($arr);
        die();
    }
    while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        echo "
    <div class='row'>
        <br>
    </div>
    <div class='row'>
        <div class='col-sm-4'>
            <img class='img-responsive' src='../../bilder/" . $row2["ean"] . ".jpg' width='40%' alt='Bild: ".$row2['donutname']."' title='".$row['donutname']."'>
        </div>
        <div class='col-sm-8'>
            ";
        $id = $row2["id"];
        echo "<h3>" . $row2["donutname"] . "</h3>";
        echo "Einzelpreis: " . $row2["preis"] . " Euro<br>";
        echo "EAN-Code: " . $row2["ean"]."<br>";
        echo "Menge: " . $row2["menge"]."<br>";
        echo "</div>
    </div>
    ";
    }
    echo "<div class='row'>
        <br>
        </div>
        <div class='row'>
            <div class='col-sm-4'>
            </div>
            <div class='col-sm-8'>
    ";
    echo "Endpreis: ".$row['endpreis']." Euro<br><br>
            </div>
        </div>
    ";
    echo"<div class='row'>
            <div class='col-sm-12 strich'>
            </div>
        </div>
        <div class='row'>
            <br>
        </div>
";
}
echo"    

";
?>