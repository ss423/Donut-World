<?php
include 'system/warenkorb/warenkorb.php';
$warenkorb = new warenkorb;
echo"
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>Donut World</title>
    <script src='https://code.jquery.com/jquery-3.2.1.min.js'></script> <!--link jquery -->
    <!-- Links bootstrap -->
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' integrity='sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u' crossorigin='anonymous'>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css' integrity='sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp' crossorigin='anonymous'>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js' integrity='sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa' crossorigin='anonymous'></script>
    
    <link rel='stylesheet' type='text/css' href='style.css' media='screen'>  <!-- link CSS --> 
    <link href='https://fonts.googleapis.com/css?family=Amatic+SC' rel='stylesheet'> 
     <meta name='viewport' content='width=device-width, initial-scale=1.0'> 
</head>
<body>
";

echo"
<div class='header'>
   <div class='row'>
            <div class='col-sm-12'>
                <img class='img-responsive' src='bilder/titel1.jpg' id='titelbildoben' height='100%' alt='Titelbild'>
            </div>
    </div>
    <div class='row'>
        <div class='col-sm-1'>
            <a href='index.php'> <!--Klick auf Logo führt zur Index -->
                <img src='bilder/logo.png' alt='Logo' width='70%' id='logo' title='Donut World Startseite' alt='Logo Donut World'/>
            </a>
        </div>
        <br><br>
        <div class='col-sm-3'>
        </div>
        <div class='col-sm-3'>
            <a href='index.php'>
                <img src='bilder/titelschrift.png' alt='Donut World' title='Donut World' width='100%' id='titelschrift'>
            </a>
        </div>
        <div class='col-sm-3'>
        </div>
        <!--Drop-Down Menü Account -->
        <div id='account'>
            <div class='col-sm-1 dropdown2'>
                <li ><div id='profil'></div></li>
                
                <ul><div class='dropdownlinks2'>
