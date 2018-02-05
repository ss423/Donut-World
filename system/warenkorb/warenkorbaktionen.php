<?php
include 'warenkorb.php';  // warenkorb klasse starten
$warenkorb = new warenkorb;  //erzeugt neues Objekt "Warebnkorb"

include '../../config.php';


if(isset($_GET['action'])) {
    if ($_GET['action'] == 'update_warenkorbartikel') {
        $artikel_daten = array(
            'rowid' => $_GET['id'],
            'menge' => $_GET['menge']
        );
        $update_artikel = $warenkorb->update($artikel_daten);
        echo $update_artikel ? 'ok' : 'error';
        die;
    } elseif ($_GET['action'] == 'entfernen_warenkorbartikel') {
        $loeschen_artikel = $warenkorb->entfernen($_GET['id']);
        header("Location: ../../index.php?page=warenkorbansicht");
    } else {
        header("Location: ../../index.php?page=alledonuts");
    }
}

if(isset($_POST['warenkorb'])){
    $artikel_id = $_POST['artikel_id'];  //für artikel_id wird die jeweilige $row["id"] des donuts übergeben
    //Produktdetails abfragen
    $stmt = $db->prepare("SELECT * FROM artikel WHERE id = ".$artikel_id); //alle Infos des Artikels mit der jeweiligen id rauslesen
    if(!$stmt->execute()) {
        echo "Datenbank-Fehler ";
        $arr = $stmt->errorInfo();
        print_r($arr);
        die();
    }
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {    //gibt ein array indiziert mit dem jeweiligen spaltennamen raus
        $artikel_daten = array(         //Infos mit row rauslesen und dem array übergeben
            'id' => $row['id'],
            'donutname' => $row['donutname'],
            'preis' => $row['preis'],
            'menge' => $_POST['mengenangabe'],       //menge wird über post von vorheriger seite reingezogen
            'ean' => $row['ean'],
            'beschreibung' => $row['beschreibung'],
            'ende' => $row['ende']
        );
    }
    $artikel_einfuegen = $warenkorb->einfuegen($artikel_daten);    //aufruf der methode "einfuegen" um die artkel daten in das objekt "wsrenkorb" einzufügen
    $weiterleiten = $artikel_einfuegen?'../../index.php?page=warenkorbansicht':'../../index.php?page=alledonuts';  //wenn artikel_eingefuegen TRUE , dann warenkorbansicht sonst bei FALSE alledonuts
    header("Location: ".$weiterleiten);
}else{
    header("Location: ../../index.php?page=alledonuts");
}


if(isset($_POST['bestellung']) && $warenkorb->artikel_gesamt() > 0 && !empty($_SESSION['nutzer']['id'])){  //bestellung aufgeben, wenn warenkorb nicht leer ist und mit nutzer id
    $bezahlmethode=($_POST['zahlungsinfo']);
        // bestelldaten in DB eintragen
    $bestellung_einfuegen = $db->prepare("INSERT INTO bestellungen (benutzer_id, bezahlmethode, endpreis, erstellt, bearbeitet) VALUES (:benutzer_id, :bezahlmethode, :endpreis, :erstellt, :bearbeitet)");

    $bestellung_einfuegen->bindParam(":benutzer_id",$_SESSION['nutzer']['id'] );
    $bestellung_einfuegen->bindParam(":bezahlmethode",$bezahlmethode );
    $bestellung_einfuegen->bindParam(":endpreis",$warenkorb->gesamt() );
    $bestellung_einfuegen->bindParam(":erstellt",date("Y-m-d H:i:s") );
    $bestellung_einfuegen->bindParam(":bearbeitet",date("Y-m-d H:i:s") );

    if(!$bestellung_einfuegen->execute()) {
        echo "Datenbank-Fehler ";
        $arr = $bestellung_einfuegen->errorInfo();
        print_r($arr);
        die();
    }
    // wenn bestelldaten eingefügt wurden, artikel daten einfügen
    if ($bestellung_einfuegen) {
        $bestellungen_id = $db->lastInsertId();  //gibt zuletzt hinzugefügte id der bestellung aus (die wurde durch auto increment vorher vergeben)
        $sql = '';

        $warenkorb_artikel = $warenkorb->inhalte();
        foreach ($warenkorb_artikel as $artikel) {
            $bestellte_artikel_einfuegen = $db->prepare("INSERT INTO bestellte_artikel (bestellungen_id, artikel_id, menge) VALUES (:bestellungen_id, :artikel_id, :menge)");

            $bestellte_artikel_einfuegen->bindParam(":bestellungen_id", $bestellungen_id);
            $bestellte_artikel_einfuegen->bindParam(":artikel_id", $artikel['id']);
            $bestellte_artikel_einfuegen->bindParam(":menge", $artikel['menge']);

            if (!$bestellte_artikel_einfuegen->execute()) {
                echo "Datenbank-Fehler ";
                $arr = $bestellte_artikel_einfuegen->errorInfo();
                print_r($arr);
                die();
            }

            if ($bestellte_artikel_einfuegen) {
                $warenkorb->destroy();
                header("Location: ../../index.php?page=bestellung_erfolgreich&id=$bestellungen_id");
            } else {
                header("Location: ../../index.php?page=zurkasse");
            }
        }
    } else {
        header("Location: ../../index.php?page=zurkasse");
    }
}