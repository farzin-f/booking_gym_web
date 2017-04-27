<?php
include("../db/openDB.php");

$req = "SELECT *  FROM joueurs";
$res = mysql_query($req, $conn);

while ( $range = mysql_fetch_assoc ($res) ) {
  $nom = $range['nom'];
  $prenom = $range['prenom'];
  $surnom = $range['surnom'];
  echo "<h4>$prenom $nom ($surnom)</h4>";
  $_SESSION['surnom_h'] = $surnom;

  include("historique.php");
}
mysql_free_result($res);
include("../db/closeDB.php");
?>
