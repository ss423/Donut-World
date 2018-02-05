<?php
if(!isset($_REQUEST['id'])){
    header("Location: ../../index.php?page=alledonuts");
}
echo"
<body>";
include "config.php";

$bestellid=$_GET['id'];
$artikel='';
echo"
<div class='row'>
    <div class='col-sm-12'>
        <br>
        <h1>Danke für Ihre Bestellung!</h1>
    </div>
</div>

<br>
<div class='row'>
    <div class='col-sm-12'>
        <p>Ihre Bestellung war erfolgreich. Ihre Bestellnummer lautet: ".$_GET['id']."</p>
        Sie erhalten eine Bestellbestätigung per E-Mail!<br>
    </div>
</div>
<br>
";
$bestellungid=$_GET['id'];
$stmt = $db->prepare("SELECT * FROM bestellungen b, bestellte_artikel ba, artikel a 
WHERE bestellungen_id=".$_GET['id']." AND b.id=ba.bestellungen_id AND ba.artikel_id=a.id");

if(!$stmt->execute()) {
    echo "Datenbank-Fehler ";
    $arr = $stmt->errorInfo();
    print_r($arr);
    die();
}
echo "
<div class='row'>
    <div class='col-sm-12'>
        <h3>Sie haben folgende Donut/-s bestellt:</h3> <br />
    </div>
</div>";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "
<div class='row'>
    <div class='col-sm-4'>
        <img class='img-responsive' src='bilder/" . $row["ean"] . ".".$row['ende']."' width='200px' alt='Bild: ".$row['donutname']."' title='".$row['donutname']."'>
    </div>
    <div class='col-sm-8'>
    ";
    $id = $row["id"];
    echo "<h3>" . $row["donutname"] . "</h3>";
    echo "Einzelpreis: " . $row["preis"] . " €<br>";
    echo "EAN-Code: " . $row["ean"] . "<br>";
    echo "Menge: " . $row["menge"];

    $artikel .= "Donutname: " . $row["donutname"] . "\n";
    $artikel .= "Einzelpreis: " . $row["preis"] . " Euro\n";
    $artikel .= "EAN-Code: " . $row["ean"] . "\n";
    $artikel .= "Menge: " . $row["menge"] . "\n";

    echo "
    </div>
</div>
<div class='row'>
    <br>
</div>
<div class='row'>
    <div class='col-sm-6 strich'>
    </div>
    <div class='col-sm-6'>
    </div>
</div>
<div class='row'>
    <br>
</div>

";
}
echo "
<div class='row'>
<div class='col-sm-4'>
</div>
<div class='col-sm-8'>";
include_once "config.php";
$stmt = $db->prepare("SELECT * FROM bestellungen b, benutzer be WHERE b.benutzer_id=be.id AND b.id=".$_GET['id']);

if(!$stmt->execute()) {
    echo "Datenbank-Fehler ";
    $arr = $stmt->errorInfo();
    print_r($arr);
    die();
}
$row = $stmt->fetch(PDO::FETCH_ASSOC);
echo"Endpreis:".$row["endpreis"];
$endpreis="Endpreis:".$row["endpreis"]." Euro\n";
$emailempf=$row['email'];
$datum=$row['erstellt'];

echo"
</div>
</div>
</body>
</html>";
$email_to = $emailempf;     //Email empfänger

$email_subject = "Ihre Bestellbestaetigung von Donut World: \n";   //Betreff Email


$email_message='';
$email_message.="Sie haben folgende Donut/-s am ".$datum." bestellt: \n";
$email_message.=$artikel."\n";
$email_message.=$endpreis."\n";

$headers = 'From: '.$emailempf."\r\n".

    @mail($email_to, $email_subject, $email_message, $headers);