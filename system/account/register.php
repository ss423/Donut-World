<?php include('functions.php') ?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>Donut World Registrierung</title>
    <script src='https://code.jquery.com/jquery-3.2.1.min.js'></script> <!--link jquery -->
    <!-- Links bootstrap -->
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' integrity='sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u' crossorigin='anonymous'>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css' integrity='sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp' crossorigin='anonymous'>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js' integrity='sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa' crossorigin='anonymous'></script>

    <link rel='stylesheet' type='text/css' href='../../style.css' media='screen'>
    <link href='https://fonts.googleapis.com/css?family=Amatic+SC' rel='stylesheet'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
</head>


<body>
<div class="row">
    <div class="col-sm-2">
    </div>

    <div class="col-sm-5">
        <div class="registerformular">

            <div class='row'>
                <div class='accountheader'>
                     <div class='col-sm-4'>
                        <h2>Registrieren</h2>
                    </div>

                    <div class='col-sm-5'>
                    </div>

                    <div class='col-sm-3'>
                        <a href='../../index.php'>
                            <img src="../../bilder/logo.png" width="70%" title="Donut World Startseite" id="registerlogo" class="img-responsive" alt="Donut World Logo">
                        </a>
                    </div>
                </div>
            </div>

            <br>
            <br>
             Bitte alle Felder mit * ausfüllen!
            <br>
            <br>
            <br>

            <form method='post' action='register.php'>

                <?php echo display_error(); ?>       <!-- Bei nicht korrekter Ausfüllung kommt Fehlermeldung (diese Funktion ist in functions.php definiert)-->

            <div class='registereingabe'>
                <div class="row">
                    <div class='input-group'>
                        <div class="col-sm-6">
                            <label>Vorname * </label> <br>
                            <input type='text' name='vorname' placeholder="Vorname" style="width: 200px" maxlength="50" value='<?php echo $vorname; ?>'>              <!--$variablen sind in function.php definiert -->
                        </div>
                        <div class="col-sm-6">
                            <label>Nachname * </label> <br>
                            <input type='text' name='nachname' placeholder="Nachname" style="width: 200px" maxlength="50" value='<?php echo $nachname; ?>'>
                        </div>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class='input-group'>
                        <div class="col-sm-6">
                            <label>Straße * </label> <br>
                            <input type='text' name='straße' placeholder="Straße" style="width: 200px" maxlength="50" value='<?php echo $straße; ?>'>
                        </div>
                        <div class="col-sm-6">
                            <label>Hausnummer * </label> <br>
                            <input type='text' name='hausnummer' placeholder="Hausnummer" style="width: 200px" maxlength="50" value='<?php echo $hausnummer; ?>'>
                        </div>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class='input-group'>
                        <div class="col-sm-6">
                            <label>PLZ *</label> <br>
                            <input type='text' name='plz' placeholder="PLZ" style="width: 200px" maxlength="50" value='<?php echo $plz; ?>'>
                        </div>
                            <div class="col-sm-6">
                             <label> Ort *</label> <br>
                            <input type='text' name='ort' placeholder="Ort" style="width: 200px" maxlength="50" value='<?php echo $ort; ?>'>
                        </div>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class='input-group'>
                        <div class="col-sm-12">
                            <label>E-Mail *</label> <br>
                            <input type='email' name='email' placeholder="E-Mail" style="width: 200px" maxlength="50" value='<?php echo $email; ?>'>
                        </div>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class='input-group'>
                        <div class="col-sm-12">
                            <label>Passwort *</label> <br>
                            <input type='password' name='psw_1' placeholder="Passwort" style="width: 200px" maxlength="50">
                        </div>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class='input-group'>
                        <div class="col-sm-12">
                            <label>Passwort bestätigen * </label> <br>
                            <input type='password' name='psw_2' placeholder="Passwort bestätigen" style="width: 200px" maxlength="50">
                        </div>
                    </div>
                </div>

            </div>

                <br>
                <br>
                <div class='registerhinweis'>
                    <div class='row'>
                        <div class='col-sm-11'>
                            (!) Hinweis: Indem du auf „Jetzt registrieren“ klickst, erklärst du dich mit unseren
                            <a href='../../index.php?page=agb'>allgemeinten Geschäfts- und Nutzungsbedingungen</a> einverstanden
                            und bestätigst, dass du unsere <a href='../../index.php?page=datenschutz'>Datenrichtlinie</a>
                            einschließlich unserer <a href='../../index.php?page=datenschutz'>Cookie-Richtlinie</a> gelesen hast.
                            Eventuell erhältst du E-Mail-Benachrichtigungen von Donut World, die du
                            jederzeit abbestellen kannst.
                        </div>
                        <div class='col-sm-1'>
                        </div>
                    </div>
                </div>

                <br>
                <br>

                <div class='input-group'>
                    <button type='submit' class='rosabutton' name='register_btn' title='Jetzt registrieren'>Jetzt registrieren</button>
                </div>

                <br><br>

                <p style='font-size: 95%;'>
                    Schon registriert? <a href='login.php' style='color: grey;'>Hier einloggen</a> <br><br>
                    Zurück zur <a style='color: grey;' href='../../index.php'>Startseite</a>
                </p>
            </form>
        </div>
    </div>
    <div class="col-sm-5">
    </div>
</div>
</body>
</html>
