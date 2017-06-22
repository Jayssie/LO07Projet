<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
if (isset($_SESSION['user_id']) && !empty($_SESSION)) {
    unset($_SESSION['login']);
    unset($_SESSION['mdp']);
    unset($_SESSION['user_id']);
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        sleep(2);
        header("Location:page_login.php");
        exit();
        ?>
    </body>
</html>
