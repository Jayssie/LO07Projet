<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    header("Location:page_login.php");
}
require_once 'database.php';
$DataBase = mysqli_connect(DB_host, DB_user, DB_password, DB_name);
$requete0304 = "select count(receive_id) from messagerie where receive_id=$user_id";
$resultat0304 = mysqli_query($DataBase, $requete0304);
if ($resultat0304) {
    $ligne0304 = mysqli_fetch_array($resultat0304, MYSQLI_NUM);
    echo "<div style='position: absolute; top: 39px;right:210px;color:red;'><b id='nb_mes'>$ligne0304[0]</b></div>";
} else {
    echo mysqli_error($DataBase);
}

if (isset($_POST) and ( !empty($_POST))) {
    $t_id = $_POST['t_id'];
    $nb_ajout = $_POST['nb_ajout'];
    $nb_place = $_POST['nb_place'] - $nb_ajout;
    $nb_passager = $_POST['nb_passager'] + $nb_ajout;
    require_once 'database.php';
    $DataBase = mysqli_connect(DB_host, DB_user, DB_password, DB_name);
    $requete0 = "select * from trajet where user_id=$user_id and t_id=$t_id";
    $resultat0 = mysqli_query($DataBase, $requete0);
    if ($resultat0) {
        $ligne0 = mysqli_fetch_array($resultat0, MYSQLI_NUM);
        if ($ligne0[0] != 0) {
            echo "<script type='text/javascript'> alert('Vous ne pouvez pas choisir ce trajet que vous avez propose.');</script>";
            echo "<script type='text/javascript'>window.location.href = 'page_recherche_trajet.php';</script>";
            exit();
        } else {
            $requete01 = "select * from trajet where t_id=$t_id";
            $resultat01 = mysqli_query($DataBase, $requete01);
            if ($resultat01) {
                $ligne01 = mysqli_fetch_array($resultat01, MYSQLI_NUM);
                $c_id = $ligne01[1];
            } else {
                echo mysqli_error($DataBase);
            }

            $requete1 = "update trajet t set t.nb_passager=$nb_passager where t.t_id=$t_id;";
            $requete2 = "update trajet t set t.nb_place_reste=$nb_place where t.t_id=$t_id;";
            $requete3 = "insert into reservation values (0,$t_id,$user_id,$nb_ajout,$c_id,'non_effectue')";
            $resultat1 = mysqli_query($DataBase, $requete1);
            $resultat2 = mysqli_query($DataBase, $requete2);
            $resultat3 = mysqli_query($DataBase, $requete3);
            if ($resultat3) {
                $requete111 = "SELECT user_id,prix FROM trajet WHERE t_id = $t_id";
                $resultat111 = mysqli_query($DataBase, $requete111);
                $ligne111 = mysqli_fetch_array($resultat111, MYSQLI_NUM);
                if ($resultat111) {
                    
                } else {
                    echo mysqli_error($DataBase);
                }
                $c_id = $ligne111[0];
                $prix = $ligne111[1];
                $p_id = $user_id;
                $n = $nb_ajout;
                $c_v = ($prix * $n);
                $requete001 = "SELECT compte FROM utilisateur WHERE id = $p_id";
                $resultat001 = mysqli_query($DataBase, $requete001);
                $ligne001 = mysqli_fetch_array($resultat001, MYSQLI_NUM);
                if ($resultat001) {
                    $compte_p = $ligne001[0] - $c_v;
                    $requete002 = "UPDATE utilisateur SET compte = $compte_p WHERE id = $p_id";
                    $resultat002 = mysqli_query($DataBase, $requete002);
                    if ($resultat002) {
                        
                    } else {
                        echo mysqli_error($DataBase);
                    }
                } else {
                    echo mysqli_error($DataBase);
                }
                $requete3 = "UPDATE trajet SET statut='effectue_par_client' WHERE t_id = $t_id";
                $resultat3 = mysqli_query($DataBase, $requete3);
                header("Location:page_info_trajet.php");
                exit();
            } else {
                echo mysqli_error($DataBase);
            }
            header("Location:page_info_trajet.php");
        }
    } else {
        echo (mysqli_error($DataBase));
    }
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="author" content="HE Guodong">
        <meta name="author" content="Hou Jie">
        <meta name="description" content="page d'indo trajet">
        <title>List trajet | BlaBlaCar</title>
        <link rel="stylesheet" type="text/css" href="./CSS/style_info_trajet.css"/>
    </head>
    <body>
        <div id="global">
            <div id="entete">
                <a href="index.php"><img src="images/logo.PNG" height="45" width="160"></a>
                <p class='sous-titre'> <a href="page_logout.php">Log-out</a> |
                    Comment ça marche &nbsp &nbsp &nbsp;
                    <a href="https://www.facebook.com/"><img src="images/index_2.PNG" height="20" width="43"></a>
                    <img src="images/index_3.PNG" height="20" width="33">
                </p>
            </div>
            <div id="centre">
                <div id="centre-bis">   
                    <div id='principal_1'>
                        <div id='navigation'>                
                            <table bgcolor="#f4f4f4" width="200" cellspacing=0 cellpadding=5>
                                <tr class="change" onclick="check1(this)"><td>Affiche info prive</td></tr>
                                <tr class="change" onclick="check2(this)"><td>Proposer un trajet</td></tr>
                                <tr class="change" onclick="check3(this)"><td>Ajouter un vehicule</td></tr>
                                <tr class="change" onclick="check4(this)"><td>Affiche info vehicule</td></tr>
                                <tr class="change" onclick="check5(this)"><td>Affiche info trajet</td></tr>
                                <tr class="change" onclick="check6(this)"><td>Recherche un trajet</td></tr>
                                <tr class="change" onclick="check7(this)"><td>Apprécier un trajet</td></tr>
                                <tr class="change" onclick="check8(this)"><td>Affiche appréciation</td></tr>
                            </table>
                        </div>
                        <div id='principal_contenue'>
                        </div>
                    </div>
                </div>
            </div>
            <div id="pied_1">
                <div id="colonne1">Infos Pratiques</div>
                <div id="colonne2">A propos</div>
                <div id="colonne3">BlaBla News</div>
            </div>
            <div id="pied_2">
                <div id="colonne1">
                    Comment ça marche<br/>
                    Confiance et sérénité<br/>
                    Assurance Sécurité Fiscalité<br/>
                    Niveaux d'Expérience<br/>
                    Application Mobile<br/>
                    Témoignages et anecdotes<br/>
                    Les avis<br/>
                    Ladies only<br/>
                    Prix du covoiturage<br/>
                    Questions fréquentes<br/>
                    Contact<br/>
                </div>
                <div id="colonne2">
                    Qui sommes nous?<br/>
                    Presse<br/>
                    Nous recrutons<br/>
                    Partenaires<br/>
                    Utilisation des cookies<br/>
                    Charte de bonne conduite<br/>
                    Conditions Générales<br/>
                </div>
                <div id="colonne3">
                    Covoiturage et sécurité routière<br/><br/><br/><br/><br/>
                    Prêts pour le BlaBlaTour 2015 ?<br/>
                    Vous l'attendiez tous, il est de <br/>
                    retour... le BlaBlaTour 2015 !<br/> 
                    Cet été, la BlaBlaTeam part<br/>
                    à la rencontre ...<br/><br/><br/><br/>
                    Voir tous les articles du blog<br/>
                </div>
            </div>
        </div>
        <div id="copyright">blablacar,2015 ©</div>
        <script>
            function check1(input) {
                window.location.href = 'informations_privees.php';
            }
            function check2(input) {
                window.location.href = 'Ajouter_un_trajet.php';
            }
            function check3(input) {
                window.location.href = 'page_vehicule.php';
            }
            function check4(input) {
                window.location.href = 'page_infovehicule.php';
            }
            function check5(input) {
                window.location.href = 'page_info_trajet.php';
            }
            function check6(input) {
                window.location.href = 'page_recherche_trajet.php';
            }
            function check7(input) {
                window.location.href = 'page_appreciation.php';
            }
            function check8(input) {
                window.location.href = 'page_affiche_appreciation.php';
            }
        </script>
    </body>
</html>
