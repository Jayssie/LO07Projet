<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Passager
 *
 * @author HOU Jie
 */
class Passager {

    private $id;
    private $nom;
    private $prenom;
    private $sexe;
    private $email;
    private $annee;
    private $véhicule;
    private $dbhelper;
    
    
    function __construct($nom, $prenom, $sexe, $email, $annee) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->sexe = $sexe;
        $this->email = $email;
        $this->annee = $annee;
    }

    public function ajouteVéhicule() {
        
    }
    
    public function selectTrajet(){
        
    }
}
