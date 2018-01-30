<?php

session_start();

// Verbindung zur Datenbank
include 'config.php';

// Variablen werden hier definiert
$vorname    = "";
$nachname   = "";
$straße     = "";
$hausnummer = "";
$plz        = "";
$ort        = "";
$email      = "";
$errors     = array();

// Registrier Funktion wird aufgerufen, wenn Registrieren Button geklickt wird
if (isset($_POST['register_btn'])) {
    register();
}

// NUTZER REGISTRIERUNG
function register(){
    //Diese Variablen werden mit dem global Keywort aufgerufen um sie in der Funktion verfügbar zu machen
    global $db, $errors, $vorname, $nachname, $straße, $hausnummer, $plz, $ort, $email;

    //empfange alle Eingabewerte aus dem Formular. Ruft die e () -Funktion auf.
    // unten definiert, um Formularwerte zu umgehen
    $vorname     =  e($_POST['vorname']);
    $nachname    =  e($_POST['nachname']);
    $straße      =  e($_POST['straße']);
    $hausnummer  =  e($_POST['hausnummer']);
    $plz         =  e($_POST['plz']);
    $ort         =  e($_POST['ort']);
    $email       =  e($_POST['email']);
    $passwort_1  =  e($_POST['psw_1']);
    $passwort_2  =  e($_POST['psw_2']);

// Sicherstellung ob alles korrekt ausgefüllt ist
    if (empty($vorname)) {
        array_push($errors, "Vorname wird benötigt");
    }
    if (empty($nachname)) {
        array_push($errors, "Nachname wird benötigt");
    }
    if (empty($straße)) {
        array_push($errors, "Straße wird benötigt");
    }
    if (empty($hausnummer)) {
        array_push($errors, "Hausnummer wird benötigt");
    }
    if (empty($plz)) {
        array_push($errors, "Postleitzahl wird benötigt");
    }
    if (empty($ort)) {
        array_push($errors, "Ort wird benötigt");
    }
    if (empty($email)) {
        array_push($errors, "Email wird benötigt");
    }
    if (empty($passwort_1)) {
        array_push($errors, "Passwort wird benötigt");
    }
    if ($passwort_1 != $passwort_2) {
        array_push($errors, "Die Passwörter stimmen nicht über ein");
    }

// Nutzer Registrieren wenn keine Fehler im Formular sind
    if (count($errors) == 0) {
        $passwort = md5($passwort_1);//Passwort wird verschlüsselt bevor es in der Datenbank angelegt wird

        if (isset($_POST['nutzer_typ'])) {
            $nutzer_typ = e($_POST['nutzer_typ']);
            $query = "INSERT INTO benutzer (vorname, nachname, straße, hausnummer, plz, ort, email, nutzer_typ, psw) 
					  VALUES('$vorname', '$nachname', '$straße', '$hausnummer', '$plz', '$ort', '$email', '$nutzer_typ', '$passwort')";
            mysqli_query($db, $query);
            $_SESSION['erfolgreich']  = "Die Registrierung war erfolgreich!";
            header('location: admin.php?page=nutzererstellung_erfolgreich');
        }else{
            $query = "INSERT INTO benutzer (vorname, nachname, straße, hausnummer, plz, ort, email, nutzer_typ, psw) 
					  VALUES('$vorname', '$nachname', '$straße', '$hausnummer', '$plz', '$ort', '$email', 'nutzer', '$passwort')";
            mysqli_query($db, $query);

            // id vom registrieten Nutzer holen
            $eingeloggte_nutzer_id = mysqli_insert_id($db);

            $_SESSION['nutzer'] = getUserById($eingeloggte_nutzer_id); // mache eingeloggten User in Session
            $_SESSION['erfolgreich']  = "Du bist erfolgreich registriert";
            header('location: ../../index.php');
        }
    }
}

//Benutzer Array von ihrer ID zurückgeben
function getUserById($id){
    global $db;
    $query = "SELECT * FROM benutzer WHERE id=" . $id;
    $result = mysqli_query($db, $query);

    $nutzer = mysqli_fetch_assoc($result);
    return $nutzer;
}

