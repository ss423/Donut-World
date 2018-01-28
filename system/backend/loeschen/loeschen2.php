<?php

$id = (int)$_GET["id"];

try {                                           //es versuchts, wenn aber Fehler auftritt, führts zum Catchblock, try überwacht mögliche Fehler
    include_once("../../config.php");
    $stmt = $db->prepare("DELETE FROM artikel WHERE id=".$id);
    $stmt->execute();
    $db = null;
    header('Location: admin.php?page=donut');
}

catch (PDOException $e) {
    echo "<br>Es ist ein Fehler aufgetreten.
    <br> Bitte versuchen Sie es nocheinmal!";
    die();
}
      //nach der Ausführung führts sofort zur index seite zurück



