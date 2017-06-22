<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Utilisateur
 *
 * @author HOU Jie
 */
require_once './Class/SQL.php';

class Utilisateur {

    private $id;
    private $login;
    private $password;
    private $is_conducteur;
    private $is_passager;
    private $dbHelper;

    public function __toString() {
        return "id=" . $this->id . "login=" . $this->login . "password=" . $this->password . "is_conducteur" . $this->is_conducteur . "is_passager" . $this->is_passager;
    }

    function __construct($login, $password, $is_conducteur = false, $is_passager = false) {
        $this->login = $login;
        $this->password = $password;
        $this->is_conducteur = $is_conducteur;
        $this->is_passager = $is_passager;
//        $this->dbHelper = new sql();
    }

    public static function USER_ajout($nom, $prenom, $password, $is_conducteur, $is_passager) {
        $this->login = $nom . $prenom;
        $this->password = $password;
        $this->is_conducteur = $is_conducteur;
        $this->is_passager = $is_passager;
        if ($this->dbHelper->execute("SELECT login FROM 'user' WHERE login=" . $this->login)) {
            return false;
        } else {
            $array_of_values = array(
                'login' => $this->login,
                'password' => $this->password,
                'is_scolarite' => $this->is_conducteur,
                'is_dhr' => $this->is_passager,
            );
            $this->dbHelper->insert('user', $array_of_values);
        }
    }

    public static function USER_suppression($nom, $prenom) {
        $this->login = $nom . $prenom;
        $this->dbHelper->delete('user', 'login=' . $this->login);
    }

    public function USER_login($login, $password, $session = null) {
        $options = array(
            'table' => 'user, ec, pole_programme AS p',
            'fields' => 'is_conducteur, is_passager, password, p.programme_id',
            'condition' => 'login= "' . $login . '" AND ec.pole_id = p.pole_id',
            'group' => '1',
            'order' => '1');
        $resultat = $this->dbHelper->select($options);
        if ($resultat) {
            if ($password == $resultat[0]['user']['password']) {
                $session['login_info'] = array(
                    'is_login' => true,
                    'login' => $login,
                    'is_conducteur' => $resultat[0]['user']['is_conducteur'],
                    'is_passager' => $resultat[0]['user']['is_passager'],
                    'programme_id' => $resultat[0]['p']['programme_id'],
                );
                return true;
            } else {
                return false;
            }
        } else {
            return FALSE;
        }
    }

    public function USER_logout(&$session) {
        if (isset($session['login_info']) && isset($session['login_info']['is_login']) && $session['login_info']['is_login'] == true) {
            unset($session['login_info']);
        }
    }

}
