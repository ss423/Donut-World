<?php
include "config.php";

$nachname=$_SESSION["nutzer"]["nachname"]; //rauslesen Nutzer Nachname

echo"
<div class='row'>
    <div class='col-sm-12 produkte'>
        <h1>Meine Seite</h1>
    </div>
</div>

<br>

<h2>Meine Daten</h2>
<br>
";

echo "
<div class='row'>
    <div class='col-sm-4'>
        Name:<br>
        Adresse:<br>
    </div>
    <div class='col-sm-8'>";    //Nutzerangaben (Adresse)
        echo $_SESSION["nutzer"]["vorname"] . " " .$_SESSION["nutzer"]["nachname"]. "<br>";
        echo $_SESSION["nutzer"]["straße"] . " " .$_SESSION["nutzer"]["hausnummer"]. "<br>" . $_SESSION["nutzer"]["plz"]. " " . $_SESSION["nutzer"]["ort"];
        echo "</div></div>";
        $id=$_SESSION["nutzer"]["id"];

echo"
<h2>Meine Bestellungen</h2>
";

//rauslesen Bestellte Artikel
$stmt = $db->prepare("SELECT * FROM bestellungen b, bestellte_artikel ba, artikel a 
WHERE b.benutzer_id=".$id." AND b.id=ba.bestellungen_id AND ba.artikel_id=a.id ORDER BY ba.bestellungen_id");

if(!$stmt->execute()) {
    echo "Datenbank-Fehler ";
    $arr = $stmt->errorInfo();
    print_r($arr);
    die();
}

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "
    <div class='row'>
        <div class='col-sm-4'>
            <img class='img-responsive' src='bilder/" . $row["ean"] . ".jpg' width='40%' alt='Bild: ".$row['donutname']."' title='".$row['donutname']."'>
        </div>
        <div class='col-sm-8'>
            ";
            $id = $row["id"];
            echo "<h3>" . $row["donutname"] . "</h3>";
            echo "Einzelpreis: " . $row["preis"] . "<br>";
            echo "EAN-Code: " . $row["ean"]."<br>";
            echo "Menge: " . $row["menge"]."<br>";
            echo "Bestellt am: ".$row["erstellt"];
        echo "</div>
    </div>
    <div class='row strich'>
    </div>
    ";
}
