<?php
echo "
<br>
<div class='row'>
    <div class='col-sm-12 kontakt'>
        <h1>Kontakt</h1>
    </div>
</div>

<br>

<div class='row'>
    <div class='col-sm-6'>
        <div id='adresse'>
            <h2>Adresse:</h2><br>
            <h4>Donut World GmbH </h4>
            Geschäftsführer: T. Veit, M. Kainz, S. Spieth <br>
            Nobelstraße 10 <br>
            70563 Stuttgart-Vaihingen <br>
            Telefonnummer: 07 11 / 60 50 30 <br>
            E-Mail-Adresse: DonutWorld@gmail.com <br>
        </div>
    </div>
    <div class='col-sm-6'>
        <div id='ansprechpartner'>
            <h2>Ansprechpartner:</h2><br>
            Theresa Veit Geschäftsführerin <br>
            E-Mail: Veit@gmail.com <br><br>
            Matthias Kainz - Geschäftsführer <br>
            E-Mail: Kainz@gmail.com <br> <br>
            Saskia Spieth - Geschäftsführerin <br>
            E-Mail: Spieth@gmail.com<br>
        </div>
    </div>
</div>

<br><br><br>

<div class='row'>
    <div class='col-sm-8'>
        <div id='nachricht'>
            <h2>Schreiben Sie uns eine Nachricht</h2><br>
        </div>
    </div>
    <div class='col-sm-4'>
    </div>    
</div>
<form name='nachricht' method='post' action='index.php?page=kontaktsenden' > <!--Kontaktformular über post -->

<div class='row'>
    <div class='col-sm-2'>
        Betreff *:
    </div>
    <div class='col-sm-8'>
        <input type='text' name='betreff' maxlength='50' size='30' placeholder='Betreff'>
    </div>
    <div class='col-sm-2'>
    </div>
</div>

<br>

<div class='row'>
    <div class='col-sm-2'>
        E-Mail-Adresse *:
    </div>
    <div class='col-sm-8'>
        <input type='text' name='email' maxlength='80' size='30' placeholder='E-Mail'>
    </div>
    <div class='col-sm-2'>
    </div>
</div>

<br>

<div class='row'>
    <div class='col-sm-2'>
        Nachricht *:
    </div>
    <div class='col-sm-8'>
    <textarea name='nachricht' maxlength='1000' cols='70' rows='6' placeholder='Nachricht schreiben...'></textarea>
    </div>
    <div class='col-sm-2'>
    </div>
</div>

<br>

<div class='row'>
    <div class='col-sm-2'>
    </div>
    <div class='col-sm-10'>
        <input type='submit' value='senden' class='bearbeitenbutton'>
    </div>
</div>
</form>
                
                      


";