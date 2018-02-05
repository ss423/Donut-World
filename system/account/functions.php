<?php

session_start();

include '../../config.php';

// Definition Variablen
$vorname    = "";
$nachname   = "";
$straße     = "";
$hausnummer = "";
$plz        = "";
$ort        = "";
$email      = "";
$errors     = array();


if (isset($_POST['register_btn'])) {
    register();
}

// NUTZER REGISTRIERUNG
function register(){

    global $db, $errors, $vorname, $nachname, $straße, $hausnummer, $plz, $ort, $email;

    $vorname     =  ($_POST['vorname']);
    $nachname    =  ($_POST['nachname']);
    $straße      =  ($_POST['straße']);
    $hausnummer  =  ($_POST['hausnummer']);
    $plz         =  ($_POST['plz']);
    $ort         =  ($_POST['ort']);
    $email       =  ($_POST['email']);
    $passwort_1  =  ($_POST['psw_1']);
    $passwort_2  =  ($_POST['psw_2']);

// Prüfung Korrektheit der Eingaben
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

// Nutzer Registrieren wenn fehlerfrei
    if (count($errors) == 0) {
        $passwort = md5($passwort_1);       //Passwortverschlüsselung

        if (isset($_POST['nutzer_typ'])) {
            $nutzer_typ = ($_POST['nutzer_typ']);
            $stmt = $db->prepare ("INSERT INTO benutzer (vorname, nachname, straße, hausnummer, plz, ort, email, nutzer_typ, psw) 
					  VALUES('$vorname', '$nachname', '$straße', '$hausnummer', '$plz', '$ort', '$email', '$nutzer_typ', '$passwort')");
            if(!$stmt->execute()) {
                echo "Datenbank-Fehler ";
                $error = $stmt->errorInfo();
                print_r($error);
                die();
            }
            $_SESSION['erfolgreich']  = "Die Registrierung war erfolgreich!";
            header('location: admin.php?page=nutzererstellung_erfolgreich');
        }else{
            $stmt = $db->prepare ("INSERT INTO benutzer (vorname, nachname, straße, hausnummer, plz, ort, email, nutzer_typ, psw) 
					  VALUES('$vorname', '$nachname', '$straße', '$hausnummer', '$plz', '$ort', '$email', 'nutzer', '$passwort')");
            if(!$stmt->execute()) {
                echo "Datenbank-Fehler ";
                $error = $stmt->errorInfo();
                print_r($error);
                die();
            }

            $eingeloggte_nutzer_id = $db -> lastInsertId();

            $_SESSION['nutzer'] = getUserById($eingeloggte_nutzer_id);
            $_SESSION['erfolgreich']  = "Du bist erfolgreich registriert";
            header('location: ../../index.php?page=register_erfolgreich');
        }
    }
}

// Automatisches Einloggen nach Registrierung
function getUserById($id){
    global $db;
    $stmt = $db->prepare ("SELECT * FROM benutzer WHERE id=" . $id);
    if(!$stmt->execute()) {
        echo "Datenbank-Fehler ";
        $error = $stmt->errorInfo();
        print_r($error);
        die();
    }

    $nutzer = $stmt->fetch(PDO::FETCH_ASSOC);
    return $nutzer;
}


// Fehlermeldung
function display_error() {

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

// Erst Zugriff, wenn man eingeloggt ist
function isLoggedIn()
{
    if (isset($_SESSION['nutzer'])) {
        return true;
    }else{
        return false;
    }
}

//________________________________________________________________________________________________________________________



if (isset($_POST['login_btn'])) {
    login();
}

// LOGIN
function login(){
    global $db, $email, $errors;

    $email = ($_POST['email']);
    $passwort = ($_POST['passwort']);

    // Prüfung Korrektheit der Eingaben
    if (empty($email)) {
        array_push($errors, "<div style='color: red; text-align: center;'>Email wird benötigt</div>");
    }
    if (empty($passwort)) {
        array_push($errors, "<div style='color: red; text-align: center;'>Passwort wird benötigt</div>");
    }

    // Nutzer Login wenn fehlerfrei
    if (count($errors) == 0) {
        $passwort = md5($passwort);

        $stmt = $db->prepare ("SELECT * FROM benutzer WHERE email='$email' AND psw='$passwort' LIMIT 1");

        if(!$stmt->execute()) {
            echo "Datenbank-Fehler ";
            $error = $stmt->errorInfo();
            print_r($error);
            die();
        }

        if (count($stmt) == 1) {
            // Prüfen ob Admin oder Nutzer
            $eingeloggter_nutzer = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($eingeloggter_nutzer ['nutzer_typ'] == 'admin') {

                $_SESSION['nutzer'] = $eingeloggter_nutzer;
                header('location: ../backend/admin.php');
            }else{
                $_SESSION['nutzer'] = $eingeloggter_nutzer;
                $_SESSION['erfolgreich']  = "Du bist jetzt eingeloggt";

                header('location: ../../index.php');
            }
        }else {
            array_push($errors, "<p style='color: red;'>Email oder Passwort falsch</p>");
        }
    }
}

//______________________________________________________________________________________________________________________

// Zugriff, wenn man Admin ist
function isAdmin()
{
    if (isset($_SESSION['nutzer']) && $_SESSION['nutzer']['nutzer_typ'] == 'admin' ) {
        return true;
    }else{
        return false;
    }
}