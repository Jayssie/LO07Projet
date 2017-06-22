<!DOCTYPE html>
<?php
if (isset($_POST['login']) and ( !empty($_POST['login'])) and isset($_POST['mdp']) and ( !empty($_POST['mdp']))) {
    $login = $_POST['login'];
    $mdp = $_POST['mdp'];
    $user_id = 0;
    if (($login == 'admin')and ( $mdp == 'admin')) {
        header("Location:index_admin.php");
        exit();
    } else {
        require_once 'database.php';
        $DataBase = mysqli_connect(DB_host, DB_user, DB_password, DB_name);
        $requete = "select * from utilisateur where login='$login' and mot_de_password ='$mdp'";
        $resultat = mysqli_query($DataBase, $requete);
        if ($resultat) {
            $ligne = mysqli_fetch_array($resultat, MYSQLI_NUM);
            if (!empty($ligne)) {
                printf("id=%d : login=%s : mdp=%s : is_conducteur=%s \n<br />", $ligne[0], $ligne[1], $ligne[2], $ligne[3]);
                $user_id = $ligne[0];
                header("Location:informations_privees.php");
                session_start();
                $_SESSION["login"] = $_POST["login"];
                $_SESSION["mdp"] = $_POST["mdp"];
                $_SESSION["user_id"] = $user_id;
            } else {
                echo "<script type='text/javascript'> alert('Bad credentials: Login ou mot de password n\'exist pas.');</script>";
            }
        } else {
            echo (mysqli_error($DataBase));
        }
        mysqli_close($DataBase);
    }
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="author" content="HE Guodong">
        <meta name="author" content="Hou Jie">
        <meta name="description" content="page de login">
        <title>Login | BlaBlaCar</title>
        <link rel="stylesheet" href="./CSS/style_login.css">
        <title></title>
    </head>
    <body>
        <form id="formlogin" method="post" action = "page_login.php" class="login">
            <p>
                <label for="login">Login:</label>
                <input type="text" name="login" id="login" value="Votre login">
            </p>

            <p>
                <label for="password">Password:</label>
                <input type="password" name="mdp" id="password">
            </p>
            <p class="login-submit">
                <button type="button" class="login-button" onclick="check(this)">Login</button>
            </p>

            <p class="forgot-password"><a href="page_inscrit.php">Pas encore membre?</a></p>
        </form>
        <script>
            function check(input) {
                var login = document.getElementById('login').value.trim();
                var mdp = document.getElementById('password').value.trim();
                if (login.length == 0 || mdp.length == 0) {
                    if (login.length == 0) {
                        alert("Rentrez votre login svp.");
                    }
                    if (mdp.length == 0) {
                        alert("Rentrez votre password svp.");
                    }
                } else {
                    document.getElementById('formlogin').submit();
                }
            }
        </script>
    </body>
</html>
