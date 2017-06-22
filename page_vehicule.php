<!DOCTYPE HTML>
<?php
require_once './Class/Vehicule.php';
session_start();
if (isset($_SESSION['user_id'])) {
    $login = $_SESSION["login"];
    $user_id = $_SESSION['user_id'];
} else {
    header("Location:page_login.php");
    exit();
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

?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="author" content="HE Guodong">
        <meta name="author" content="Hou Jie">
        <meta name="description" content="page d'ajouter une vehicule">
        <link rel="stylesheet" type="text/css" href="./CSS/style_aj_vehicule.css"/>
        <?php
        require_once 'database.php';
        $DataBase = mysqli_connect(DB_host, DB_user, DB_password, DB_name);
        $requete5 = "select user_id from conducteur where user_id='$user_id'";
        $resultat5 = mysqli_query($DataBase, $requete5);
        if ($resultat5) {
            $ligne = mysqli_fetch_array($resultat5, MYSQLI_NUM);
            if ($ligne[0] != 0) {
                echo "<script type='text/javascript'> alert('Vous avez une vehicule deja.');</script>";
                echo "<script type='text/javascript'>window.location.href = 'page_infovehicule.php';</script>";
                exit();
            } else {
                if (isset($_POST) and ( !empty($_POST))) {
                    $marque = $_POST['marque'];
                    $modele = $_POST['modele'];
                    $confort = $_POST['confort'];
                    $nb_de_place = $_POST['nb_de_place'];
                    $couleur = $_POST['couleur'];
                    $annee_de_mise_en_service = $_POST['annee_de_mise_en_service'];
                    $categorie = $_POST['categorie'];
                    $requete2 = "select * from passager where user_id='$user_id'";
                    $resultat2 = mysqli_query($DataBase, $requete2);
                    if ($resultat2) {
                        $ligne2 = mysqli_fetch_array($resultat2, MYSQLI_NUM);
                        $nom = $ligne2[1];
                        $prenom = $ligne2[2];
                        $sexe = $ligne2[3];
                        $email = $ligne2[4];
                        $anne = $ligne2[5];
                        $requete3 = "insert into conducteur values ('{$user_id}', '{$nom}', '{$prenom}', '{$sexe}', '{$email}', '{$anne}')";
                        $resultat3 = mysqli_query($DataBase, $requete3);
                        if ($resultat3) {
                        } else {
                            echo (mysqli_error($DataBase));
                        }
                    } else {
                        echo (mysqli_error($DataBase));
                    }
                    $requete4 = "update utilisateur u set u.is_conducteur=1 where u.id='{$user_id}'";
                    $resultat4 = mysqli_query($DataBase, $requete4);
                    if ($resultat4) {
                    } else {
                        echo (mysqli_error($DataBase));
                    }
                    $requete = "insert into vehicule values (0, '{$user_id}', '{$marque}', '{$modele}', '{$confort}', '{$nb_de_place}', '{$couleur}', '{$annee_de_mise_en_service}', '{$categorie}')";
                    $resultat = mysqli_query($DataBase, $requete);
                    if ($resultat) {
                    } else {
                        echo (mysqli_error($DataBase));
                    }
                    mysqli_close($DataBase);
                }
            }
        }
        ?>
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
                                        <form method='post' action="page_vehicule.php">
                                            <label>Marque</label>
                                            <select name = 'marque' value='choisissez' required='required'>                        
                                                <option value = 'Renault'>Renault</option>
                                                <option value = 'Citroen'>Citroen</option>
                                                <option value = 'Peugeot'>Peugeot</option>s
                                            </select>
                                            <br/><br/>

                                            <label>Modele</label>          
                                            <select name = 'modele' required='required'>                        
                                                <option value = 'Zoe'>Zoe</option>
                                                <option value = 'Clio'>Clio</option>
                                                <option value = 'Express'>Express</option>
                                                <option value = 'Laguna'>Laguna</option>
                                                <option value = 'C1'>C1</option>
                                                <option value = 'C2'>C2</option>
                                                <option value = 'C3'>C3</option>
                                                <option value = 'C4'>C4</option>
                                                <option value = '307'>307</option>
                                                <option value = '206'>206</option>
                                                <option value = '406'>406</option>
                                                <option value = '408'>408</option>
                                            </select>
                                            <br/><br/>

                                            <label>Confort</label>
                                            <select name = 'confort' value='Normal' required='required'>                                  
                                                <option value = 'Basique'>Basique</option>
                                                <option value = 'Normal'>Normal</option>
                                                <option value = 'Confort'>Confort</option>
                                                <option value = 'Luxe'>Luxe</option>
                                            </select>
                                            <br/><br/>

                                            <label>Nb de places</label>
                                            <select name = 'nb_de_place' value='4' required='required'>                                  
                                                <?php
                                                for ($i = 1; $i <= 9; $i++) {
                                                    echo "<option value = '$i'>$i</option>";
                                                }
                                                ?>
                                            </select>    

                                            <br/><br/>
                                            <label>Annee de mise en service</label>
                                            <select name = 'annee_de_mise_en_service' value='2015' required='required'>                                  
                                                <?php
                                                for ($i = 1990; $i <= 2015; $i++) {
                                                    echo "<option value = '$i'>$i</option>";
                                                }
                                                ?>
                                            </select>  
                                            <br/><br/>

                                            <label>Couleur</label>       
                                            <select name = 'couleur' value='noir' required='required'>                                  
                                                <option value = 'Noir'>noir</option>
                                                <option value = 'Bleu'>bleu</option>
                                                <option value = 'Vert'>vert</option>
                                                <option value = 'Rouge'>rouge</option>
                                                <option value = 'Orange'>orange</option>
                                                <option value = 'Gris'>gris</option>
                                                <option value = 'Jaune'>jaune</option>
                                                <option value = 'Blanc'>blanc</option>
                                                <option value = 'Dore'>doré</option>
                                                <option value = 'Mauve'>mauve</option>
                                                <option value = 'Marron'>marron</option>
                                                <option value = 'Rose'>rose</option>
                                            </select>
                                            <br/><br/>
                                            <label>Catégorie</label>
                                            <select name = 'categorie' value='Véhicule de tourisme' required='required'>                                  
                                                <option value = 'Vehicule de tourisme'>Véhicule de tourisme</option>
                                                <option value = 'Berline'>Berline</option>
                                                <option value = 'Cabriolet'>Cabriolet</option>
                                                <option value = 'Break'>Break</option>
                                                <option value = '4X4'>4x4</option>
                                                <option value = 'Vehicule_de_service'>Véhicule de service</option>
                                                <option value = 'Monospace'>Monospace</option>
                                                <option value = 'Petit utilitaire'>Petit utilitaire</option>
                                                <option value = 'Grand utilitaire'>Grand utilitaire</option>
                                                <option value = 'Vehicule sans permis'>Véhicule sans permis</option>
                                            </select>
                                            <br/><br/>
                                            <INPUT TYPE="submit" NAME="S" VALUE="Valider">
                                        </form>
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
