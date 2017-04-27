<?php

//Configuration de BD
$db_user = "faridfaf_web";
$db_password = "fafp110F";
$db_host = "www-ens";
$db_name = "faridfaf_ift3225_tp3";


//étape 1: établir une connexion vers la base des données*/
$conn=mysql_connect($db_host, $db_user, $db_password) 
     or die (mysql_error());
//étape 2: on sélectionne la BD*/
mysql_select_db($db_name, $conn) or die ("Database does not exists.");
?>