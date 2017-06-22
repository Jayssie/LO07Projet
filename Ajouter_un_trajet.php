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
$requete = "select is_conducteur from utilisateur where id='$user_id'";
$resultat = mysqli_query($DataBase, $requete);
if ($resultat) {
    $ligne = mysqli_fetch_array($resultat, MYSQLI_NUM);
    if ($ligne[0] == 0) {
        echo "<script type='text/javascript'> alert('Vous n\'etes pas encore un conducteur, ajoutez une vehicule premierement.');</script>";
        echo "<script type='text/javascript'>window.location.href = 'page_vehicule.php';</script>";
    }
} else {
    echo (mysqli_error($DataBase));
}
$requete0304 = "select count(receive_id) from messagerie where receive_id=$user_id";
$resultat0304 = mysqli_query($DataBase, $requete0304);
if ($resultat0304) {
    $ligne0304 = mysqli_fetch_array($resultat0304, MYSQLI_NUM);
    echo "<div style='position: absolute; top: 39px;right:210px;color:red;'><b id='nb_mes'>$ligne0304[0]</b></div>";
} else {
    echo mysqli_error($DataBase);
}
if (isset($_POST) and ( !empty($_POST))) {
    if (isset($_POST['trj']) and ( !empty($_POST['trj']))) {
        $trj = $_POST['trj'];
    } else {
        $trj = "";
    }
    $trjd = ucwords($_POST['trjd']);
    $trja = ucwords($_POST['trja']);
    $date_aller = $_POST['date_aller'];
    $time_aller = $_POST['time_aller'];
    $nb = $_POST['nb_place'];
    $prix = $_POST['prix'];

    require_once 'database.php';
    $DataBase = mysqli_connect(DB_host, DB_user, DB_password, DB_name);
    $requete1 = "insert into trajet values (0, '{$user_id}', '{$trj}', '{$trjd}','{$trja}','{$date_aller}','{$time_aller}','{$nb}','{$prix}',0,'{$nb}','non_effectue')";
    $resultat1 = mysqli_query($DataBase, $requete1);
    if ($resultat1) {
        
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
        <meta name="description" content="page d'ajouter un trajet">
        <title>Ajouter trajet | BlaBlaCar</title>
        <link rel="stylesheet" type="text/css" href="./CSS/style_aj_trajet.css"/>
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
                                <th><h2>Trajet</h2></th>
                                <tr>
                                    <td>
                                        <form method="post" id="formtrajet" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"> 
                                            <div>
                                                <input type="radio" name="trj" id="trj" value="Je fais le trajet une fois)">Je fais le trajet une fois
                                            </div>
                                            <div>
                                                <input type="radio" name="trj" id="trj" value="Je fais le trajet régulièrement">Je fais le trajet régulièrement
                                            </div>
                                    </td>
                                </tr>
                            </table>

                            <table width="600px" cellspacing=0 cellpadding=5>
                                <th><h2>Itineraire&nbsp&nbsp*</h2></th>
                                <tr><td><br/>                                      
                                        <label>&nbsp&nbsp&nbsp;Point de depart</label>
                                        <input type="text" name="trjd" id="trjd" placeholder='Exemple:Paris, Lyon'>
                                        <label>&nbsp&nbsp&nbsp;Point d'arrivee</label>
                                        <input type="text" name="trja" id="trja" placeholder='Exemple:Troyes, Lile'>                        
                                        <!--                                        </form>-->
                                    </td>
                                </tr>
                            </table>

                            <table width="600px" cellspacing=0 cellpadding=5>
                                <th><h2><pre>Date et Horaire &nbsp&nbsp*</pre></h2></th>
                                <tr>
                                    <td>
                                            <label>&nbsp&nbsp&nbsp;Date aller:</label> <br/><br/>
                                            <input type='date' name="date_aller" id="da" min=<?php echo date('Y-m-d') ?> max="2115-09-12">
                                            <input type="time" name="time_aller" id="ta"><br/><br/>
                                            <label>&nbsp&nbsp&nbsp;Nombre de places disponibles:</label> <br/><br/>
                                            <select name = 'nb_place'id="nb_place" required='required'>
                                            <?php
                                            $requeteC = "select nb_de_place from vehicule where proprietaire_id=$user_id";
                                            $resultatC = mysqli_query($DataBase, $requeteC);
                                            if ($resultatC) {
                                                $ligneC = mysqli_fetch_array($resultatC, MYSQLI_NUM);
                                                $nb = $ligneC[0];
                                                for ($i = 1; $i <= $nb; $i++) {
                                                    echo "<option value = '$i'>$i</option>";
                                                }
                                            }
                                            ?>
                                            </select>
                                            <br/><br/>
                                            <label>&nbsp&nbsp&nbsp;Prix/personne:</label> <br/><br/>
                                            <input type='text' name="prix" id="prix"><br/><br/>
                                        </form>   
                                        <br/>
                                        <button type='button' value='Valider' onclick="checksub(this)">Valider</button>
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
            function checksub(input) {
                var depart = document.getElementById('trjd').value.trim();
                var arv = document.getElementById('trja').value.trim();
                var da = document.getElementById('da').value.trim();
                var ta = document.getElementById('ta').value.trim();
                var nb = document.getElementById('nb_place').value.trim();
                var prix = document.getElementById('prix').value.trim();
                if (depart.length == 0 || arv.length == 0 || da.length == 0 || ta.length == 0 || nb.length == 0 || prix.length == 0) {
                    alert("Rentrez les champs marqués, svp.");
                    if (prix < 0) {
                        alert("Rentrez le prix par personne(valeur positive) svp.");
                    }
                } else {
                    if (prix < 0) {
                        alert("Rentrez le prix par personne(valeur positive) svp.");
                    }else{
                        document.getElementById('formtrajet').submit();
                    }
                }
            }
        </script>
    </body>
</html>