<?php
include("../db/openDB.php");
session_start();
$surnom_h = $_SESSION['surnom_h'];
$dateFin = date('y-m-d', strtotime("next Wednesday +1 day"));
$dateDebut = date('y-m-d', strtotime("-1 month"));

$req_h = "SELECT noTerrain,res_date,res_time FROM joueurs,reservations WHERE joueurs.id=reservations.joueurId AND joueurs.surnom='$surnom_h' AND res_date BETWEEN '$dateDebut' AND '$dateFin'";
$res_h = mysql_query($req_h, $conn);

if(mysql_num_rows($res_h) == 0){
  echo "Ce membre n'a effectu&eacute; aucune r&eacute;servation.";
} else {

  echo '<table>';
  echo "<tr><th>Terrain</th> <th>Date</th> <th>Heure</th></tr>";
  while ( $rangee_h = mysql_fetch_assoc ($res_h) )  {
    $terrain = $rangee_h['noTerrain'];
    $resD = $rangee_h['res_date'];
    $resH = $rangee_h['res_time'];
    echo "<tr><td>$terrain</td> <td>$resD</td> <td>$resH</td></tr>";
  }
  echo '</table>';
}

mysql_free_result($res_h);
include("../db/closeDB.php");
?>
