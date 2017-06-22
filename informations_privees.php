<!DOCTYPE HTML>
<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    header("Location:page_login.php");
}
require_once 'database.php';
$DataBase = mysqli_connect(DB_host, DB_user, DB_password, DB_name);

$requete = "select * from passager where user_id=$user_id";
$resultat = mysqli_query($DataBase, $requete);
if ($resultat) {
    $ligne = mysqli_fetch_array($resultat, MYSQLI_NUM);
}

$requete3 = "select compte from utilisateur where id=$user_id";
$resultat3 = mysqli_query($DataBase, $requete3);
if ($resultat3) {
    $ligne3 = mysqli_fetch_array($resultat3, MYSQLI_NUM);
}
$requete0304 = "select count(receive_id) from messagerie where receive_id=$user_id";
$resultat0304 = mysqli_query($DataBase, $requete0304);
if ($resultat0304) {
    $ligne0304 = mysqli_fetch_array($resultat0304, MYSQLI_NUM);
    echo "<div style='position: absolute; top: 39px;right:210px;color:red;'><b id='nb_mes'>$ligne0304[0]</b></div>";
} else {
    echo mysqli_error($DataBase);
}
$requeteUE = "select is_conducteur from utilisateur where id=$user_id";
$resultatUE = mysqli_query($DataBase, $requeteUE);
$ligneUE = mysqli_fetch_array($resultatUE, MYSQLI_NUM);
if ($ligneUE[0] == 1) {
    $requeteAM = "select count(a_id),sum(note) from appreciation where conducteur_id=$user_id and etat=1";
    $resultatAM = mysqli_query($DataBase, $requeteAM);
    $ligneAM = mysqli_fetch_array($resultatAM, MYSQLI_NUM);
    if ($ligneAM[0] != 0) {
        $note_moyenne = ($ligneAM[1] / $ligneAM[0]);
    } else {
        $note_moyenne = 0;
    }
} else {
    $requeteAM1 = "select count(a_id),sum(note) from appreciation where passager_id=$user_id and etat=0";
    $resultatAM1 = mysqli_query($DataBase, $requeteAM1);
    $ligneAM1 = mysqli_fetch_array($resultatAM1, MYSQLI_NUM);
    if ($ligneAM1[0] != 0) {
        $note_moyenne = ($ligneAM1[1] / $ligneAM1[0]);
    } else {
        $note_moyenne = 0;
    }
}
?>
<?php
if (isset($_POST) and ( !empty($_POST))) {
    $dir = "document/"; //create一个new folder 叫 upload, 但必须与photo.php, photo.html 同级
    $tmp_name = $_FILES['image']['tmp_name'];
    $actual_name = basename($_FILES['image']['name']);
    $size = $_FILES['image']['size'];
    $type = $_FILES['image']['type'];
    $url = $dir . $actual_name;
    move_uploaded_file($tmp_name, $url); //把上传的照片存到 upload folder 里
    require_once 'database.php';
    $DataBase = mysqli_connect(DB_host, DB_user, DB_password, DB_name);
    $requete1 = "insert into photo values (0,$user_id,'$url')";
    $resultat1 = mysqli_query($DataBase, $requete1);
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="author" content="HE Guodong">
        <meta name="author" content="Hou Jie">
        <meta name="description" content="page d'indo prive">
        <title>Page prive | BlaBlaCar</title>
        <link rel="stylesheet" type="text/css" href="./CSS/style_info_privee.css"/>
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
                            <table width="720px">
                                <tr>
                                    <td colspan="2" style="background-color:#ffff99;text-align:center;">
                                        <h1>Bonjour <?php echo $ligne[1] . "&nbsp" . $ligne[2]; ?></h1>
                                    </td>
                                </tr>
                                <tr valign='top'>
                                    <td style="background-color:#F0F8FF;width:300px;height: 300px;text-align:left;">
                                        <?php
                                        require_once 'database.php';
                                        $DataBase = mysqli_connect(DB_host, DB_user, DB_password, DB_name);
                                        $requete2 = "select * from photo where $user_id=user_id";
                                        $resultat2 = mysqli_query($DataBase, $requete2);
                                        if ($resultat2) {
                                            $ligne1 = mysqli_fetch_array($resultat2, MYSQLI_NUM);
                                            if ($ligne1[0] != 0) {
                                                $url1 = $ligne1[2];
                                                echo "<img src='$url1'>";
                                                echo "<button type='button' value='Valider' onclick='checkphoto(this)'>Modifier</button>";
                                            } else {
                                                echo "<form method='post' action = 'informations_privees.php' enctype='multipart/form-data'>"
                                                . "<label style='color: chocolate; font-family: 'Meiryo';'>Ajouter votre photo</label>"
                                                . "<input name='image' id='image' type='file'>"
                                                . "<input type='submit' name='S' value='Upload'>"
                                                . "</form>";
                                            }
                                        } else {
                                            echo mysqli_errno($DataBase);
                                        }
                                        ?>
                                    </td>
                                    <td style="background-color: #F0F8FF;text-align: top;">
                                        <h2 style="text-align: center;font-family: 'Times';">Informations personnelles</h2>
                                        <ul>
                                            <li>Civilité:<?php echo $ligne[3]; ?></li>
                                            <li>Nom:<?php echo $ligne[1]; ?></li>
                                            <li>Prénom:<?php echo $ligne[2]; ?></li>
                                            <li>E-mail Addresse:<?php echo $ligne[4]; ?></li>
                                            <li>Année de naissance:<?php echo $ligne[5]; ?></li>
                                            <li>Compte solde:<?php echo $ligne3[0]; ?>€</li>
                                            <li>Appreciation moyenne:<?php echo $note_moyenne; ?></li>
                                        </ul>
                                    </td>
                                </tr>     
                            </table>
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
            function checkphoto(input) {
                window.location.href = 'informations_privees_1.php';
            }
            function checkmes(input) {
                window.location.href = 'page_messagerie.php';
            }
        </script>
    </body>
</html>