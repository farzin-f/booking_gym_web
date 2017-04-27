<?php

include("../db/openDB.php");

$surnom= isset($_POST['nomConn']) ? $_POST['nomConn'] : NULL;
$pass= isset($_POST['passConn']) ? $_POST['passConn'] : NULL;

$req = "SELECT * FROM joueurs WHERE surnom='$surnom'";
$res = mysql_query($req) or die(mysql_error());

if(!$res)
{
    die("Probleme avec la requet ou la connexion.".mysql_error());
}

$range = mysql_fetch_assoc($res);

if(mysql_num_rows($res) == 0)
{
    echo "Votre surnom n'existe pas. Veuillez vous creer un compte.";
}
else
{
    session_start();

if ($pass == $range['motDePasse'])
{
    $_SESSION['prenom'] = $range['prenom'];
    $_SESSION['surnom'] = $range['surnom'];
    $_SESSION['surnom_h'] = $_SESSION['surnom'];
    //echo "pass correct <br />";
    if ($range['isGestionnaire'])
	header("Location: ../formulaire/admin.php");
    else
	header("Location: ../formulaire/joueur.php");
}
else
    echo "Votre mot de passe n'est pas correct.";
}

include("../db/closeDB.php");
//echo "nom: $nom et mot-d-pass: $pass";

?>