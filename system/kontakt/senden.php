<?php
$betreff = htmlspecialchars($_POST["betreff"], ENT_QUOTES, "UTF-8");
$email = htmlspecialchars($_POST["email"], ENT_QUOTES, "UTF-8");
$nachricht = htmlspecialchars($_POST["nachricht"], ENT_QUOTES, "UTF-8");


if(isset($_POST['email'])) {

    $email_to = "saskia.spieth@gmx.de";     //Email empfänger

    $email_subject = "Sie haben eine neue Nachricht von Donutworld:";   //Betreff der E-Mail


    if(empty($betreff) && empty($email) && empty($nachricht))
    {

        'Bitte füllen Sie alle Felder aus und probieren Sie es noch einmal';

    }

    $betreff = $_POST['betreff'];

    $email = $_POST['email'];

    $nachricht = $_POST['nachricht'];

    $email_message = "Neue Nachricht von Donutworld.\n\n";


    $email_message .= "E-Mail Adresse: ".$email."\n";

    $email_message .= "Betreff : ".$betreff."\n";

    $email_message .= "Nachricht: ".$nachricht."\n";


    $headers = 'From: '.$email."\r\n".


        @mail($email_to, $email_subject, $email_message, $headers);

    ?>
    <div class="row">
        <div class="col-sm-12" style="text-align: center">
            <br><h3>Vielen Dank für Ihre Nachricht!</h3>
            <h3>Wir werden Ihnen bald schreiben.</h3>
        </div>
    </div>

    <?php

};
