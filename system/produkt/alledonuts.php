<?php

include "config.php";

$stmt = $db->prepare("SELECT * FROM artikel");

if(!$stmt->execute()) {
    echo "Datenbank-Fehler ";
    $arr = $stmt->errorInfo();
    print_r($arr);
    die();
}

echo "
<div class='row'>
    <div class='col-sm-12 ueberschrift'>
        <h1>Alle Donuts</h1>
    </div>
</div>

<br>
";

$ad=1;
$anzahldonuts=$stmt->rowCount();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    if ($ad % 2 != 0 AND $ad != $anzahldonuts) {
        echo "
        <div class='row'>
        <form action='system/warenkorb/warenkorbaktionen.php' method='post'> 
        <div class='col-sm-2'>
            <img class='img-responsive donut' src='bilder/" . $row["ean"] . "." . $row["ende"] . "' width='120%' title='" . $row["donutname"] . "' alt='Bild: ".$row['donutname']."' title='".$row['donutname']."'>
        </div>
        <div class='col-sm-4'>
";
        $id = $row["id"];
        echo "<h2>" . $row["donutname"] . "</h2>";
        echo $row["beschreibung"] . "<br>";
        echo "Füllung: " . $row["fuellung"] . "<br>";
        echo "Preis: " . $row["preis"] . "€<br>";
        echo "EAN-Code: " . $row["ean"];
        echo "<br>
            Menge
            <select name='mengenangabe' size='1' class='mengenangabe'>
                <option value='1' selected>1</option>
                <option value='2'>2</option>
                <option value='3'>3</option>
                <option value='4'>4</option>
                <option value='5'>5</option>
                <option value='6'>6</option>
            </select>
    
            <input type='hidden' name='artikel_id' value='" . $row["id"] . "'>
    
            <br><br>
             <button type='submit' class='produktbutton' name='warenkorb' title='In den Warenkorb'>In den Warenkorb</button>
            <br><br>
         </div>
    </form>";
        $ad = $ad + 1;
    } elseif ($ad % 2 == 0) {
        echo "
        <form action='system/warenkorb/warenkorbaktionen.php' method='post'> 
        <div class='col-sm-2'>
            <img class='img-responsive donut' src='bilder/" . $row["ean"] . "." . $row["ende"] . "' width='120%' title='" . $row["donutname"] . "' alt='Bild: ".$row['donutname']."'>
        </div>
        <div class='col-sm-4'>
";
        $id = $row["id"];
        echo "<h2>" . $row["donutname"] . "</h2>";
        echo $row["beschreibung"] . "<br>";
        echo "Füllung: " . $row["fuellung"] . "<br>";
        echo "Preis: " . $row["preis"] . "€<br>";
        echo "EAN-Code: " . $row["ean"];
        echo "<br>
            Menge
            <select name='mengenangabe' class='mengenangabe'>
                <option value='1' selected>1</option>
                <option value='2'>2</option>
                <option value='3'>3</option>
                <option value='4'>4</option>
                <option value='5'>5</option>
                <option value='6'>6</option>
            </select>
    
            <input type='hidden' name='artikel_id' value='" . $row["id"] . "'>
    
            <br><br>
             <button type='submit' class='produktbutton' name='warenkorb' title='In den Warenkorb'>In den Warenkorb</button>
            <br><br>
         </div>
    </form>
        ";
        echo "</div>";
        $ad = $ad + 1;
    } else {
        echo "<div class='row'>
    <form action='system/warenkorb/warenkorbaktionen.php' method='post'> 
        <div class='col-sm-2'>
            <img class='img-responsive donut' src='bilder/" . $row["ean"] . "." . $row["ende"] . "' width='120%' alt='Bild: ".$row['donutname']."' title='".$row['donutname']."'>
        </div>
        <div class='col-sm-4'>
";
        $id = $row["id"];
        echo "<h2>" . $row["donutname"] . "</h2>";
        echo $row["beschreibung"] . "<br>";
        echo "Füllung: " . $row["fuellung"] . "<br>";
        echo "Preis: " . $row["preis"] . "€<br>";
        echo "EAN-Code: " . $row["ean"];
        echo "<br>
            Menge
            <select name='mengenangabe' class='mengenangabe'>
                <option value='1' selected>1</option>
                <option value='2'>2</option>
                <option value='3'>3</option>
                <option value='4'>4</option>
                <option value='5'>5</option>
                <option value='6'>6</option>
            </select>
    
            <input type='hidden' name='artikel_id' value='" . $row["id"] . "'>
    
            <br><br>
             <button type='submit' class='produktbutton' name='warenkorb' title='In den Warenkorb'>In den Warenkorb</button>
            <br><br>
         </div>
    </form>
    <div class='col-sm-6'>
    </div>
    </div>
";
    }
}