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
$requete3 = "DELETE FROM photo WHERE user_id = $user_id";
$resultat3 = mysqli_query($DataBase, $requete3);
if ($resultat3) {
    echo "123123";
    header("Location:informations_privees.php");
} else {
    echo mysqli_errno($DataBase);
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
    </body>
</html>