// escape string
function e($val){
    global $db;
    return mysqli_real_escape_string($db, trim($val));
}

function display_error() {        //Bei nicht korrekter Ausfüllung kommt Fehlermeldung (auf diese Funktion wird in register.php zugegriffen)

    global $errors;

    if (count($errors) > 0){
        echo '<div class="error">';
        foreach ($errors as $error){
            echo $error .'<br>';
        }
        echo '</div>';
    }
}


//______________________________________________________________________________________________________________________

//erst zugriff wenn man eingeloggt ist
function isLoggedIn()
{
    if (isset($_SESSION['nutzer'])) {
        return true;
    }else{
        return false;
    }
}

//________________________________________________________________________________________________________________________


// Funktionen fürs Login
if (isset($_POST['login_btn'])) {          //Prüfung ob Variable existiert -> Übergabe des Loginbuttons mit der Methode Post
    login();                                // Wenn man auf Login Button klickt, führe Funktion login() aus.
}

// LOGIN
function login(){           //rufe Funktion Login auf
    global $db, $email, $errors;

    // Werte aus dem Formular erfassen
    $email = e($_POST['email']);                //e = veraltet, Abkürzung für echo?
    $passwort = e($_POST['passwort']);

    // Vergewisserung, dass Formular richtig ausgefüllt ist --> Fehlermeldung
    if (empty($email)) {
        array_push($errors, "<p style='color: red; text-align: center;'>Email wird benötigt</p>");     //Die push Methode fügt Werte an das Ende eines Arrays an.
    }                                                   // $errors oben als leeres array() definiert
    if (empty($passwort)) {
        array_push($errors, "<p style='color: red; text-align: center;'>Passwort wird benötigt</p>");
    }

    //Versuch Login, wenn keine Fehler im Formular
    if (count($errors) == 0) {                  //wenn er keine errors zählt, verschlüssle passwort mit md5
        $passwort = md5($passwort);

        $query = "SELECT * FROM benutzer WHERE email='$email' AND psw='$passwort' LIMIT 1";  //LIMIT muss 1 sein, damit es nur ein Elementt wählt, da für WHERE ...AND... mehrere Elemente in Frage kämen
        $results = mysqli_query($db, $query);           //$results liefert Ergebnismenge  //Die Funktion mysqli_query () führt eine Abfrage für die Datenbank durch.

        if (mysqli_num_rows($results) == 1) { //wenn Nutzer gefunden wurde   //Die Funktion mysqli_num_rows () gibt die Anzahl der Zeilen in einer Ergebnismenge zurück
            // Prüfen ob Admin oder Nutzer
            $eingeloggter_nutzer = mysqli_fetch_assoc($results);        //Die Funktion mysqli_fetch_assoc () ruft eine Ergebniszeile als assoziatives Array ab.
            if ($eingeloggter_nutzer ['nutzer_typ'] == 'admin') {

                $_SESSION['nutzer'] = $eingeloggter_nutzer;        //Wenn der eingeloggte Nutzer ein Admin ist, wird er nach Login in Adminbreeich geleitet
                header('location: ../backend/admin.php');
            }else{
                $_SESSION['nutzer'] = $eingeloggter_nutzer;     //wemm es nutzer ist, wird er auf die index im frontend geleitet
                $_SESSION['erfolgreich']  = "Du bist jetzt eingeloggt";

                header('location: ../../index.php');
            }
        }else {
            array_push($errors, "<p style='color: red;'>Email oder Passwort falsch</p>");      //wenn Errors gezählt wurden, dann kommt Meldung
        }
    }
}

//______________________________________________________________________________________________________________________

// Admin Funktion
function isAdmin()
{
    if (isset($_SESSION['nutzer']) && $_SESSION['nutzer']['nutzer_typ'] == 'admin' ) {
        return true;
    }else{
        return false;
    }
}