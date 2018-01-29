<?php

include "../../../config.php";
if (!empty($_POST["donutname"]) AND !empty($_POST["beschreibung"]) AND !empty($_POST["fuellung"]) AND !empty($_POST["preis"])) {
    if (empty($_FILES["datei"]["name"])) {
        $dbfile = "";
    }

    if ($_FILES["datei"]["size"] != 0) {
//Bild upload:
        $upload_folder = '/home/ss423/public_html/bilder/'; //Upload-Verzeichnis
        $filename = $_POST["ean"];
        $extension = strtolower(pathinfo($_FILES['datei']['name'], PATHINFO_EXTENSION));

        $allowed_extensions = array('jpg','png','jpeg','gif');
        if (!in_array($extension, $allowed_extensions)) {
            die("Ungültige Dateiendung. Es sind nur png, jpg, jpeg und gif-Dateien erlaubt!");
        }

        $new_path = $upload_folder . $filename . '.' . $extension;

        $dbfile = $filename . '.' . $extension;

        move_uploaded_file($_FILES['datei']['tmp_name'], $new_path);
    }

    $stmt = $db->prepare("INSERT INTO artikel (donutname, beschreibung, preis, ean, fuellung, ende) 
VALUES (:donutname, :beschreibung, :preis, :ean, :fuellung, :ende)");

    $stmt->bindParam(":donutname", $_POST["donutname"]);
    $stmt->bindParam(":beschreibung", $_POST["beschreibung"]);
    $stmt->bindParam(":preis", $_POST["preis"]);
    $stmt->bindParam(":ean", $_POST["ean"]);
    $stmt->bindParam(":fuellung", $_POST["fuellung"]);
    $stmt->bindParam(":ende", $extension);

    if (!$stmt->execute()) {
        echo "<br>Es ist ein Fehler aufgetreten.
        <br> Bitte versuchen Sie es nocheinmal!";
        $arr = $stmt->errorInfo();
        print_r($arr);
        die();
    }
}
else {
    echo "<br>Es ist ein Fehler aufgetreten.
    <br> Bitte versuchen Sie es nocheinmal!";

}
header('Location: ../admin.php?page=donut');
