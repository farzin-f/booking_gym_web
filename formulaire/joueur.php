<?php
if (isset($_GET['source'])) die(highlight_file(__FILE__, 1));
?>

<!DOCTYPE html>
<html>
<title>Travail Pratique #3</title>
<head>

  <script language='javascript' src="../js/jquery-3.1.1.min.js"></script>
  <script language='javascript' src="../js/display.js"></script>
  <script language='javascript' src="../js/calendar.js"></script>
  <script language='javascript' src="../js/tabs.js"></script>
  <script language='javascript' src="../js/historiqueAjax.js"></script>

  <link rel='stylesheet' type='text/css' href="../css/inputStyle.css">
  <link rel='stylesheet' type='text/css' href="../css/tableStyle.css">
  <link rel='stylesheet' type='text/css' href="../css/tabStyle.css">

  <form id="formDeconn" action="joueur.php" method="POST">
    <input style='float:right;' type='submit' class='butDeconn'
    value="Deconnecter">
    <input type='hidden' name='action' value='deconnecter'>
  </form>

  <?php
  session_start();
  if (empty($_SESSION['prenom']))
  {

    header("Cache-Control: no-cache, must-revalidate");
    session_destroy();
    echo "Vous n'etes pas connecte.<br />";
    echo "<a href='../index.html'>Cliquez Ici<>";
  }

  $prenom = ucfirst($_SESSION['prenom']);
  $action = $_POST['action'];
  
  //Log out
  if($action == "deconnecter")
  {
    session_destroy();
    //echo $action;
    header("Location: ../index.html");
  }
  echo "<h2>Page du joueur</h2>";
  echo "<h3>Bienvenue $prenom</h3>";
  ?>
</head>

<body>
    <!-- Onglets -->
  <div class="tab">
    <button class="tablinks" onclick="openTab(event, 'historique'); showTableHis()">Historique</button>
    <button class="tablinks" onclick="openTab(event, 'reserver')" id="boutonRes">Disponibilit&eacute;s et r&eacute;servation</button>
  </div>

    <!-- Section historique -->
  <div id="historique" class="tabcontent">
    <h3>Historique</h3>
    <p>
    </p>
  </div>

  <!-- Section réservation/disponibilités -->
  <div id="reserver" class="tabcontent">

       <?php
            $timestamp = strtotime("next wednesday");       
            echo "<h3>Disponibilit&eacute; des terrains pour le ".date('y-m-d', $timestamp)."</h3>";
      ?>
      <h4>Cliquez sur une plage horaire pour la r&eacute;server. Si vous avez d&eacute;j&agrave; effectu&eacute; une r&eacute;servation, cliquez sur celle-ci pour l'annuler.</h4>
     
    <p>  
    <form id="formRes" action="joueur.php" method="POST">
      <input type="hidden" id="terrSel"  name="terrSel">
      <input type="hidden" id="heureSel" name="heureSel">
      <input type="hidden" name="action" value="reserver">
    </form>

    <form id="formAnnuler" action="joueur.php" method="POST">
      <input type="hidden" name="action" value="annuler">
    </form>
    </p>
    
    <!-- Génération de l'horaire-->
      <p class="table">
        <?php
        include("reservation.php");
        ?>
      </p>
</div>

</body>
</html>
