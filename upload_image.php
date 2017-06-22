<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include "informations_privees.php";
echo("<pre>");
$uploaddir = 'documents/';
$uploadfile = $uploaddir . basename($_FILES['image ']['name']);
move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile);
?>
    