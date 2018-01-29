<?php
//erst wenn man eingelogt ist hat man zugriff auf kasse
if (!isLoggedIn()) {
    echo "<h3>Du musst dich erst <a href=system/account/login.php style='color: grey;'>einloggen</a>!</h3>";}
else {

include 'system/account/config.php';


if($warenkorb->artikel_gesamt() <= 0){
    header("Location: index.php?page=weitershoppen");
}


$nutzer_id=$_SESSION['nutzer']['id'];           //UNSERE EIGENE NUTZER ID NEHMEN


$query = $db->query("SELECT * FROM benutzer WHERE id =".$nutzer_id);
$benutzerRow = $query->fetch_assoc();
?>
<?php $bestellungen_id = $db->insert_id;
?>
<body>
<form action="system/warenkorb/warenkorbaktionen.php" method="post">

    <br><br>

    <div class="row">
        <div class="col-sm-6">
            <h2>Lieferadresse</h2><br>
            <p><?php echo $benutzerRow['vorname'], $benutzerRow['nachname']; ?></p>
            <p><?php echo $benutzerRow['straße'], $benutzerRow['hausnummer'];?></p>
            <p><?php echo $benutzerRow['plz'], $benutzerRow['ort'];?></p>
        </div>

        <div class="col-sm-6">
            <h2>Zahlungsinformationen</h2><br>
            <i>*Bitte Zahlungsart auswählen (Infos finden Sie <a href="index.php?page=versandundzahlung" style="color: grey">hier</a>):</i><br>
            <h4><input type="radio" name="zahlungsinfo" value="PayPal">PayPal</h4>
            <h4><input type="radio" name="zahlungsinfo" value="Nachnahme" checked>Nachnahme</h4><br>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-sm-12">
            <h2>Deine Bestellungen</h2>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-3">
            <!--Bild -->
        </div>
        <div class="col-sm-6">
            <h3>Artikel</h3>
        </div>
        <div class="col-sm-1">
            <h3>Preis</h3>
        </div>
        <div class="col-sm-1">
            <h3>Menge</h3>
        </div>
        <div class="col-sm-1">
            <h3>Endpreis</h3>
        </div>
    </div>
    <?php
    if($warenkorb->artikel_gesamt() > 0){

        $warenkorb_artikel = $warenkorb->inhalte();
        foreach($warenkorb_artikel as $artikel){
            ?>
            <div class="row">
                <div class="col-sm-3">
                    <?php
                    echo"
        <img class='img-responsive' src='bilder/".$artikel['ean'].".".$artikel['ende']."' alt='Bild: ".$artikel['donutname']."' title='".$artikel['donutname']."'>   ";?>
                </div>
                <div class="col-sm-6">
                    <?php echo $artikel["donutname"]; ?><br>
                    <?php echo $artikel["beschreibung"]; ?><br>
                </div>
                <div class="col-sm-1">
                    <?php echo '€'.$artikel["preis"].' EURO'; ?>
                </div>
                <div class="col-sm-1">
                    <?php echo $artikel["menge"]; ?>
                </div>
                <div class="col-sm-1">
                    <?php echo '$'.$artikel["summepreis"].' EURO'; ?>
                </div>
            </div>

        <?php } }else{ ?>
        <p>Im Warenkorb sind keine Artikel vorhanden.</p>
    <?php } ?>

    <?php
    if($warenkorb->artikel_gesamt() > 0){ ?>

        <div class="row">
            <div class="col-sm-10">
            </div>
            <div class="col-sm-1">
                <b>Summe:</b>
            </div>
            <div class="col-sm-1">
                <?php echo '€'.$warenkorb->gesamt().' EURO'; ?>
            </div>
        </div>
    <?php } ?>

    <br><br><br>

    <div class="row">
        <div class="col-sm-2">
                <button href="index.php?page=alledonuts" class="produktbutton">Gönn dir noch einen Donut</button>
        </div>
        <div class="col-sm-8">
        </div>
        <div class="col-sm-2">
            <div class="footBtn">
                <button type='submit' class='rosabutton' name='bestellung'>Jetzt Bestellen</button>
            </div>
        </div>
    </div>

</form>
</body>
</html>
<?php } ?>