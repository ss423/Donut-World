<?php
include "config.php";

$nachname=$_SESSION["nutzer"]["nachname"]; //rauslesen Nutzer Nachname

echo"
<div class='row'>
    <div class='col-sm-12 ueberschrift'>
        <h1>Meine Seite</h1>
    </div>
</div>

<br>

<h2>Meine Daten</h2>
<br>
";

echo "
<div class='row'>
    <div class='col-sm-2'>
        Name:<br>
        Adresse:<br>
    </div>
    <div class='col-sm-10'>";    //Nutzerangaben (Adresse)
echo $_SESSION["nutzer"]["vorname"] . " " .$_SESSION["nutzer"]["nachname"]. "<br>";
echo $_SESSION["nutzer"]["straße"] . " " .$_SESSION["nutzer"]["hausnummer"]. "<br>" . $_SESSION["nutzer"]["plz"]. " " . $_SESSION["nutzer"]["ort"];
echo "</div></div>";
$id=$_SESSION["nutzer"]["id"];
echo"
<h2>Meine Bestellungen</h2>
<div class='row'>
<div class='col-sm-12 strich'>
</div>
</div>
<div class='row'>
<br>
</div>
";

//rauslesen Bestellte Artikel
$stmt = $db->prepare("SELECT * FROM bestellungen WHERE bestellungen.benutzer_id='".$id."' ORDER BY bestellungen.erstellt DESC");
if(!$stmt->execute()){
    echo "Datenbank-Fehler ";
    $arr = $stmt->errorInfo();
    print_r($arr);
    die();
}
while ($row=$stmt->fetch(PDO::FETCH_ASSOC)){
    $bestellung_id=$row['id'];

    $stmt2 = $db->prepare("SELECT * FROM bestellte_artikel ba LEFT JOIN artikel ON ba.artikel_id = artikel.id WHERE ba.bestellungen_id='".$bestellung_id."'");
    if(!$stmt2->execute()){
        echo "Datenbank-Fehler ";
        $arr = $stmt->errorInfo();
        print_r($arr);
        die();
    }
    echo "Sie haben folgende Produkt/-e am ".$row["erstellt"]." bestellt:";
    while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        echo "
        <div class='row'>
        <br>
        </div>
    <div class='row'>
        <div class='col-sm-4'>
            <img class='img-responsive' src='bilder/" . $row2["ean"] . ".jpg' width='40%' alt='Bild: ".$row2['donutname']."' title='".$row['donutname']."'>
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
/*
*/