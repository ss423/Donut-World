<?php
session_start();

class warenkorb {
    protected $warenkorb_inhalte = array();

    public function __construct(){
        // Warenkorb array von der Session bekommen --> wenn nicht leer dann übernehmen sonst null reinsetzen
        $this->warenkorb_inhalte = !empty($_SESSION['warenkorb_inhalte'])?$_SESSION['warenkorb_inhalte']:NULL;
        if ($this->warenkorb_inhalte === NULL){
            // wenn Warenkorb NULL ist dann basis daten (0) einsetzen
            $this->warenkorb_inhalte = array('warenkorb_gesamt' => 0, 'artikel_gesamt' => 0);
        }
    }

    public function inhalte(){          //gibt den ganzen Warenkorb Array raus
        // gibt das neueste zuerst raus (reverse=umdrehen)
        $warenkorb = array_reverse($this->warenkorb_inhalte);

        //löschen der variablen artikel gesamt & warenkorb gesamt --> brauchens nciht
        unset($warenkorb['artikel_gesamt']);
        unset($warenkorb['warenkorb_gesamt']);

        return $warenkorb;
    }

    public function get_artikel($row_id){       //ein Artikel rauslesen per id in einem array
        return (in_array($row_id, array('artikel_gesamt', 'warenkorb_gesamt'), TRUE) OR ! isset($this->warenkorb_inhalte[$row_id]))
            ? FALSE
            : $this->warenkorb_inhalte[$row_id];
    }

    public function artikel_gesamt(){       //gibt gesamte Artikel zurück = gesamte Artikelmenge
        return $this->warenkorb_inhalte['artikel_gesamt'];
    }

    public function gesamt(){       //Gesamtpreis
        return $this->warenkorb_inhalte['warenkorb_gesamt'];
    }

    public function einfuegen($artikel = array()){      //fügt artikel hinzu & speichert in Session
        if(!is_array($artikel) OR count($artikel) === 0){
            return FALSE;
        }else{
            if(!isset($artikel['id'], $artikel['donutname'], $artikel['preis'], $artikel['menge'], $artikel['ean'], $artikel['beschreibung'], $artikel['ende'])){
                return FALSE;
            }else{
                // Artikel einfügen --> 1. Menge vorbereiten
                $artikel['menge'] = (float) $artikel['menge'];
                if($artikel['menge'] == 0){
                    return FALSE;
                }
                // Vorbereitung preis
                $artikel['preis'] = (float) $artikel['preis'];
                // schafft ein Errechnet den MD5-Hash eines Strings um Artikel in Warenkorb zu legen
                $rowid = md5($artikel['id']);
                // bekommt die menge falls vorhanden & fügt es hinzu
                $menge_alt = isset($this->warenkorb_inhalte[$rowid]['menge']) ? (int) $this->warenkorb_inhalte[$rowid]['menge'] : 0;
                // eintrag wiederherstellen mit altem identifier & neuer menge
                $artikel['rowid'] = $rowid;
                $artikel['menge'] += $menge_alt;
                $this->warenkorb_inhalte[$rowid] = $artikel;

                // Warenartikel speichern
                if($this->warenkorb_speichern()){
                    return isset($rowid) ? $rowid : TRUE;
                }else{
                    return FALSE;
                }
            }
        }
    }

    // Warenkorb updaten
    public function update($artikel = array()){
        if (!is_array($artikel) OR count($artikel) === 0){
            return FALSE;
        }else{
            if (!isset($artikel['rowid'], $this->warenkorb_inhalte[$artikel['rowid']])){
                return FALSE;
            }else{
                // Menge vorbereiten
                if(isset($artikel['menge'])){
                    $artikel['menge'] = (float) $artikel['menge'];
                    // Artikel löschen falls Menge=0 ist
                    if ($artikel['menge'] == 0){
                        unset($this->warenkorb_inhalte[$artikel['rowid']]);
                        return TRUE;
                    }
                }

                // ids finden zum updaten
                $keys = array_intersect(array_keys($this->warenkorb_inhalte[$artikel['rowid']]), array_keys($artikel));
                // Preis vorbereiten
                if(isset($artikel['preis'])){
                    $artikel['preis'] = (float) $artikel['preis'];
                }
                // Produkt id & name bleiben erhalten --> nicht veränderbar
                foreach(array_diff($keys, array('id', 'donutname')) as $key){
                    $this->warenkorb_inhalte[$artikel['rowid']][$key] = $artikel[$key];
                }
                // Warenkorbdaten speichern
                $this->warenkorb_speichern();
                return TRUE;
            }
        }
    }

    //Warenkorb zur Session speichern
    protected function warenkorb_speichern(){
        $this->warenkorb_inhalte['artikel_gesamt'] = $this->warenkorb_inhalte['warenkorb_gesamt'] = 0;
        foreach ($this->warenkorb_inhalte as $key => $endpreis){
            // schauen ob array die Variablen hat
            if(!is_array($endpreis) OR !isset($endpreis['preis'], $endpreis['menge'])){
                continue;
            }

            $this->warenkorb_inhalte['warenkorb_gesamt'] += ($endpreis['preis'] * $endpreis['menge']);
            $this->warenkorb_inhalte['artikel_gesamt'] += $endpreis['menge'];
            $this->warenkorb_inhalte[$key]['summepreis'] = ($this->warenkorb_inhalte[$key]['preis'] * $this->warenkorb_inhalte[$key]['menge']);
        }

        // Wenn Warekorb leer ist, von der Session löschen
        if(count($this->warenkorb_inhalte) <= 2){
            unset($_SESSION['warenkorb_inhalte']);
            return FALSE;
        }else{
            $_SESSION['warenkorb_inhalte'] = $this->warenkorb_inhalte;
            return TRUE;
        }
    }

    //Artikel vom Warenkorb entfernen
    public function entfernen($row_id){
        // löschen und speichern
        unset($this->warenkorb_inhalte[$row_id]);
        $this->warenkorb_speichern();
        return TRUE;
    }

    //leert den Warenkorb und vernichtet die Session
    public function destroy(){
        $this->warenkorb_inhalte = array('warenkorb_gesamt' => 0, 'artikel_gesamt' => 0);
        unset($_SESSION['warenkorb_inhalte']);
    }
}