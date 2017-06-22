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
$requete = "select * from vehicule where proprietaire_id='$user_id'";
$resultat = mysqli_query($DataBase, $requete);
if ($resultat) {
    $ligne = mysqli_fetch_array($resultat, MYSQLI_NUM);
} else {
    echo mysqli_error($DataBase);
}
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="author" content="HE Guodong">
        <meta name="author" content="Hou Jie">
        <meta name="description" content="page d'indo vehicule">
        <title>Information vehicule | BlaBlaCar</title>
        <link rel="stylesheet" type="text/css" href="./CSS/style_aj_vehicule.css"/>
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
                            <table width="600px" cellspacing=0 cellpadding=5>
                                <th><h2>Véhicule</h2></th>
                                <tr>
                                    <td>
                                        Vehicule ID : &nbsp&nbsp;<?php echo $ligne[0]; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Proprietair ID :  &nbsp&nbsp;<?php echo $ligne[1]; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Marque :  &nbsp&nbsp;<?php echo $ligne[2]; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Modele :  &nbsp&nbsp;<?php echo $ligne[3]; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Confort :  &nbsp&nbsp;<?php echo $ligne[4]; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Nombre de place :  &nbsp&nbsp;<?php echo $ligne[5]; ?>
                                    </td>
                                </tr>  
                                <tr>
                                    <td>
                                        Couleur :  &nbsp&nbsp;<?php echo $ligne[6]; ?>
                                    </td>
                                </tr>        
                                <tr>
                                    <td>
                                        Anne de mise en service :  &nbsp&nbsp;<?php echo $ligne[7]; ?>
                                    </td>
                                </tr>          
                                <tr>
                                    <td>
                                        Catagorie:  &nbsp&nbsp;<?php echo $ligne[8]; ?>
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
        </script>
    </body>
</html>