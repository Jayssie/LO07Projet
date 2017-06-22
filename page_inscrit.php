<!DOCTYPE HTML>
<?php
require_once './Class/Utilisateur.php';
require_once './Class/Passager.php';
if (isset($_POST) and ( !empty($_POST))) {
    $sexe = $_POST['sexe'];
    $nom = strtoupper($_POST['nom']);
    $prenom = ucfirst($_POST['prenom']);
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $naissance = $_POST['naissance'];
    $login = strtolower($nom . $prenom);
    $user = $nom . $prenom;
    $u_id = 0;

    $user = new Utilisateur($login, $mdp, 0, 1);
    $pas = new Passager($nom, $prenom, $sexe, $email, $naissance);

    require_once 'database.php';
    $DataBase = mysqli_connect(DB_host, DB_user, DB_password, DB_name);
    $requete = "select id from utilisateur where login='$login'";
    $resultat = mysqli_query($DataBase, $requete);
    if ($resultat) {
        $ligne = mysqli_fetch_array($resultat, MYSQLI_NUM);
        if ($ligne[0] != 0) {
            echo "<script type='text/javascript'> alert('Nom et prenom a deja exist.');</script>";
            echo "<script type='text/javascript'>window.location.href = 'page_inscrit.php';</script>";
            exit();
        }
    } else {
        echo (mysqli_error($DataBase));
    }

    $requete1 = "insert into utilisateur values (0, '{$login}', '{$mdp}',0,1,1000)";
    $resultat1 = mysqli_query($DataBase, $requete1);
    $requete01 = "select id from utilisateur where login = '$login'";
    $resultat01 = mysqli_query($DataBase, $requete01);
    if ($resultat01) {
        while ($ligne = mysqli_fetch_array($resultat01, MYSQLI_NUM)) {
            $u_id = $ligne[0];
        }
    } else {
        echo (mysqli_error($DataBase));
    }

    $requete2 = "insert into passager values ('{$u_id}','{$nom}','{$prenom}','{$sexe}','{$email}','{$naissance}')";
    $resultat2 = mysqli_query($DataBase, $requete2);
    if ($resultat2) {
        session_start();
        $_SESSION["login"] = $login;
        $_SESSION["mdp"] = $mdp;
        $_SESSION["user_id"] = $u_id;
        echo "<script type='text/javascript'>window.location.href = 'informations_privees.php';</script>";
    } else {
        echo (mysqli_error($DataBase));
    }
    mysqli_close($DataBase);
}
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="author" content="HE Guodong">
        <meta name="author" content="Hou Jie">
        <meta name="description" content="page d'inscrit">
        <title>Inscription | BlaBlaCar</title>
        <link rel="stylesheet" type="text/css" href="./CSS/style_inscription.css"/>
    </head>
    <body>
        <div id="global">
            <div id="entete">
                <a href="index.php"><img src="images/logo.PNG" height="45" width="160"></a>
                <p class='sous-titre'>S'inscrire |
                    <a href="page_login.php">Se connecter</a> |
                    <a href="https://www.facebook.com/"><img src="images/index_2.PNG" height="20" width="43"></a>
                    <img src="images/index_3.PNG" height="20" width="33">
                </p>
            </div>
            <div id="centre">
                <div id="centre-bis">   
                    <div id='principal_1'>
                        <div id='navigation'>
<!--                            this is 1<br/>this is 2<br/>this is 3<br/>-->
                        </div>
                        <div id="pos">
                            <p>Pas encore membre ? Inscrivez-vous gratuitement</p>
                        </div>
                        <div id='principal_contenue_1'>
                            <h1>en 30 secondes avec une adresse email<br/><br/></h1>
                        </div>
                        <div id='principal_contenue_2'>
                            <form id="formpost" method='post' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >
                                <label>Civilité</label>
                                <select name = 'sexe' required='required' >                        
                                    <option value = 'homme' select='selected'>Homme</option>
                                    <option value = 'femme'>Femme</option>
                                    <br/>
                                </select>
                                <br/>
                                <div>            
                                    <input type='text' id="nom" name='nom' required='required' placeholder='Votre nom' ><span class='error'>* <div id="fauxnom" class="fauxmdpf"></div></span>
                                </div>
                                <br/>
                                <div>           
                                    <input type='text' id="prenom" name='prenom' required='required' placeholder='Votre prenom'><span class='error'>* <div id="fauxprenom" class="fauxmdpf"></div></span>
                                </div>
                                <br/>
                                <div>
                                    <input type='email' name='email' required='required' placeholder='Votre mail'/>
                                </div>
                                <br/>
                                <div>
                                    <input type='password' id='mdp' name='mdp' required='required' placeholder='Mot de passe' onBlur="checkLength('mdp')"/>
                                </div>
                                <br/>
                                <div id="fauxmdp" class="fauxmdpf"></div>
                                <div>
                                    <input type='password' name='cmdp' id='cmdp' required='required' placeholder='Confirmer le mot de passe encore une fois' onBlur="checkLength('cmdp')"/>                
                                </div>
                                <br/>
                                <label>Annee de naissance</label>
                                <select name = 'naissance' required='required'>
                                    <?php
                                    for ($i = 1920; $i <= 2014; $i++) {
                                        echo "<option value = '$i'>$i</option>";
                                    }
                                    ?>
                                </select>
                                <br/><br/><br/>
                                <button type='button' value='Valider' onclick="check(this)">Submit</button>
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
            function check(input) {
                var nom = document.getElementById('nom').value.trim();
                var prenom = document.getElementById('prenom').value.trim();
                if (nom.length == 0 || prenom.length == 0 || document.getElementById('cmdp').value != document.getElementById('mdp').value) {
                    if (nom.length == 0) {
                        document.getElementById("fauxnom").innerHTML = "Le forme est faux ";
                    } else {
                        document.getElementById("fauxnom").innerHTML = "";
                    }
                    if (prenom.length == 0) {
                        document.getElementById('fauxprenom').innerHTML = "Le forme est faux ";
                    } else {
                        document.getElementById('fauxprenom').innerHTML = "";
                    }
                    if (document.getElementById('cmdp').value != document.getElementById('mdp').value) {
                        document.getElementById('fauxmdp').innerHTML = "Cette valeur n'est pas valide.";
                    }
                } else {
                    document.getElementById('formpost').submit();
                }
            }
        </script>
        <script>
            function checkLength(pw) {
                var password = document.getElementById(pw);
                if (password.value.length < 6) {
                    alert("Le longueur doit etre superieur a 6");
                }
            }
        </script>
    </body>
</html>