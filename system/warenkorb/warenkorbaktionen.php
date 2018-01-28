<?php
// warenkorb klasse starten
include 'warenkorb.php';
$warenkorb = new warenkorb;

include '../account/config.php';
if(isset($_GET['action']) && !empty($_GET['action'])) {
    if ($_GET['action'] == 'update_warenkorbartikel' && !empty($_GET['id'])) {
        $artikel_daten = array(
            'rowid' => $_GET['id'],
            'menge' => $_GET['menge']
        );
        $update_artikel = $warenkorb->update($artikel_daten);
        echo $update_artikel ? 'ok' : 'error';
        die;
    } elseif ($_GET['action'] == 'entfernen_warenkorbartikel' && !empty($_GET['id'])) {        //artikel entfernen
        $loeschen_artikel = $warenkorb->entfernen($_REQUEST['id']);
        header("Location: ../../index.php?page=warenkorbansicht");
    } else {
        header("Location: ../../index.php?page=alledonuts");
    }
}




if(isset($_POST['warenkorb'])){
    $artikel_id = $_POST['artikel_id'];
    //Produktdetails abfragen
    $query = $db->query("SELECT * FROM artikel WHERE id = ".$artikel_id); //alle Infos wo Artikel die ID hat
    $row = $query->fetch_assoc();
    $artikel_daten = array(         //Infos mit row rauslesen
        'id' => $row['id'],
        'donutname' => $row['donutname'],
        'preis' => $row['preis'],
        'menge' => $_POST['mengenangabe'],       //festlegen menge --> ändern
        'ean'  => $row['ean'],
        'beschreibung' => $row['beschreibung'],
        'ende' => $row['ende']
    );

    $artikel_einfuegen = $warenkorb->einfuegen($artikel_daten);
    $weiterleiten = $artikel_einfuegen?'../../index.php?page=warenkorbansicht':'../../index.php?page=alledonuts';
    header("Location: ".$weiterleiten);
}else{
    header("Location: ../../index.php?page=alledonuts");
}




if(isset($_POST['bestellung']) && $warenkorb->artikel_gesamt() > 0 && !empty($_SESSION['nutzer']['id'])){  //bestellung aufgeben, wenn warenkorb nicht leer ist und mit nutzer ide
    $bezahlmethode=($_POST['zahlungsinfo']);
        // bestelldaten in DB eintragen
    $bestellung_einfuegen = $db->query("INSERT INTO bestellungen (benutzer_id, bezahlmethode, endpreis, erstellt, bearbeitet) VALUES ('" . $_SESSION['nutzer']['id'] . "', '" . $bezahlmethode . "', '" . $warenkorb->gesamt() . "', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d H:i:s") . "')");
    // wenn bestelldaten eingefügt wurden, artikel daten einfügen
    if ($bestellung_einfuegen) {
        $bestellungen_id = $db->insert_id;
        $sql = '';

        $warenkorb_artikel = $warenkorb->inhalte();
        foreach ($warenkorb_artikel as $artikel) {
            $sql .= "INSERT INTO bestellte_artikel (id, bestellungen_id, artikel_id, menge) VALUES ('', '" . $bestellungen_id . "', '" . $artikel['id'] . "', '" . $artikel['menge'] . "');";
        }
        // bestellte artikel in datenbank einfügen
        $bestellte_artikel_einfuegen = $db->multi_query($sql);

        if ($bestellte_artikel_einfuegen) {
            $warenkorb->destroy();
            header("Location: ../../index.php?page=bestellung_erfolgreich&id=$bestellungen_id");
        } else {
            header("Location: ../../index.php?page=zurkasse");
        }
    } else {
        header("Location: ../../index.php?page=zurkasse");
    }
}