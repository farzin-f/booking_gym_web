<?php if (isset($_GET['source'])) die(highlight_file(__FILE__, 1)); ?>

<!DOCTYPE html>
<html>
  <title>Travail Pratique #3</title>
  <head>

    <script language='javascript' src="../js/jquery-3.1.1.min.js"></script>
    <script language='javascript' src="../js/display.js"></script>
    <script language='javascript' src="../js/calendar.js"></script>
    <script language='javascript' src="../js/tabs.js"></script>

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
      echo "<a href='../index.html'>Cliquez Ici</a>";
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
    
    echo "<h2>Page d'administration du syst&egrave;me</h2>";
    echo "<h3>Bienvenue $prenom</h3>";
    ?>

  </head>

  <body>
    <!-- Onglets-->
    <div class="tab">
      <button class="tablinks" onclick="openTab(event, 'joueur')">Liste et historique des joueurs</button>
      <button class="tablinks" onclick="openTab(event, 'reserver')" id="boutonRes">Disponibilit&eacute;s et r&eacute;servation</button>
    </div>
    
    <!-- Section réservation/disponibilités -->
    <div id="reserver" class="tabcontent">
       <?php
            $timestamp = strtotime("next wednesday");       
            echo "<h3>Disponibilit&eacute; des terrains pour le ".date('y-m-d', $timestamp)."</h3>";
      ?>
      <p>
        
        <!-- Options pour l'affichage-->
        <table>
        <tr><th colspan="2">Options d'affichage</th></tr>
        <tr><td>
            <!-- Afficher l'horaire complet-->
            <form id="formAfficherTout" method="POST">
              Afficher l'horaire complet de la journ&eacute;e <button type="submit" >Afficher tout</button>
              <input type="hidden" name='action' value="afficherTout" />
            </form>
        </td>
        
        <td>
            <!-- Filtrer l'horaire par intervalle de temps-->
        <form id="formIntervalle" action="admin.php" method="POST">
          Afficher l'intervalle de           
          <select id="hd" name="intervalleD">
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
          </select>  heures
          &agrave;
          <select id="hf" name="intervalleF">
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
          </select> heures 
          <button type="submit" >Afficher</button>
          <input type="hidden" name='action' value="afficherIntervalle" />
        </form>

        <form id="formRes" action="admin.php" method="POST">
          <input type="hidden" id="terrSel"  name="terrSel">
          <input type="hidden" id="heureSel" name="heureSel">
          <input type="hidden" name="action" value="reserver">
        </form>

        <form id="formAnnuler" action="admin.php" method="POST">
          <input type="hidden" name="action" value="annuler">
        </form>
       </tr></td>
       </table>
       
        <h4>Cliquez sur une plage horaire pour la r&eacute;server. Si vous avez d&eacute;j&agrave; effectu&eacute; une r&eacute;servation, cliquez sur celle-ci pour l'annuler.</h4>
      
      </p>
      
      <!-- Génération de l'horaire-->
      <p class="table">
        <?php
        include("reservation.php");
        ?>
      </p>
    </div>

    <!-- Section historique/liste des joueurs-->
    <div id="joueur" class="tabcontent">
      <h3>Joueurs</h3>
      <p>
        <?php
        include("../db/openDB.php");

        $req = "SELECT *  FROM joueurs";
        $res = mysql_query($req, $conn);

        //Récupère tous les joueurs et affiche leur historique
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
      </p>
    </div>

</body>
</html>
