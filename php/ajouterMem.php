<?php
/*étape 1: établir une connexion vers la base des données*/
// $conn=mysql_connect("www-ens","faridfaf_web","fafp110F") or die (mysql_error());
/*étape 2: on sélectionne la BD*/
// mysql_select_db("faridfaf_ift3225_tp3",$conn) or die ("Database does not exists.");

include("../db/openDB.php");

/*étape 3:récupération des données*/
$nom= isset($_POST['nomAjout']) ? $_POST['nomAjout'] : NULL;
$prenom= isset($_POST['prenomAjout']) ? $_POST['prenomAjout'] : NULL;
$surnom= isset($_POST['surnomAjout']) ? $_POST['surnomAjout'] : NULL;
$pass= isset($_POST['passAjout']) ? $_POST['passAjout'] : NULL;


$res = mysql_query("SELECT * FROM joueurs WHERE surnom='$surnom'");

if(!$res)
{
    die("Probleme avec la requet ou la connexion.".mysql_error());
}

if(mysql_num_rows($res) == 0)
{
    session_start();
    
    /*étape 4:*/
    $req="INSERT INTO joueurs(nom, prenom, surnom, motDePasse) VALUE ('$nom','$prenom', '$surnom', '$pass')";
    mysql_query($req) or die(mysql_error());
    
    $_SESSION['prenom'] = $prenom;
    $_SESSION['surnom'] = $surnom;
    
    header("Location: ../formulaire/joueur.php");
}
else
{
    echo "Votre surnom existe deja.";
}

include("../db/closeDB.php");
?>

