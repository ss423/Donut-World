<?php
session_start();

class warenkorb {
    protected $warenkorb_inhalte = array();   //schützt vor zugrifff von außen und kann quasi nur in der klasse verändert werden

//Neues Warenkorb Objekt
    public function __construct(){   //wird aufgerufen, wenn neuer warenkorb erzeugt wird, entweder komplett neu, oder bestehender wird genommen
        $this->warenkorb_inhalte = !empty($_SESSION['warenkorb_inhalte'])?$_SESSION['warenkorb_inhalte']:NULL;    // Warenkorb array von der Session bekommen --> wenn nicht leer dann übernehmen sonst null reinsetzen
        if ($this->warenkorb_inhalte === NULL){
            $this->warenkorb_inhalte = array('warenkorb_gesamt' => 0, 'artikel_gesamt' => 0);       // wenn Warenkorb NULL ist dann basis daten (0) einsetzen
        }
    }

//gibt den ganzen Warenkorb Array aus
    public function inhalte(){
        $warenkorb = array_reverse($this->warenkorb_inhalte);   // gibt das neueste zuerst raus (reverse=umdrehen)

        unset($warenkorb['artikel_gesamt']);       //löschen der variablen artikel gesamt & warenkorb gesamt --> brauchens nciht für artikel ausgabe
        unset($warenkorb['warenkorb_gesamt']);

        return $warenkorb;
    }

//gibt gesamte Artikel zurück
    public function artikel_gesamt(){
        return $this->warenkorb_inhalte['artikel_gesamt'];
    }

//Gesamtpreis
    public function gesamt(){
        return $this->warenkorb_inhalte['warenkorb_gesamt'];
    }

//Fügt Artikel hinzu und Speichert ihn
    public function einfuegen($artikel = array()){         //$artikel wird als array gesetzt
        if(!is_array($artikel) OR count($artikel) === 0){   //prüft ob $artikel noch kein array ist oder die anzahl der elemente im array 0 ist
            return FALSE;
        }else{
            if(!isset($artikel['id'], $artikel['donutname'], $artikel['preis'], $artikel['menge'], $artikel['ean'], $artikel['beschreibung'], $artikel['ende'])){
                return FALSE;        //prüft ob die variablen existieren und nicht NULL sind
            }else{
                $artikel['menge'] = (float) $artikel['menge'];   //menge wird als float gesetzt und überprüft ob sie nicht 0 ist
                if($artikel['menge'] == 0){
                    return FALSE;
                }

                $artikel['preis'] = (float) $artikel['preis'];    //preis wird als float gesetzt
                $rowid = ($artikel['id']);
                $menge_alt = isset($this->warenkorb_inhalte[$rowid]['menge']) ? (int) $this->warenkorb_inhalte[$rowid]['menge'] : 0;   // bekommt die menge der jeweiligen id des artikels und fügt sie als integer hinzu falls es eine menge gibt ansonsten wird 0 übergeben
                $artikel['rowid'] = $rowid;
                $artikel['menge'] += $menge_alt;               //neue menge wird mit evtl bereits vorhandenen addiert
                $this->warenkorb_inhalte[$rowid] = $artikel;   //ins array wird der artikel mit der jeweiligen id hinzugefügt

            //Speichert es dann in die Session
                if($this->warenkorb_speichern()){
                    return isset($rowid) ? $rowid : TRUE;    //wenn rowid gesetzt ist speichern ansonsten nicht
                }else{
                    return FALSE;
                }
            }
        }
    }

// Warenkorb updaten
    public function update($artikel = array()){           //$artikel wird als array gesetzt
        if (!is_array($artikel) OR count($artikel) === 0){     //prüft ob $artikel noch kein array ist oder die anzahl der elemente im array 0 ist
            return FALSE;
        }else{
            if (!isset($artikel['rowid'], $this->warenkorb_inhalte[$artikel['rowid']])){   //prüft ob es einen artikel mit einer id gibt
                return FALSE;
            }else{
                if(isset($artikel['menge'])){                           //wenn eine menge gesetzt ist
                    $artikel['menge'] = (float) $artikel['menge'];      //menge wird als float gesetzt und falls menge 0 ist soll er den artikel aus dem array löschen
                    if ($artikel['menge'] == 0){
                        unset($this->warenkorb_inhalte[$artikel['rowid']]);
                        return TRUE;
                    }
                }
                $keys = array_intersect(array_keys($this->warenkorb_inhalte[$artikel['rowid']]), array_keys($artikel));  //liefert schnittmenge der warenkorbinhalte des jeweiligen artikels und der schlüssel
                if(isset($artikel['preis'])){
                    $artikel['preis'] = (float) $artikel['preis'];   //wenn ein preis gesetztt ist, mach den preis zu einem float
                }
                foreach(array_diff($keys, array('id', 'donutname')) as $key){     // Produkt id & name bleiben erhalten --> nicht veränderbar
                    $this->warenkorb_inhalte[$artikel['rowid']][$key] = $artikel[$key];   //update die menge genau an der stelle an dem der key dann zutrifft
                }
                $this->warenkorb_speichern();    // Warenkorbdaten in session speichern
                return TRUE;
            }
        }
    }

//Warenkorb zur Session speichern
    protected function warenkorb_speichern(){
        $this->warenkorb_inhalte['artikel_gesamt'] = $this->warenkorb_inhalte['warenkorb_gesamt'] = 0;   //artikel_gesammt und warenkorb_gesammt aus dem array werden 0 gesetzt
        foreach ($this->warenkorb_inhalte as $key => $endpreis){   //speichern in $endpreis und schlüssel als $key

            if(!is_array($endpreis) OR !isset($endpreis['preis'], $endpreis['menge'])){   // wenn $endpreis kein array ist oder preis und mege nicht gesetzt sind überspring diesen schritt
                continue;
            }

            $this->warenkorb_inhalte['warenkorb_gesamt'] += ($endpreis['preis'] * $endpreis['menge']);    // zum warenkorb_gesammt wird preis mal menge hinzuaddiert
            $this->warenkorb_inhalte['artikel_gesamt'] += $endpreis['menge'];                             // zu den artikel_gesammt wird menge hinzuaddiert
            $this->warenkorb_inhalte[$key]['summepreis'] = ($this->warenkorb_inhalte[$key]['preis'] * $this->warenkorb_inhalte[$key]['menge']);    //summepreis wird festgelegt als alle preise mal alle mengen des jeweiligen produktes
        }

        // Wenn Warekorb leer ist, von der Session löschen
        if(count($this->warenkorb_inhalte) <= 2){       //wenn die anzahl der elemente im warenkorb kleiner oder gleich 2 sind, also wenns kein summepreis gibt, session löschen
            unset($_SESSION['warenkorb_inhalte']);
            return FALSE;
        }else{
            $_SESSION['warenkorb_inhalte'] = $this->warenkorb_inhalte;     //ansonsten speicher das array warenkorb_inhalte in die session "warenkorb_inhalte"
            return TRUE;
        }
    }

//Artikel vom Warenkorb entfernen
    public function entfernen($row_id){              //bei der jeweiligen id des zu löschenden donuts werden die inhalte entfernt
        unset($this->warenkorb_inhalte[$row_id]);
        $this->warenkorb_speichern();                //löscht es dann auch nochmal aus der session
        return TRUE;
    }

//leert den Warenkorb und vernichtet die Session
    public function destroy(){
        $this->warenkorb_inhalte = array('warenkorb_gesamt' => 0, 'artikel_gesamt' => 0);
        unset($_SESSION['warenkorb_inhalte']);
    }
}