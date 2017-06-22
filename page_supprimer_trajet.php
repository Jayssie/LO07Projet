<!DOCTYPE html>
<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    header("Location:page_login.php");
}
if ((isset($_POST)) and ( !empty($_POST))) {
    $t_id = $_POST['ID'];
    $n = 0;
    require_once 'database.php';
    $DataBase = mysqli_connect(DB_host, DB_user, DB_password, DB_name);
    $requete111 = "SELECT nb_passager,ville_depart,ville_arrive,depart_date,depart_time FROM trajet WHERE t_id = $t_id";
    $resultat111 = mysqli_query($DataBase, $requete111);
    $ligne111 = mysqli_fetch_array($resultat111, MYSQLI_NUM);
    $n = $ligne111[0];
    $vd = $ligne111[1];
    $va = $ligne111[2];
    $dd = $ligne111[3];
    $dt = $ligne111[4];
    $requete11 = "SELECT compte FROM utilisateur WHERE id = $user_id";
    $resultat11 = mysqli_query($DataBase, $requete11);
    $ligne11 = mysqli_fetch_array($resultat11, MYSQLI_NUM);
    $compte_c = $ligne11[0] - (10 * $n);

    $requete22 = "UPDATE utilisateur SET compte = $compte_c WHERE id = $user_id";
    $resultat22 = mysqli_query($DataBase, $requete22);

    $requete00 = "SELECT passager_id,sum(nb_passager) FROM reservation where trajet_id=$t_id group by passager_id ";
    $resultat00 = mysqli_query($DataBase, $requete00);
    if ($resultat00) {
        while ($ligne00 = mysqli_fetch_array($resultat00, MYSQLI_NUM)) {
            $p_id = $ligne00[0];
            $n = $ligne00[1];
            $date = date('d-m-Y H:i:s');
            $requete77 = "insert into messagerie values(0,$user_id,$p_id,'On vous informe que votre trajet de $vd à $va le $dd à $dt est supprimé','$date')";
            $resultat77 = mysqli_query($DataBase, $requete77);
            if ($resultat77) {
                
            } else {
                echo (mysqli_error($DataBase));
            }
            $requete001 = "SELECT compte FROM utilisateur WHERE id = $p_id";
            $resultat001 = mysqli_query($DataBase, $requete001);
            $ligne001 = mysqli_fetch_array($resultat001, MYSQLI_NUM);
            if ($requete001) {
                $compte_p = $ligne001[0] + (10 * $n);
                $requete002 = "UPDATE utilisateur SET compte = $compte_p WHERE id = $p_id";
                $resultat002 = mysqli_query($DataBase, $requete002);
                if ($resultat002) {
                    
                } else {
                    echo mysqli_error($DataBase);
                }
            } else {
                echo mysqli_error($DataBase);
            }
        }
    } else {
        echo mysqli_error($DataBase);
    }

    $requete4 = "DELETE FROM reservation WHERE trajet_id = $t_id";
    $resultat4 = mysqli_query($DataBase, $requete4);
    if ($resultat4) {
    }else{
        echo mysqli_error($DataBase);
    }
    $requete3 = "DELETE FROM trajet WHERE t_id = $t_id";
    $resultat3 = mysqli_query($DataBase, $requete3);
    if ($resultat3) {
        header("Location:page_info_trajet.php");
        exit();
    }else{
        echo mysqli_error($DataBase);
    }
}
?>

