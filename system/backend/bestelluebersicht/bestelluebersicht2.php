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
<br>";


$stmt = $db->prepare("SELECT * FROM bestellungen b, bestellte_artikel ba, benutzer be WHERE b.id=ba.bestellungen_id AND b.benutzer_id=be.id ORDER BY b.erstellt");

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
        <h3>Bestellungsnummer: ".$row["bestellungen_id"]."</h3><br>
        </div>
    </div>
    <div class='row'>
        <div class='col-sm-4'>";
    echo "<h4>Name: </h4>".$row["nachname"].", ".$row["vorname"]."<br>
        </div>
        <div class='col-sm-4'>
    ";
    echo "<h4>Straße: </h4>".$row["straße"]." ".$row["hausnummer"]."<br>
        </div>
        <div class='col-sm-4'>
        <h4>Bestellt am:</h4>" . $row["erstellt"]."
        </div>
    </div><br>";
    $bestellungid= $row["bestellungen_id"];

    $stmt2 = $db->prepare("SELECT * FROM bestellte_artikel ba LEFT JOIN artikel a ON ba.artikel_id = a.id WHERE ba.bestellungen_id='".$bestellungid."'");

    if (!$stmt2->execute()) {
        echo "Datenbank-Fehler ";
        $arr = $stmt2->errorInfo();
        print_r($arr);
        die();
    }

    while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        echo "
<div class='row'>
    <div class='col-sm-4'>
        <img class='img-responsive' src='../../bilder/" . $row2["ean"] . ".".$row2["ende"]."' width='40%' alt='Bild: ".$row2['donutname']."' title='".$row2['donutname']."'>
    </div>
    <div class='col-sm-8'>
    ";
        $id = $row2["id"];
        echo "<h3>" . $row2["donutname"] . "</h3>";
        echo "Einzelpreis: " . $row2["preis"] . "<br>";
        echo "EAN-Code: " . $row2["ean"] . "<br>";
        echo "Menge: " . $row2["menge"] . "<br>";
        echo "</div>
</div>";
    }
    echo "<div class='strich'>
        </div><br>";
}
echo"    
    </div>
</div>
</div>
";
?>