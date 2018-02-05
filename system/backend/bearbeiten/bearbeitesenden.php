<?php

$id = htmlspecialchars($_POST["id"], ENT_QUOTES, "UTF-8");
$donutname = htmlspecialchars($_POST["donutname"], ENT_QUOTES, "UTF-8");
$beschreibung = htmlspecialchars($_POST["beschreibung"], ENT_QUOTES, "UTF-8");
$fuellung = htmlspecialchars($_POST["fuellung"], ENT_QUOTES, "UTF-8");
$ean = htmlspecialchars($_POST["ean"], ENT_QUOTES, "UTF-8");
$preis = htmlspecialchars($_POST["preis"], ENT_QUOTES, "UTF-8");

if (!empty($donutname) && !empty($beschreibung) && !empty($fuellung) && !empty($ean) && !empty($preis)) {
    try {
        include "../../config.php";

        if (empty($_FILES["datei"]["name"])) { //kein Bild vorhanden = nichts speichern
            $dbfile = "";
        }

        if ($_FILES["datei"]["size"] != 0) { //Dateigröße > 0 --> bild hochgeladen

            $upload_folder = '/home/ss423/public_html/bilder/'; //Upload-Verzeichnis
            $filename = $_POST["ean"]; //Dateiname = EAN Nummer
            $extension = strtolower(pathinfo($_FILES['datei']['name'], PATHINFO_EXTENSION));

            $allowed_extensions = array('jpg','png','jpeg','gif');
            if (!in_array($extension, $allowed_extensions)) {
                die("Ungültige Dateiendung. Es sind nur png, jpg, jpeg und gif-Dateien erlaubt!");
            }

            $new_path = $upload_folder . $filename . '.' . $extension; //Pfad wird gesetzt

            move_uploaded_file($_FILES['datei']['tmp_name'], $new_path); //speicherung
        }
        if ($extension==''){
            $extension=$_POST['ende'];
        }
        $stmt = $db->prepare(
            "UPDATE artikel SET donutname=:donutname, beschreibung=:beschreibung, fuellung=:fuellung, /*platzhalter*/
            ean=:ean, preis=:preis, ende=:ende WHERE id=:id");
        $stmt->execute(array("donutname"=>$donutname, "beschreibung"=>$beschreibung, "fuellung"=>$fuellung,
            "ean"=>$ean, "preis"=>$preis, "id"=>$id, "ende"=>$extension));
        $db = null;
        header('Location: admin.php?page=donut');
    }
    catch (PDOException $e) {
        echo "<br>
            Error......";
        die();
    }
}

else {
    echo"<br>";
    echo "Bitte alle Felder ausfüllen!";
}