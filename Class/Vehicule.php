<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Véhicule
 *
 * @author HOU Jie
 */
class Véhicule {

    private $marque;
    private $modele;
    private $confort;
    private $nb_de_place;
    private $couleur;
    private $annee_de_mise_en_service;
    private $categorie;

    public function __toString() {
        return  "marque=" . $this->marque . "modele=" . $this->modele . "confore" . $this->confort . "nb_de_place" . $this->nb_de_place
                . "couleur" . $this->couleur . "annee_de_mise_en_service" . $this->annee_de_mise_en_service . "categorie" . $this->categorie;
    }

    function __construct($marque, $modele, $confort, $nb_de_place, $couleur, $annee_de_mise_en_service, $categorie) {
        $this->marque = $marque;
        $this->modele = $modele;
        $this->confort = $confort;
        $this->nb_de_place = $nb_de_place;
        $this->couleur = $couleur;
        $this->annee_de_mise_en_service = $annee_de_mise_en_service;
        $this->categorie = $categorie;
    }

}
