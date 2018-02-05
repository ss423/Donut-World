<?php
//session_start();

try {
    include "../../config.php";
    $stmt = $db->prepare("SELECT * FROM artikel WHERE id=".$_GET["id"]);
    $stmt->execute();
    if ($zeile = $stmt->fetchObject()) {    //Artikel auslesen

echo "
    <div class='row'>
       <div class='col-sm-12' id='donutsbearbeiten'>
            <br><h1>Donut bearbeiten</h1>
       </div>
    </div>
<br><br>
              
<form action='admin.php?page=bearbeitesenden' method='post' enctype='multipart/form-data'>
    <input type='hidden' name='id' value='$zeile->id' />
    
    <div class='row'>
        <div class='col-sm-2'>
        </div>
        <div class='col-sm-1'>
            <h4>Bild:</h4>
        </div>
        <div class='col-sm-1'>
        </div>
        <div class='col-sm-7'>
            <img src='../../bilder/".$zeile->ean.".".$zeile->ende."' width='20%' class='img-responsive' alt='Bild: ".$zeile->donutname."' title='".$zeile->donutname."'>
            <input type='hidden' name='ende'value='".$zeile->ende."'>
            <input type='file' name='datei' id='datei'>
        </div>    
        <div class='col-sm-1'>
        </div>
    </div>
    
    <br>
    
    <div class='row'>
        <div class='col-sm-2'>
        </div>
        <div class='col-sm-1'>
            <h4>Name:</h3>
        </div>
        <div class='col-sm-1'>
        </div>
        <div class='col-sm-7'>
            <input type='text' name='donutname' value='$zeile->donutname' />
        </div>
        <div class='col-sm-1'>
        </div>
    </div>
    <br>";

echo "
    <div class='row'>
        <div class='col-sm-2'>
        </div>
        <div class='col-sm-1'>
            <h4>Beschreibung:</h4>
        </div>
        <div class='col-sm-1'>
        </div>
        <div class='col-sm-5'>
            <textarea name='beschreibung' cols='100' rows='4'>$zeile->beschreibung</textarea>
        </div>
        <div class='col-sm-1'>
        </div>
    </div>
    <br>
    ";

echo "
    <div class='row'>
        <div class='col-sm-2'>
        </div>
        <div class='col-sm-1'>
            <h4>Füllung:</h4>
        </div>
        <div class='col-sm-1'>
        </div>
        <div class='col-sm-7'>
        ";

        if ($zeile->fuellung=='Ja') {
            echo "
                <input type='radio' id='Ja' name='fuellung' value='Ja' checked>
                    <label for='Ja'>Ja</label><br>
                <input type='radio' id='Nein' name='fuellung' value='Nein'>
                    <label for='Nein'>Nein</label><br>";
        }
        else {
            echo"
                <input type='radio' id='Ja' name='fuellung' value='Ja'>
                    <label for='Ja'>Ja</label><br>
                <input type='radio' id='Nein' name='fuellung' value='Nein' checked>
            <label for='Nein'>Nein</label><br>";
        }
echo"
        </div>
        <div class='col-sm-1'>
        </div>
    </div>
<br>

    <div class='row'>
        <div class='col-sm-2'>
        </div>
        <div class='col-sm-1'>
            <h4>EAN-Code:</h4>
        </div>
        <div class='col-sm-1'>
        </div>
        <div class='col-sm-7'>
            <input type='text' name='ean' value='$zeile->ean' />
        </div>
        <div class='col-sm-1'>
        </div>
    </div>
    
    <br>
    
    <div class='row'>
        <div class='col-sm-2'>
        </div>
        <div class='col-sm-1'>
            <h4>Preis:</h4>
        </div>
        <div class='col-sm-1'>
        </div>
        <div class='col-sm-7'>
            <input type='text' name='preis' value='$zeile->preis' />
        </div>
        <div class='col-sm-1'>
        </div>
    </div>
    
    <br><br>
    
    <div class='row'>
        <div class='col-sm-2'>
        </div>
        <div class='col-sm-2'>
        </div>
        <div class='col-sm-8'>
            <input class='bearbeitenbutton' type='submit' value='aktualisieren' />
        </div>
    </div>
    
    <br>
    
</form>";
}

else {
        echo "Datensatz nicht gefunden!";
    }
    $db = null;
}
catch (PDOException $e) {
    echo "Error.";
    die();
}

?>