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

$requete0304 = "select count(receive_id) from messagerie where receive_id=$user_id";
$resultat0304 = mysqli_query($DataBase, $requete0304);
if ($resultat0304) {
    $ligne0304 = mysqli_fetch_array($resultat0304, MYSQLI_NUM);
    echo "<div style='position: absolute; top: 39px;right:210px;color:red;'><b id='nb_mes'>$ligne0304[0]</b></div>";
} else {
    echo mysqli_error($DataBase);
}
if (isset($_POST) and ( !empty($_POST))) {
    $nom = strtoupper($_POST['nom']);
    $prenom = ucfirst($_POST['prenom']);
    $send_id = $user_id;
    if (isset($_POST['message']) and ( !empty($_POST['message']))) {
        $message = $_POST['message'];
    } else {
        $message = '';
    }

    $date = date('d-m-Y H:i:s');
    require_once 'database.php';
    $DataBase = mysqli_connect(DB_host, DB_user, DB_password, DB_name);
    $requete1 = "select user_id from passager where nom='$nom' and prenom='$prenom'";
    $resultat1 = mysqli_query($DataBase, $requete1);
    if ($resultat1) {
        $ligne1 = mysqli_fetch_array($resultat1, MYSQLI_NUM);
        if (!empty($ligne1)) {
            $receve_id = $ligne1[0];
            $requete12 = "insert into messagerie values(0,$send_id,$receve_id,'$message','$date')";
            $resultat12 = mysqli_query($DataBase, $requete12);
            if ($resultat12) {
                
            } else {
                echo (mysqli_error($DataBase));
            }
        } else {
            echo "<script type='text/javascript'> alert('Bad credentials: Nom ou prenom n\'exist pas.');</script>";
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
        <meta name="description" content="page de messagerie">
        <title>Page messagerie | BlaBlaCar</title>
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
                            <table width="600px" style="position:relative;top:30px;left:20px;">
                                <tr>
                                    <td width="100px">Envoyeur</td><td></td>
                                </tr>
                                <tr>                 
                                    <?php
                                    $message = '';
                                    $DataBase = mysqli_connect(DB_host, DB_user, DB_password, DB_name);
                                    $requete5 = "select c.nom,c.prenom from messagerie as m,passager as c where m.receive_id=$user_id and m.send_id=c.user_id";
                                    $resultat5 = mysqli_query($DataBase, $requete5);
                                    echo "<td>";
                                    if ($resultat5) {
                                        $ligne5 = mysqli_fetch_array($resultat5, MYSQLI_NUM);
                                        $requete50 = "select m.message,m.time,c.nom,c.prenom from messagerie as m,passager as c where m.receive_id=$user_id and m.send_id=c.user_id";
                                        $resultat50 = mysqli_query($DataBase, $requete50);
                                        while ($ligne50 = mysqli_fetch_array($resultat50, MYSQLI_NUM)) {
                                            $message = $message . $ligne50[1] . " <br/>" . $ligne50[0] . "<br/><br/>";
                                        }
                                        echo"<p onclick='document.getElementById(\"mes\").innerHTML=\"$message\"' > <b>$ligne5[1]&nbsp$ligne5[0]</b></p>";
                                    } else {
                                        echo mysqli_error($DataBase);
                                    }
                                    echo "</td>";
                                    ?> 
                                    <td id="mes"></td>
                                </tr>     
                            </table>
                            <form method="post" id="formnewmes" action="page_mesagerie.php" >
                                <div style='position:relative;top:125px;left:10px;'>
                                    <label><input id="send" name="send" type="hidden" value=<?php $user_id ?>></label>
                                    <label>Nom<input id="send_nom" name="nom" type="text" style="width:60px; "></label>
                                    <label>Prenom<input id="send_prenom" name="prenom" type="text"style="width:60px; "></label>
                                </div>
                                <label><input  id="message" name="message" style="width:400px;height: 200px; position:relative;top:100px;left:220px;" type="text"></label>
                                <button style='position:relative;top:190px;left:150px;' type='button' value='Valider' onclick="checknewmes(this)">Envoyer</button>
                            </form>
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
            function checknewmes(input) {
                var nom = document.getElementById('send_nom').value.trim();
                var prenom = document.getElementById('send_prenom').value.trim();
                if (nom.length == 0 || prenom.length == 0) {
                    if (nom.length == 0) {
                        alert('Rentrer le nom,svp.');
                    }
                    if (prenom.length == 0) {
                        alert('Rentrer le prenom,svp.');
                    }
                } else {
                    document.getElementById('formnewmes').submit();
                }
            }
        </script>
    </body>
</html>