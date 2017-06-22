<!DOCTYPE html>
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
if ((isset($_POST)) and ( !empty($_POST))) {
    $t_id = $_POST['ID'];
    require_once 'database.php';
    $DataBase = mysqli_connect(DB_host, DB_user, DB_password, DB_name);
    $requete35 = "SELECT statut,ville_depart,ville_arrive,depart_date,depart_time FROM trajet WHERE t_id = $t_id";
    $resultat35 = mysqli_query($DataBase, $requete35);
    $ligne35 = mysqli_fetch_array($resultat35, MYSQLI_NUM);
    $vd = $ligne35[1];
    $va = $ligne35[2];
    $dd = $ligne35[3];
    $dt = $ligne35[4];
    if ($ligne35[0] == 'effectue') {
        echo "<script type='text/javascript'> alert('Vous avez dejà effectué ce trajet.');</script>";
        echo "<script type='text/javascript'>window.location.href = 'page_info_trajet.php';</script>";
        exit();
    } else {
        $nb_passager = 0;
        $prix = 0;
        require_once 'database.php';
        $DataBase = mysqli_connect(DB_host, DB_user, DB_password, DB_name);
        $requete99 = "select passager_id from reservation where trajet_id=$t_id";
        $resultat99 = mysqli_query($DataBase, $requete99);
        if ($resultat99) {
            while ($ligne99 = mysqli_fetch_array($resultat99, MYSQLI_NUM)) {
                $date = date('d-m-Y H:i:s');
                $requete77 = "insert into messagerie values(0,$user_id,$ligne99[0],'On vous informe que votre trajet de $vd à $va le $dd à $dt est effectué','$date')";
                $resultat77 = mysqli_query($DataBase, $requete77);
                if ($resultat77) {
                } else {
                    echo (mysqli_error($DataBase));
                }
            }
        } else {
            echo (mysqli_error($DataBase));
        }
        $requete111 = "SELECT sum(nb_passager) FROM trajet WHERE t_id = $t_id";
        $resultat111 = mysqli_query($DataBase, $requete111);
        $ligne111 = mysqli_fetch_array($resultat111, MYSQLI_NUM);
        if ($resultat111) {
            $nb_passager = $ligne111[0];
        } else {
            echo mysqli_error($DataBase);
        }
        $requete113 = "SELECT prix FROM trajet WHERE t_id = $t_id";
        $resultat113 = mysqli_query($DataBase, $requete113);
        $ligne113 = mysqli_fetch_array($resultat113, MYSQLI_NUM);
        if ($resultat113) {
            $prix = $ligne113[0];
            $c_v = ($prix * $nb_passager);
        } else {
            echo mysqli_error($DataBase);
        }

        $requete115 = "SELECT compte FROM utilisateur WHERE id = $user_id";
        $resultat115 = mysqli_query($DataBase, $requete115);
        $ligne115 = mysqli_fetch_array($resultat115, MYSQLI_NUM);
        if ($resultat115) {
            $c = $c_v + $ligne115[0];
        } else {
            echo mysqli_error($DataBase);
        }

        $requete116 = "UPDATE utilisateur SET compte=$c WHERE id = $user_id";
        $resultat116 = mysqli_query($DataBase, $requete116);
        if ($resultat116) {
            
        } else {
            echo mysqli_error($DataBase);
        }

        $requete3 = "UPDATE trajet SET statut='effectue' WHERE t_id = $t_id";
        $resultat3 = mysqli_query($DataBase, $requete3);
        $requete31 = "UPDATE reservation SET status='effectue' WHERE trajet_id = $t_id";
        $resultat31 = mysqli_query($DataBase, $requete31);
        header("Location:page_info_trajet.php");
        exit();
    }
}
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="author" content="HE Guodong">
        <meta name="author" content="Hou Jie">
        <meta name="description" content="page d'indo trajet">
        <title>Information trajet | BlaBlaCar</title>
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
                            $requete1 = "select * from reservation where passager_id='$user_id'";
                            $resultat1 = mysqli_query($DataBase, $requete1);
                            $trajet_id = 0;
                            if ($resultat1) {
                                echo "<h1 style='text-align:left;width:100%;height:20px;padding:5px;background-color:#88a;'>Trajet Inscrit</h1>";
                                echo "<table>"
                                . "<tr><td>Trajet ID</td><td>Depart</td><td>Arrive</td>"
                                . "<td>Date</td><td>Time</td><td>PT</td><td>Prix</td>"
                                . "<td>PR</td><td>Conducteur</td><td>Status</td></tr>";
                                while ($ligne1 = mysqli_fetch_array($resultat1, MYSQLI_NUM)) {
                                    $r_id = $ligne1[0];
                                    $trajet_id = $ligne1[1];
                                    $nb_reserve = $ligne1[3];
                                    $c_id = $ligne1[4];
                                    $requete12 = "select nom,prenom from conducteur where user_id=$c_id";
                                    $resultat12 = mysqli_query($DataBase, $requete12);
                                    $ligne12 = mysqli_fetch_array($resultat12, MYSQLI_NUM);
                                    $conducteur = $ligne12[0] . " " . $ligne12[1];
                                    $requete2 = "select * from trajet where t_id='$trajet_id'";
                                    $resultat2 = mysqli_query($DataBase, $requete2);
                                    if ($resultat2) {
                                        while ($ligne2 = mysqli_fetch_array($resultat2, MYSQLI_NUM)) {

                                            echo "<tr><td>$ligne2[0]</td>"
                                            . "<td>$ligne2[3]</td>"
                                            . "<td>$ligne2[4]</td>"
                                            . "<td>$ligne2[5]</td>"
                                            . "<td>$ligne2[6] </td>"
                                            . "<td>$ligne2[7]</td>"
                                            . "<td>$ligne2[8]</td>"
                                            . "<td>$nb_reserve</td>"
                                            . "<td>$conducteur</td>"
                                            . "<td>$ligne2[11]</td></tr>";
                                        }
                                    } else {
                                        echo mysqli_error($DataBase);
                                    }
                                }
                                echo "</table>";
                            } else {
                                echo mysqli_error($DataBase);
                            }

                            $requete = "select * from trajet where user_id='$user_id'";
                            $resultat = mysqli_query($DataBase, $requete);
                            if ($resultat) {
                                echo "<h1 style='text-align:left;width:100%;height:20px;padding:5px;background-color:#88a;'>Trajet Propose</h1>";
                                while ($ligne = mysqli_fetch_array($resultat, MYSQLI_NUM)) {
                                    echo "<table width=720>"
                                    . "<tr><td>Trajet_ID</td><td>Depart</td><td>Arrive</td>"
                                    . "<td>Date</td><td>Time</td><td>PT</td><td>Prix</td>"
                                    . "<td>PR</td><td>PD</td><td>Status</td></tr>";
                                    echo "<tr><td>$ligne[0]</td>"
                                    . "<td>$ligne[3]</td>"
                                    . "<td>$ligne[4]</td>"
                                    . "<td>$ligne[5]</td>"
                                    . "<td>$ligne[6] </td>"
                                    . "<td>$ligne[7]</td>"
                                    . "<td>$ligne[8]</td>"
                                    . "<td>$ligne[9]</td>"
                                    . "<td>$ligne[10]</td>"
                                    . "<td>$ligne[11]</td></tr>";

                                    $requete02 = "select passager_id,nb_passager,status from reservation where trajet_id = $ligne[0]";
                                    $resultat02 = mysqli_query($DataBase, $requete02);
                                    echo "<table id='t1' width='720px'>"
                                    . "<tr><td>Passager</td><td>Place_reserve</td><td>Status</td></tr>";
                                    while ($ligne02 = mysqli_fetch_array($resultat02, MYSQLI_NUM)) {
                                        $p_id = $ligne02[0];
                                        $nb_reserve = $ligne02[1];
                                        $status = $ligne02[2];
                                        $requete4 = "select nom,prenom from passager where user_id = $p_id";
                                        $resultat4 = mysqli_query($DataBase, $requete4);
                                        $ligne4 = mysqli_fetch_array($resultat4, MYSQLI_NUM);
                                        echo "<tr><td>$ligne4[0] $ligne4[1]</td><td>$nb_reserve</td><td>$status</td></tr>";
                                    }
                                    echo "</table>";
                                    echo "<HR style='FLTER: alpha(opacity=100,finishopacity=0,style=2)' width='100%' color=#88a SIZE=2>";
                                }
                                echo "</table><br/>";
                                echo "<div style='text-align:center;'>"
                                . "<form id='formID' method='post' action = ''>"
                                . "Choisissez un trajet: <select name = 'ID' required='required'>";
                                $resultat1 = mysqli_query($DataBase, $requete);
                                while ($ligne1 = mysqli_fetch_array($resultat1, MYSQLI_NUM)) {
                                    echo "<option value = '$ligne1[0]'>$ligne1[0]</option>";
                                }
                                echo "</select><br/>";
                                echo "<button type='button' value='Preparation' onclick='checkpre(this)'>Preparer</button>";
                                echo"<td><button id='eff_button' type='button' value='Valider' onclick='checkeff(this)'>Valider</button></td></tr>";
                                echo "<button type='button' value='Suprrimer' onclick='checksup(this)'>Suprrimer</button>"
                                . "<p style='color:red;'>*Si vous supprimez le trajet pour lequel passagers sont inscrits<br/>Vous serez pénalisé et devrez payer à chaque passager une pénalité de 10 €.</p>";
                                echo "</form></div>";
                            } else {
                                echo mysqli_error($DataBase);
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
            function checkeff(input) {
                document.getElementById('ID').action = "page_effectuer_trajet.php";
                document.getElementById('ID').submit();
            }
            function checkpre(input) {
                document.getElementById('formID').action = "page_preparer_trajet.php";
                document.getElementById('formID').submit();
            }
            function checksup(input) {
                document.getElementById('formID').action = "page_supprimer_trajet.php";
                document.getElementById('formID').submit();
            }
        </script>
    </body>
</html>