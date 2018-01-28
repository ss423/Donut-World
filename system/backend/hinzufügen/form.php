<?php
echo "
    <div class='row'>
       <div class='col-sm-12' id='donutsbearbeiten'>
            <br>
            <h1>Donut hinzufügen</h1>  
       </div>
    </div>
<br><br>

<div id='neu'>    <!-- Produktformular um Produkt hinzuzufügen -->
    <form name='uploadformular' action='hinzufügen/hinzufügen.php' method='post'   
        enctype='multipart/form-data'> <!--da bild auch hinzugefügt werden kann -->
        
        <div class='row'>
            <div class='col-sm-2'>
            </div>
            <div class='col-sm-1'>
                <h4>Donutname:</h4>
            </div>
            <div class='col-sm-1'>
            </div>
            <div class='col-sm-8'>
                <input type='text' name='donutname' size='40' maxlength='100' placeholder='Donutname' ><br>
            </div>
        </div>
        
        <div class='row'>
            <div class='col-sm-2'>
            </div>
            <div class='col-sm-1'>
                <h4>Beschreibung:</h4>
            </div>
            <div class='col-sm-1'>
            </div>
            <div class='col-sm-8'>
                <textarea rows='10' cols='80' name='beschreibung' placeholder='Beschreibung...'></textarea>
            </div>
        </div>
        
        <div class='row'>
            <div class='col-sm-2'>          
            </div>
            <div class='col-sm-1'>
                <h4>Preis:</h4>
            </div>
            <div class='col-sm-1'>
            </div>
            <div class='col-sm-8'>
                <input type='text' name='preis' size='20' maxlength='100' placeholder='Preis'>
            </div>
        </div>
        
        <div class='row'>
            <div class='col-sm-2'>
            </div>
            <div class='col-sm-1'>
                <h4>EAN-Code:</h4>
            </div>
            <div class='col-sm-1'>
            </div>
            <div class='col-sm-8'>
                <input type='text' name='ean' size='20' maxlength='100' placeholder='EAN-Code'>
            </div>
        </div>
        
        <div class='row'>
            <div class='col-sm-2'>
            </div>
            <div class='col-sm-1'>
                <h4>Füllung:</h4>
            </div>
            <div class='col-sm-1'>
            </div>
            <div class='col-sm-8'>
                    <input type='radio' id='Ja' name='fuellung' value='Ja'>
                        <label for='Ja'>Ja</label>
                    <input type='radio' id='Nein' name='fuellung' value='Nein'>
                        <label for='Nein'>Nein</label>
            </div>
        </div>
        
        <div class='row'>
            <div class='col-sm-2'>       
            </div>
            <div class='col-sm-1'>
                <h4>Bild:</h4>
            </div>
            <div class='col-sm-1'>
            </div>
            <div class='col-sm-8'>
                <input type='file' name='datei' id='datei'>
                <small>(Nur .jpg-Dateien sind erlaubt!)</small>
            </div>
        </div>
        
        <div class='row'>
            <div class='col-sm-2'>
            </div>
            <div class='col-sm-2'>
            </div>
            <div class='col-sm-8'>
                <br>
                <input class='bearbeitenbutton' type='submit' value='+ hinzufügen'>
                <br><br><br>
            </div>
        </div>
        
    </form>
</div>
";