";
                    include ("system/account/functions.php");
                    include ("system/account/logout.php");
                        if (isLoggedIn()) // wenn Nutzer eingeloggt
                        {
                        echo"
                            <li><a href='index.php?logout='1''>Logout</a></li>";
                        }
                        else // Nutzer nicht eingeloggt
                        {
                        echo "
                            <li><a href='system/account/login.php'>Login</a></li>";
                        }


                        if (isAdmin()) // wenn Admin eingeloggt
                        {
                            echo"
                                                <li><a href='system/backend/admin.php?page=bestelluebersicht'>Backend</a></li>";
                        }
                        elseif(isLoggedIn()) // Admin nicht eingeloggt
                        {
                            echo "
                                                <li><a href='index.php?page=account'>Meine Seite</a></li>";
                        }
                        else{};


                    echo"
                    </div>
                </ul>
            </div>
        </div>
        
            <div class='col-sm-1'>
                <li>
                ";
                if($warenkorb->artikel_gesamt() == 0){
                  echo"
                    <a href='index.php?page=warenkorbansicht'><div id='warenkorb'></div><a/></li>
                    ";}
                    else {
                        echo"
                        <a href='index.php?page=warenkorbansicht'><div id='warenkorbvoll'></div><a/></li>
                        ";
                    }
                    echo"
                    <div id='mengegesamt'>
                    ";
                        if($warenkorb->artikel_gesamt() > 0){
                            //get cart items from session
                            $warenkorb_artikel = $warenkorb->inhalte();
                            foreach($warenkorb_artikel as $artikel) {
                                $mengegesamt += $artikel["menge"];
                            }
                        }
                        echo $mengegesamt;
                    echo"
                    </div>
            
                    <div id='warenkorbmenge'>
                    ";
                            $warenkorb_artikel = $warenkorb->inhalte();
                            foreach($warenkorb_artikel as $artikel){
                                echo"<div class='row mengeinhalt'>
                                        <div class='col-sm-4'>
                                    <img class='img-responsive' src='bilder/".$artikel['ean'].".".$artikel['ende']."' width='200%' alt='Bild: ".$artikel['donutname']."' title='".$artikel['donutname']."'>
                                    </div>";
                                echo "<div class='col-sm-8'>".$artikel["donutname"];
                                echo "<br>";
                                echo "Menge:".$artikel["menge"];
                                echo"<br>
                                     </div>
                                     </div>";
                            }
                    echo"
                    </div>
                    <div id='warenkorbleer'>
                        <div class='row'>
                            <div class='col-sm-12'>
                                    Warenkorb ist leer.
                            </div>
                        </div>
                    </div>
            </div>
        
            <script>
                $('#warenkorbmenge').hide();        //Artikel im warenkorb sind zuerst weg & erscheinend beim hover
                $('#warenkorbvoll').hover(function(){
                    $('#warenkorbmenge').toggle();
                })
                
                $('#warenkorbvoll').hover(function(){ //Mengenangabe verschwindet bei draufgehen
                    $('#mengegesamt').toggle();
                })
                
                $('#warenkorbleer').hide();        //Artikel im warenkorb sind zuerst weg & erscheinend beim hover
                $('#warenkorb').hover(function(){
                    $('#warenkorbleer').toggle();
                })
                
            </script>
    </div>
  
            
            
    <div class='row'>
            <div class='col-sm-12'>
                <img class='img-responsive' src='bilder/titel2.jpg' id='titelbild' height='100%' alt='Titelbild2'>
            </div>
    </div>
    
    <div class='row navi'>
        <ul>
                <div class='col-sm-3'>
                    <li><a  href='index.php?page=home'>HOME</a></li>
                </div>
                <div class='col-sm-3'>
                    <li><a href='index.php?page=ueberuns'>ÜBER UNS</a></li>
                </div>
                <div class='col-sm-3 dropdown'>
                    <li class='dropdownliste'>DONUTS</li>
                    <ul class='dropdownlinks'>
                        <li><a href='index.php?page=alledonuts'>alle</a></li>
                        <li><a href='index.php?page=gefüllt'>gefüllt</a></li>
                        <li><a href='index.php?page=ungefüllt'>ungefüllt</a></li>
                    </ul>
                </div>
                <div class='col-sm-3'>
                    <li><a href='index.php?page=kontakt'>KONTAKT</a></li>
                </div>
            </ul>            
    </div>    
</div>    
</body>
</html>
";

echo" <div class='layout'>";
    if (isset($_GET["page"]) ) {
        switch ($_GET["page"]) {
            case "home":
                include "system/home.php";
                break;
            case "ueberuns":
                include "system/ueberuns.php";
                break;
            case "alledonuts":
                include "system/produkt/alledonuts.php";
                break;
            case "ungefüllt":
                include "system/produkt/ungefüllt.php";
                break;
            case "gefüllt":
                include "system/produkt/gefüllt.php";
                break;
            case "kontakt":
                include "system/kontakt/kontakt.php";
                break;
            case "warenkorbansicht":
                include "system/warenkorb/warenkorbansicht.php";
                break;
            case "zurkasse":
                include "system/warenkorb/zurkasse.php";
                break;
            case "bestellung_erfolgreich":
                include "system/warenkorb/bestellung_erfolgreich.php";
                break;
            case "account":
                include "system/account/bestellungen.php";
                break;
            case "impressum":
                include "system/footer/impressum.php";
                break;
            case "datenschutz":
                include "system/footer/datenschutz.php";
                break;
            case "agb":
                include "system/footer/agb.php";
                break;
            case "widerrufsrecht":
                include "system/footer/widerrufsrecht.php";
                break;
            case "versandundzahlung":
                include "system/footer/versandundzahlung.php";
                break;
            case "lebensmittelhinweise":
                include "system/footer/lebensmittelhinweise.php";
                break;
            case "kontaktsenden":
                include "system/kontakt/senden.php";
                break;
            default:
                include "system/home.php";
                break;
        }}
    else
    {
        include "system/home.php";
    }
echo"</div>";
echo"

<br>
<br>
<br>
<br>

    <div class='row'>
        <div class='col-sm12' style='height: 5em;'>
        </div>
    </div>
    
<footer>
<br>
    <div class='row'>
    <div class='footertotal'>
        <div class='col-sm-4'>
            <div class='footerleft'>
                <h4>Informationen</h4><br>
                <li><a href='index.php?page=impressum'>Impressum</a></li>
                <li><a href='index.php?page=datenschutz'>Datenschutz</a></li>
                <li><a href='index.php?page=agb'>AGB</a></li>
                <li><a href='index.php?page=widerrufsrecht'>Widerrufsrecht & Widerrufsformular</a></li>
                <li><a href='index.php?page=versandundzahlung'>Versand & Zahlung</a></li>
                <li><a href='index.php?page=lebensmittelhinweise'>Lebensmittelhinweise</a></li>
            </div>
        </div>
        <div class='col-sm-4'>
            <div class='footercenter'>
                <h4>Kontakt</h4><br>
                Donut World GmbH <br>
                in der Hochschule der Medien <br>
                Nobelstraße 10 <br>
                70563 Stuttgart-Vaihingen <br><br>
                E-Mail: DonutWorld@gmail.com <br>
                Telefon: 0711/605030 <br>
            </div>
        </div>
        <div class='col-sm-4'>
            <div class='footerright'>
                <h4>Folgt uns auf</h4><br>
                <a href='https://www.facebook.com/' title='Facebook' alt='Facebook'><img src='bilder/facebook.png' width='6%'></a>
                <a href='https://www.instagram.com/?hl=de' title='Instagram' alt='Instagram'><img src='bilder/instagram.png' width='6%'></a>
                <a href='https://twitter.com/?lang=de' title='Twitter' alt='Twitter'><img src='bilder/twitter.png' width='6%'></a>
                <a href='https://www.youtube.com/' title='YouTube' alt='YouTube'><img src='bilder/youtube.png' width='6%'></a>               
            </div>
        </div>
    </div>
    </div>
<br>
<br>
</footer>
";