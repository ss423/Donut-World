<?php

$id = (int)$_GET["id"];

    try {
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




