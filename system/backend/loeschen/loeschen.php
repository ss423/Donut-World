<?php

try {
    include "../../config.php";
$stmt = $db->prepare("SELECT * FROM artikel WHERE id=".$_GET["id"]);
$stmt->execute();
if ($zeile = $stmt->fetchObject()) {
    $id=$zeile->id;

    echo "
        <div class='row'>
           <div class='col-sm-12' id='donutsbearbeiten'>
                <br>
                <h1>Donut löschen</h1>  
           </div>
        </div>
        
        <br><br>";

    echo "
        <div class='row'> <!--Abfrage ob man löschen will-->
            <div class='col-sm-2'>
            </div>
            <div class='col-sm-8'>
                 <br>
                 <h2 style='text-align: center;'>Soll dieser Eintrag wirklich gelöscht werden?</h2>
            </div>
         </div>
        
        <br><br>
        
        <div class='row loeschenumrandung'>
         <div class='col-sm-1'> </div>
            <div class='col-sm-3'>
                <img src='../../bilder/".$zeile->ean.".".$zeile->ende."' width='100%' class='img-responsive' alt='Bild: ".$zeile->donutname."' title='".$zeile->donutname."'>
            </div>
           
            <div class='col-sm-8'>
                <div class='row'>
                    <div class='col-sm-12'>
                        <br>
                    </div>
                </div>
                
                <div class='row'>
                    <div class='col-sm-2'>
                        <h4>Name:</h4>
                    </div>
                    <div class='col-sm-8'>
                        ".$zeile->donutname;
                    echo"
                    </div>
                    <div class='col-sm-2'>
                    </div>
                </div>
                
                <div class='row'>
                    <div class='col-sm-2'>
                        <h4>Beschreibung:</h4>
                    </div>
                    <div class='col-sm-8'>
                        ".$zeile->beschreibung;
                    echo"
                    </div>
                    <div class='col-sm-2'>
                    </div>
                </div>
                
                <div class='row'>
                    <div class='col-sm-2'>
                        <h4>Füllung:</h4>
                    </div>
                    <div class='col-sm-8'>
                        ".$zeile->fuellung;
                    echo"
                    </div>
                    <div class='col-sm-2'>
                    </div>
                </div>
                
                <div class='row'>
                    <div class='col-sm-2'>
                        <h4>EAN-Code:</h4>
                    </div>
                    <div class='col-sm-8'>
                        ".$zeile->ean;
                    echo"
                    </div>
                    <div class='col-sm-2'>
                    </div>
                </div>   
                
                <div class='row'>
                    <div class='col-sm-2'>
                        <h4>Preis</h4>
                    </div>
                    <div class='col-sm-8'>
                        ".$zeile->preis."€";
                    echo"
                    </div>
                    <div class='col-sm-2'>
                    </div>
                </div>  
                
            </div>
        </div>
        
        <div class='row'>
            <div class='col-sm-12'>
            </div>
        </div>
        
        <br><br>
        ";

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



//bezieht sich wieder nur auf einen Datensatz, hier hole ich mir die ID
echo "
      <div class='row'>
            <div class='col-sm-5'>
            </div>
            <div class='col-sm-1'>
                <a href='admin.php?page=loeschen2&id=".$id."'><button class='loeschenbutton'>Löschen</button></a>
            </div>
            <div class='col-sm-1'>
                <a href='admin.php?page=donut'><button class='loeschenbutton'>Abbrechen</button></a>
            </div>
            <div class='col-sm-5'>
            </div>
      </div> 
      
      <br><br><br>
";              //Wenn ja, dann Verweis auf delete 2 //Bei nein, Verweis auf Startseite
echo"
</body>
</html>";
?>