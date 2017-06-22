<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <?php
    $login='admin';
    if($login == 'admin'){
        echo "ok";
        header("Location:index_admin.php");
    }
    
    
    
    ?>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <table border="1">
            <tr>
                <td>100</td>
                <td>200</td>
                <td>300</td>
            </tr>
            <tr>
                <td>400</td>
                <td>500</td>
                <td>600</td>
            </tr>
        </table>
    </body>
</html>
