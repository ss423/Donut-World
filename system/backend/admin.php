<?php include('../account/functions.php');

if (!isAdmin()) {           //nur admin hat zugriff auf admin.php
    header('location: ../account/login.php');
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['nutzer']);
    header("location: ../account/login.php");
}
?>
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>Donut World Admin</title>
    <script src='https://code.jquery.com/jquery-3.2.1.min.js'></script> <!--link jquery -->
    <!-- Links bootstrap -->
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' integrity='sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u' crossorigin='anonymous'>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css' integrity='sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp' crossorigin='anonymous'>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js' integrity='sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa' crossorigin='anonymous'></script>

    <link rel='stylesheet' type='text/css' href='../../style.css' media='screen'>  <!-- link CSS -->
    <link href='https://fonts.googleapis.com/css?family=Amatic+SC' rel='stylesheet'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
</head>

<body>
    <div class='row'>
        <div class='col-sm-12'>
            <img class='img-responsive' src='../../bilder/titel1.jpg' id='titelbild' alt="Titelbild1">
        </div>
    </div>

    <br>

    <div class='row'>
        <div class='col-sm-1'>
            <a href='../../index.php'>
                <img class='img-responsive' src='../../bilder/logo.png' alt='Logo Donut World' width='70%px' id='logo'/>
            </a>
        </div>

        <?php if (isset($_SESSION['erfolgreich'])) : ?>
            <div class="error erfolgreich" >
                <h3>
                    <?php
                    echo $_SESSION['erfolgreich'];
                    unset($_SESSION['erfolgreich']);
                    ?>
                </h3>
            </div>
        <?php endif ?>

        <div class='col-sm-10'>
            <div class="row">
                <div class="col-sm-12">
                    <div id='profil_info'>

                    <?php  if (isset($_SESSION['nutzer'])) : ?>
                        <strong><?php echo $_SESSION['nutzer']['vorname']; ?></strong>

                        <small>
                            <i>(<?php echo ucfirst($_SESSION['nutzer']['nutzer_typ']); ?>)</i>
                        </small>
                    <?php endif ?>
                    </div>
                </div>
            </div>
            <div class='row'>
                <div class="col-sm-4">
                </div>
                <div class='col-sm-4'>
                    <a href='../../index.php'>
                        <img src='../../bilder/titelschrift.png' alt='Donut World' title='Donut World' width='90%'>
                    </a>
                </div>
                <div class="col-sm-4">
                </div>
            </div>
            </div>

        <div class='col-sm-1'>
            <a href="admin.php?logout='1'">LOGOUT</a>
        </div>
    </div>

        <div class='row'>
            <div class='col-sm-12'>
                <img class='img-responsive' src='../../bilder/titel2.jpg' id='titelbild' alt="Titelbild2">
            </div>
        </div>

    <div class='row'>
        <div id='navi'>
            <ul>
                <div class='col-sm-4'>
                    <li><a href='admin.php?page=bestelluebersicht'>BESTELLÜBERSICHT</a></li>
                </div>
                <div class='col-sm-4'>
                    <li><a href='admin.php?page=donut'>PRODUKTE BEARBEITEN</a></li>
                </div>
                <div class='col-sm-4'>
                    <li><a href='admin.php?page=nutzererstellung'>NUTZER HINZUFÜGEN</a></li>
                </div>
            </ul>
        </div>
    </div>

</body>
</html>


<?php

echo" <div class='layout'>";
    if (isset($_GET["page"]) ) {
        switch ($_GET["page"]) {
            case "bestelluebersicht":
                include "bestelluebersicht/bestelluebersicht2.php";
                break;
            case "donut":
                include "donuts.php";
                break;
            case "nutzererstellung":
                include "../account/nutzererstellung.php";
                break;
            case "nutzererstellung_erfolgreich":
                include "../account/nutzererstellung_erfolgreich.php";
                break;
            case "bearbeiten":
                include "bearbeiten/bearbeiten2.php";
                break;
            case "hinzufuegen":
                include "hinzufügen/form.php";
                break;
            case "hinzufuegenfehler":
                include "hinzufügen/hinzufügen.php";
                break;
            case "loeschen":
                include "loeschen/loeschen.php";
                break;
            case "loeschen2":
                include "loeschen/loeschen2.php";
                break;
            case "bearbeitesenden":
                include "bearbeiten/bearbeitesenden.php";
                break;
            default:
                include "bestelluebersicht/bestelluebersicht2.php";
                break;
        }}
    else
    {
        include "bestelluebersicht/bestelluebersicht2.php";
    }

echo"</div>";
?>