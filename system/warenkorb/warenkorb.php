<?php
session_start();

class warenkorb {
    protected $warenkorb_inhalte = array();

//Neues Warenkorb Objekt
    public function __construct(){
        $this->warenkorb_inhalte = !empty($_SESSION['warenkorb_inhalte'])?$_SESSION['warenkorb_inhalte']:NULL;
        if ($this->warenkorb_inhalte === NULL){
            $this->warenkorb_inhalte = array('warenkorb_gesamt' => 0, 'artikel_gesamt' => 0);
        }
    }

//gibt den ganzen Warenkorb Array aus
    public function inhalte(){
        $warenkorb = array_reverse($this->warenkorb_inhalte);

        unset($warenkorb['artikel_gesamt']);
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
    public function einfuegen($artikel = array()){
        if(!is_array($artikel) OR count($artikel) === 0){
            return FALSE;
        }else{
            if(!isset($artikel['id'], $artikel['donutname'], $artikel['preis'], $artikel['menge'], $artikel['ean'], $artikel['beschreibung'], $artikel['ende'])){
                return FALSE;
            }else{
                $artikel['menge'] = (float) $artikel['menge'];
                if($artikel['menge'] == 0){
                    return FALSE;
                }

                $artikel['preis'] = (float) $artikel['preis'];
                $rowid = ($artikel['id']);
                $menge_alt = isset($this->warenkorb_inhalte[$rowid]['menge']) ? (int) $this->warenkorb_inhalte[$rowid]['menge'] : 0;
                $artikel['rowid'] = $rowid;
                $artikel['menge'] += $menge_alt;
                $this->warenkorb_inhalte[$rowid] = $artikel;

            //Speichert es dann in die Session
                if($this->warenkorb_speichern()){
                    return isset($rowid) ? $rowid : TRUE;
                }else{
                    return FALSE;
                }
            }
        }
    }

// Warenkorb updaten für Menge
    public function update($artikel = array()){
        if (!is_array($artikel) OR count($artikel) === 0){
            return FALSE;
        }else{
            if (!isset($artikel['rowid'], $this->warenkorb_inhalte[$artikel['rowid']])){
                return FALSE;
            }else{
                if(isset($artikel['menge'])){
                    $artikel['menge'] = (float) $artikel['menge'];
                    if ($artikel['menge'] == 0){
                        unset($this->warenkorb_inhalte[$artikel['rowid']]);
                        return TRUE;
                    }
                }
                $keys = array_intersect(array_keys($this->warenkorb_inhalte[$artikel['rowid']]), array_keys($artikel));
                if(isset($artikel['preis'])){
                    $artikel['preis'] = (float) $artikel['preis'];
                }
                foreach(array_diff($keys, array('id', 'donutname')) as $key){
                    $this->warenkorb_inhalte[$artikel['rowid']][$key] = $artikel[$key];
                }
                $this->warenkorb_speichern();
                return TRUE;
            }
        }
    }

//Warenkorb zur Session speichern
    protected function warenkorb_speichern(){
        $this->warenkorb_inhalte['artikel_gesamt'] = $this->warenkorb_inhalte['warenkorb_gesamt'] = 0;
        foreach ($this->warenkorb_inhalte as $key => $endpreis){

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