<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>Donut World Nutzer hinzufügen</title>
    <link rel='stylesheet' type='text/css' href='../../style.css' media='screen'>
</head>

<body>
<div class='nutzererstellung'>
    <div class="row">
        <div class="col-sm-12">
            <div class="accountheader">
                <br>
                <h1>Nutzer hinzufügen</h1>
            </div>
        </div>
    </div>

    <br><br>

        <form method="post" action="admin.php?=page=nutzererstellung">

            <?php echo display_error(); ?>


<div class="row">
    <div class="col-sm-2">
    </div>
    <div class="col-sm-7">
        <div class="nutzererstellungformular">

            <div class="row">
                <div class='input-group'>
                    <div class="col-sm-6">
                        <label>Vorname</label> <br>
                        <input type='text' name='vorname' placeholder='Vorname' value='<?php echo $vorname; ?>'>              <!--$variablen sind in function.php definiert -->
                    </div>
                    <div class="col-sm-6">
                        <label>Nachname</label> <br>
                        <input type='text' name='nachname' placeholder='Nachname' value='<?php echo $nachname; ?>'>
                    </div>
                </div>
            </div>

            <br>


            <div class="row">
                <div class='input-group'>
                    <div class="col-sm-6">
                        <label>Straße</label> <br>
                        <input type='text' name='straße' placeholder='Straße' value='<?php echo $straße; ?>'>
                    </div>
                    <div class="col-sm-6">
                        <label>Hausnummer</label> <br>
                        <input type='text' name='hausnummer' placeholder='Hausnummer' value='<?php echo $hausnummer; ?>'>
                    </div>
                </div>
            </div>

            <br>

            <div class="row">
                <div class='input-group'>
                    <div class="col-sm-6">
                        <label>PLZ</label> <br>
                        <input type='text' name='plz' placeholder='PLZ' value='<?php echo $plz; ?>'>
                    </div>
                    <div class="col-sm-6">
                        <label>Ort</label> <br>
                        <input type='text' name='ort' placeholder='Ort' value='<?php echo $ort; ?>'>
                    </div>
                </div>
            </div>

            <br>

            <div class="row">
                <div class='input-group'>
                    <div class="col-sm-8">
                        <label>E-Mail</label> <br>
                        <input type='email' name='email' placeholder='E-Mail' value='<?php echo $email; ?>'>
                    </div>
                    <div class="col-sm-4">
                        <label>Nutzer Typ <br>
                        <div class="nutzer_typ">
                            <select name='nutzer_typ' size='1' id='nutzer_typ' >
                                <option value=''></option>
                                <option value='admin'>Admin</option>
                                <option value='nutzer'>Nutzer</option>
                            </select>
                        </div>
                        </label>
                    </div>
                </div>
            </div>

            <br>

            <div class="row">
                <div class='input-group'>
                    <div class="col-sm-6">
                        <label>Passwort</label> <br>
                        <input type='password' name='psw_1' placeholder='Passwort'>
                    </div>
                    <div class="col-sm-6">
                        <label>Passwort bestätigen</label> <br>
                        <input type='password' name='psw_2' placeholder='Passwort bestätigen'>
                    </div>
                </div>
            </div>

            <br>

            <br>
            <div class='input-group'>
                <button type='submit' class='rosabutton' name='register_btn'>+ Nutzer hinzufügen</button>
            </div>
            <br>
        </div>
    </div>
    <div class="col-sm-3">
    </div>
</div>

</form>
</div>
</body>
</html>