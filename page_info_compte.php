<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="utf-8">
        <meta name="author" content="HE Guodong">
        <meta name="author" content="Hou Jie">
        <meta name="description" content="page d'info compte">
        <title>Page info compte | BlaBlaCar</title>
        <link rel="stylesheet" type="text/css" href="./CSS/style_info_compte.css"/>
    </head>
    <body>
        <div id="global">
            <div id="entete">
                <a href="index.php"><img src="images/logo.PNG" height="45" width="160"></a>
                <p class='sous-titre'> Vous êtes un administrateur.</p>
            </div>
            <div id="centre">
                <div id="centre-bis">   
                    <div id='principal_1'>
                        <div id='navigation'>                
                            <table bgcolor="#f4f4f4" width="200" cellspacing=0 cellpadding=5>
                                <tr class="change" onclick="check1(this)"><td>Affiche info compte</td></tr>
                                <tr class="change" onclick="check2(this)"><td>Affiche info trajet</td></tr>
                            </table>
                        </div>
                        <div id='principal_contenue'>
                            <?php
                            require_once 'database.php';
                            $DataBase = mysqli_connect(DB_host, DB_user, DB_password, DB_name);
                            $requete1 = "select * from utilisateur where not login = 'admin'";
                            $resultat1 = mysqli_query($DataBase, $requete1);
                            if ($resultat1) {
                                echo "<h2>Compte List</h2>"
                                . "<table width='700px'>"
                                . "<tr><td>UserID</td><td>Login</td><td>Mot_de_password</td>"
                                . "<td>Nom</td><td>Prenom</td><td>Sexe</td><td>Email</td><td>Naissance</td><td>VehiculeID</td>"
                                . "<td>Marque</td><td>Place</td><td>Annee_service</td></tr>";
                                while ($ligne = mysqli_fetch_array($resultat1, MYSQLI_NUM)) {
                                    echo "<tr><td>$ligne[0]</td>"
                                    . "<td>$ligne[1]</td>"
                                    . "<td>$ligne[2]</td> ";
                                    $requete2 = "select * from passager where user_id=$ligne[0]";
                                    $resultat2 = mysqli_query($DataBase, $requete2);
                                    if ($resultat2) {
                                        while ($ligne2 = mysqli_fetch_array($resultat2, MYSQLI_NUM)) {
                                            echo "<td>$ligne2[1] </td>"
                                            . "<td>$ligne2[2]</td>"
                                            . "<td>$ligne2[3]</td>"
                                            . "<td>$ligne2[4]</td>"
                                            . "<td>$ligne2[5]</td>";
                                        }
                                    } else {
                                        echo "2222222222";
                                    }
                                    $requete3 = "select * from vehicule where proprietaire_id=$ligne[0]";
                                    $resultat3 = mysqli_query($DataBase, $requete3);
                                    if ($resultat3) {
                                        $ligne3 = mysqli_fetch_array($resultat3, MYSQLI_NUM);
                                        if ($ligne3[0] != 0) {
                                            echo "<td>$ligne3[0]</td>"
                                            . "<td>$ligne3[2]</td>"
                                            . "<td>$ligne3[5]</td>"
                                            . "<td>$ligne3[7]</td></tr>";
                                        } else {
                                            echo "<td>Pas de vehicule definie</td><td></td><td></td><td></td></tr>";
                                        }
                                    } else {
                                        echo "333333333";
                                        echo (mysqli_error($DataBase));
                                    }
                                }
                                echo "</table>";
                            } else {
                                echo "11111111111";
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
                window.location.href = 'page_info_compte.php';
            }
            function check2(input) {
                window.location.href = 'page_info_trajet_admin.php';
            }
        </script>
        <?php
        // put your code here
        ?>
    </body>
</html>
