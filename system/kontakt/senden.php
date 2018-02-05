<?php
$betreff = htmlspecialchars($_POST["betreff"], ENT_QUOTES, "UTF-8");
$email = htmlspecialchars($_POST["email"], ENT_QUOTES, "UTF-8");
$nachricht = htmlspecialchars($_POST["nachricht"], ENT_QUOTES, "UTF-8");


if(isset($_POST['email'])) {    //wenn beim Formular auf submit gedrückt wurde

    $email_to = "saskia.spieth@gmx.de";     //Email empfänger

    $email_subject = "Sie haben eine neue Nachricht von Donutworld:";   //was beim betreff der email steht


    if(empty($betreff) && empty($email) && empty($nachricht))   //wenn Felder Betreff, Email, Nachricht nicht ausgefüllt sind
    {

        'Bitte füllen Sie alle Felder aus und probieren Sie es noch einmal';

    }

    $betreff = $_POST['betreff'];       //Variablen werden durch Post Befehl eingebunden

    $email = $_POST['email'];

    $nachricht = $_POST['nachricht'];

    $email_message = "Neue Nachricht von Donutworld.\n\n";


    $email_message .= "E-Mail Adresse: ".$email."\n"; //Emailadresse wird an Nachricht gehangen

    $email_message .= "Betreff : ".$betreff."\n"; //Betreff

    $email_message .= "Nachricht: ".$nachricht."\n";  //Nachricht


    $headers = 'From: '.$email."\r\n".          //Email Header mit Emailadresse absenders


        @mail($email_to, $email_subject, $email_message, $headers); //verschickt mail

    ?>
    <div class="row">
        <div class="col-sm-12" style="text-align: center">
            <br><h3>Vielen Dank für Ihre Nachricht!</h3>
            <h3>Wir werden Ihnen bald schreiben.</h3>
        </div>
    </div>

    <?php

};
