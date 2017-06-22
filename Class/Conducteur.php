<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Conducteur
 *
 * @author HOU Jie
 */
class Conducteur {

    private $id;
    private $nom;
    private $prenom;
    private $sexe;
    private $email;
    private $annee;
    private $dbhelper;
    private $véhicule;
    private $trajet;
    
    function __construct($id, $nom, $prenom, $sexe, $email, $annee, $dbhelper, $véhicule) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->sexe = $sexe;
        $this->email = $email;
        $this->annee = $annee;
        $this->dbhelper = $dbhelper;
        $this->véhicule = $véhicule;
    }

    public function proposerTrajet(){
        
    }
    
}
