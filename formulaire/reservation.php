<?php
include("../db/openDB.php");
session_start();
$surnom = $_SESSION['surnom'];

$action = $_POST['action'];

//Récupère id du joueur
$req = "SELECT id FROM joueurs WHERE surnom='$surnom'";
$res = mysql_query($req, $conn) or die (mysql_error());
$range = mysql_fetch_assoc($res);
$joueurId = $range['id'];

//Vérification de la date en cours
$timestamp = strtotime("next wednesday");
$today = strtotime("today");
$veille = strtotime("next wednesday -1 day");
//Décommenter la ligne suivante pour tester la réservation n'importe quel jour (sinon ne fonctionne que le mardi)
//$veille = strtotime("today");
$dateSel = date('y-m-d', $timestamp);

switch($action)
{
    //Effectuer une réservation
      case "reserver":
          if($today == $veille) {
              $terrSel = $_POST['terrSel'];
              $heureSel= $_POST['heureSel'];
              $reqRes = "INSERT INTO reservations VALUES($terrSel,$joueurId,'$dateSel','$heureSel:00:00')";
              
              $res = mysql_query($reqRes, $conn);
              if(!$res) {
                echo "<script>alert('Vous ne pouvez pas rÃ©server deux plages horaires dans la mÃªme journÃ©e.');</script>";
                }
           } else {
                echo "<script>alert('Les rÃ©servations ne peuvent se faire que la veille de la journÃ©e en cours.');</script>";
           }
              echo "<script> createTable('reserver');
                              $('#boutonRes').click(); </script>";
                              
          break;
    
      //Annuler une réservation
      case "annuler":
          $req = "DELETE FROM reservations WHERE joueurID=$joueurId AND res_date='$dateSel'";
          $res = mysql_query($req, $conn) or die (mysql_error());
          echo "<script> createTable('reserver');
                          $('#boutonRes').click(); </script>";
          break;

      //Afficher horaire selon un intervalle donné
      case 'afficherIntervalle':
          $heureDebut = $_POST["intervalleD"];
          $heureFin = $_POST["intervalleF"];
          echo "<script> createTable('reserver', $heureDebut, $heureFin);
                          $('#boutonRes').click(); </script>";
          break;
          
     //Afficher l'horaire complet
      case 'afficherTout':
          echo "<script> createTable('reserver');
                        $('#boutonRes').click(); </script>";
          break;
  
      default:
        echo "<script> createTable('reserver');</script>"; 
  }

//Identifier les plages horaires déjà réservées
$req = "SELECT * FROM joueurs,reservations WHERE joueurs.id=reservations.joueurId AND res_date='$dateSel'";
$res = mysql_query($req, $conn) or die (mysql_error());

while ( $range = mysql_fetch_assoc ( $res) )  {
  $resH = $range['res_time'];
  $terrain = $range['noTerrain'];

  for($i = 1; $i < 6; ++$i)
  {
    if($terrain == $i)
    {
      for($j = 1; $j < 17; ++$j)
      {
        if(($j+5) == $resH)
        {
          $self = (int)($surnom == $range['surnom']);
          echo "<script>estReserve(".($j*6+$i).",$self);</script>";
        }
      }
    }
  }

}

mysql_free_result($res);
include("../db/closeDB.php");
?>
