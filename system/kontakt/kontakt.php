<?php
echo "
<br>
<div class='row'>
    <div class='col-sm-8'>
        <div class='row'>
            <div class='col-sm-12 ueberschrift'>
                <h1>Kontakt</h1>
            </div>
        </div>
        
        <br>
        
        <div class='row'>
            <div class='col-sm-7'>
               <div id='ansprechpartner'>
                    <h2>Ansprechpartner:</h2><br>
                    Theresa Veit - Geschäftsführerin <br>
                    E-Mail: Veit@gmail.com <br><br>
                    Matthias Kainz - Geschäftsführer <br>
                    E-Mail: Kainz@gmail.com <br> <br>
                    Saskia Spieth - Geschäftsführerin <br>
                    E-Mail: Spieth@gmail.com<br>
                </div>
            </div>
            
            <div class='col-sm-5'>
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
        <form name='nachricht' method='post' action='index.php?page=kontaktsenden' > 
        
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
                E-Mail *:
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
    </div>
    
    <br><br><br><br><br>
    
    <div class='col-sm-4'>
            <div id='standort'>
                <iframe src='https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2631.0886948217253!2d9.098570615650566!3d48.74200247927631!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4799dc42026cc05f%3A0xeb88e48af65defde!2sHochschule+der+Medien!5e0!3m2!1sde!2sde!4v1512398576680' width='350' height='250' frameborder='0' style='border:0' allowfullscreen></iframe>
                <br>
                <h4>Unser Produktionsstandort:</h4><br>
                Donut World GmbH <br>
                in der Hochschule der Medien <br>
                Nobelstraße 10 <br>
                70563 Stuttgart-Vaihingen <br>
            </div>
            <div class='row'>
            <div class='col-sm-12'>
            <br>
            </div>
            </div>
            <div id='standort'>
                <iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2629.338374130908!2d9.170611315671442!3d48.7754299792795!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4799db49ad494507%3A0xc2b199b79016fca0!2sFLUXUS+-+Temporary+Concept+Mall!5e0!3m2!1sde!2sde!4v1517303658899\" width='350' height='250' frameborder='0' style='border:0' allowfullscreen></iframe><br>
                <h4>Unsere Filiale:</h4><br>
                Donut World Shop<br>
                in der FLUXUS - Temporary Concept Mall <br>
                Rotebühlplatz 20 <br>
                70173 Stuttgart<br>
           </div>
    </div>
</div>                   


";