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
    if (isset($_POST['trjd']) and ( !empty($_POST['trjd']))) {
        $trjd = ucwords($_POST['trjd']);
        if (isset($_POST['trja']) and ( !empty($_POST['trja']))) {
            $trja = ucwords($_POST['trja']);
            if (isset($_POST['date_aller']) and ( !empty($_POST['date_aller']))) {
                $da = $_POST['date_aller'];
                if (isset($_POST['time_aller']) and ( !empty($_POST['time_aller']))) {
                    $ta = $_POST['time_aller'];
                    $requete = "select * from trajet where ville_depart='$trjd' and ville_arrive='$trja' and depart_date=$da and depart_time='$ta'and not statut='effectue'and not nb_place_reste=0";
                } else {
                    $ta = 0;
                    $requete = "select * from trajet where ville_depart='$trjd' and ville_arrive='$trja' and depart_date=$da and not statut='effectue'and not nb_place_reste=0";
                }
            } else {
                $requete = "select * from trajet where ville_depart='$trjd' and ville_arrive='$trja' and not statut='effectue'and not nb_place_reste=0";
            }
        } else {
            if (isset($_POST['date_aller']) and ( !empty($_POST['date_aller']))) {
                $da = $_POST['date_aller'];
                if (isset($_POST['time_aller']) and ( !empty($_POST['time_aller']))) {
                    $ta = $_POST['time_aller'];
                    $requete = "select * from trajet where ville_depart='$trjd' and depart_date=$da and depart_time='$ta' and not statut='effectue'and not nb_place_reste=0";
                } else {
                    $ta = 0;
                    $requete = "select * from trajet where ville_depart='$trjd' and depart_date=$da and not statut='effectue'and not nb_place_reste=0";
                }
            } else {
                $requete = "select * from trajet where ville_depart='$trjd' and not statut='effectue'and not nb_place_reste=0";
            }
        }
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
                <p class='sous-titre'>
                    <a href="page_mesagerie.php"><image src="images/mail.png" width="30px" height="25px"/></a>&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;
                    <a href="page_logout.php" style='position: absolute; top: 39px;right:130px;color:red;'>Log-out</a> 
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

                            <?php
                            require_once 'database.php';
                            $DataBase = mysqli_connect(DB_host, DB_user, DB_password, DB_name);
                            $resultat1 = mysqli_query($DataBase, $requete);
                            if ($resultat1) {
                                $ligne1 = mysqli_fetch_array($resultat1, MYSQLI_NUM);
                                if ($ligne1[0] != 0) {
                                    $DataBase = mysqli_connect(DB_host, DB_user, DB_password, DB_name);
                                    $resultat = mysqli_query($DataBase, $requete);
                                    while ($ligne = mysqli_fetch_array($resultat, MYSQLI_NUM)) {
                                        $t_id = $ligne[0];
                                        echo "<table width='600px' cellspacing=0 cellpadding=1>"
                                        . "<form method='post' id=$t_id action='page_select_trajet.php'>"
                                        . "<th><h2>Trajet list&nbsp&nbsp;&nbsp&nbsp;<input type='submit' value='Reservez' ></h2></th><tr><td id='t_id'>Trajet ID : &nbsp&nbsp; $ligne[0]</td></tr> "
                                        . "<tr><td>Ville deart :$ligne[3]</td></tr> "
                                        . "<tr><td>Ville arrive : $ligne[4]</td></tr>"
                                        . "<tr><td> Date depart :$ligne[5] &nbsp&nbsp;&nbsp&nbsp; &nbsp&nbsp;&nbsp&nbsp; &nbsp&nbsp;Time depart :  &nbsp&nbsp;$ligne[6] </td></tr>"
                                        . "<tr><td>Prix :$ligne[8]  &nbsp&nbsp; &nbsp&nbsp;&nbsp&nbsp; &nbsp&nbsp;&nbsp&nbsp; &nbsp&nbsp;&nbsp&nbsp; &nbsp&nbsp;Nombre de place rest :  &nbsp&nbsp;$ligne[10]</td></tr>"
                                        . "<tr><td>Statut :$ligne[11]</td></tr>"
                                        . "<tr><td>Nombre de passager<select name = 'nb_ajout' id='nb_ajout' required='required'>";
                                        for ($i = 1; $i <= $ligne[10]; $i++) {
                                            echo "<option value = '$i'>$i</option>";
                                        }
                                        echo"</td></tr></select>";
                                        echo "</table>";
                                        echo "<input type = 'hidden' id = 't_id' name = 't_id' value = $t_id>";
                                        echo "<input type = 'hidden' id = 'nb_place' name = 'nb_place' value = $ligne[10]>";
                                        echo "<input type = 'hidden' id = 'nb_passager' name = 'nb_passager' value = $ligne[9]>";
                                        echo "</form>";
                                    }
                                } else {
                                    echo "<script type='text/javascript'> alert('Aucun resultat trouve.');</script>";
                                    echo "<script type='text/javascript'>window.location.href = 'page_recherche_trajet.php';</script>";
                                }
                            } else {
                                echo (mysqli_error($DataBase));
                            }
                            ?>

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
