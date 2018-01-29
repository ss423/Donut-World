

<body>
<script>
    function update_warenkorbartikel(obj,id){
        $.get("system/warenkorb/warenkorbaktionen.php", {action:"update_warenkorbartikel", id:id, menge:obj.value}, function(daten){
            if(daten == 'ok'){
                location.reload();
            }else{
                alert('Aktualisieren des Warenkorbs fehlgeschlagen, bitte versuche es erneut.');
            }
        });
    }
</script>

<br>
<div class="row">
    <div class="col-sm-12">
        <h1>Mein Warenkorb</h1>
    </div>
</div>

<br><br>

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

<br>

<?php
if($warenkorb->artikel_gesamt() > 0){
    //Warenkoarbartikel von der Session rauslesen
    $warenkorb_artikel = $warenkorb->inhalte();
    foreach($warenkorb_artikel as $artikel){
        ?>
        <div class="row">
            <div class="col-sm-3">
                <?php
                echo"
        <img class='img-responsive' src='bilder/".$artikel['ean'].".".$artikel['ende']."' width='70%' alt='Bild: ".$artikel['donutname']."' title='".$artikelt['donutname']."'>   ";?>      <!-- Bild auslesen -->
            </div>
            <div class="col-sm-6">
                <?php echo "<h3>".$artikel["donutname"]."</h3><br>"; ?>
                <?php echo $artikel["beschreibung"]."<br>"; ?><br>
                <a href="system/warenkorb/warenkorbaktionen.php?action=entfernen_warenkorbartikel&id=<?php echo $artikel["rowid"]; ?>" class="btn btn-danger" onclick="return confirm('Bist du sicher?')"><i class="glyphicon glyphicon-trash"></i></a>
            </div>
            <div class="col-sm-1">
                <?php echo '<br>'.$artikel["preis"].' EURO'; ?>
            </div>
            <div class="col-sm-1"><br>
                <input type="number" class="form-control text-center" value="<?php echo $artikel["menge"]; ?>" onchange="update_warenkorbartikel(this, '<?php echo $artikel["rowid"]; ?>')">
            </div>
            <div class="col-sm-1"><br>
                <?php echo '€'.$artikel["summepreis"].' EURO'; ?>
            </div>
        </div>

    <?php } }else{ ?>
    <p>Dein Warenkorb ist leer.</p>
<?php } ?>

<div class="row">
    <div class="col-sm-10">
    </div>
    <div class="col-sm-1">
        <b>Summe:</b>
    </div>
    <div class="col-sm-1">
        <?php if($warenkorb->artikel_gesamt() > 0){ ?>
            <?php echo '€'.$warenkorb->gesamt().' EURO'; ?>
        <?php } ?>
    </div>
</div>

<br><br><br>

<div class="row">
    <div class="col-sm-2">
        <form>
            <input type='button' class='produktbutton' name='login_btn' onclick="window.location.href='index.php?page=alledonuts'" value='Gönn Dir noch einen Donut'/>
        </form>
    </div>
    <div class="col-sm-8">
    </div>
    <div class="col-sm-2">
        <form>
            <input type='button' class='rosabutton' name='login_btn' onclick="window.location.href='index.php?page=zurkasse'" value='Zur Kasse'/>
        </form>
    </div>
</div>

</body>
</html>