var divTab, rows, cols, ordreInit;

$(document).ready(function(){
  /* on(): pour attacher un evenement à tous les descendants d'un élément
   * ainsi que pour "bubble-up" un evenement jusqu'au élément "body"
   * http://api.jquery.com/on/
   */
  $("#reserver").on('click', '.clickable, .self', function () {
    var cellId = Number($(this).attr('id'));
    var cellClass =$(this).attr('class');
    var r;
    //alert(cellClass);
    if(cellClass == "self")
    {
      r = confirm("Voulez-vous annuler votre r\351servation?");
      if (r == true)
        document.getElementById('formAnnuler').submit();
    }
    else{
      var h = getRow(cellId)+5;
      var terr = getCol(cellId);
      r = confirm("Voulez-vous r\351server le terrain #"+terr+" \340 "+h+" heures?");
      if (r == true) {
        $('#terrSel').val(terr);
        $('#heureSel').val(h);
        document.getElementById('formRes').submit();
      } else {
        alert("Aucune reservation effectuee.");
      }
    }

  });
});


//Créer la balise table avec les plages horaires
function createTable(divId, heureDebut=6, heureFin=22) {

  divTab = $("#"+divId+" p.table");

  rows = heureFin - heureDebut + 1;
  cols = 6;

  divTab.empty(); // Remplace la table existante s'il y a lieu

  var table = $('<table/>').appendTo(divTab);

  //Ajuster à la fenêtre
  var w = $(window).width()*0.7;

  table.width(w);

  //creer le header de table
  var row = $('<tr/>').appendTo(table);
  var cell = $('<th/>').appendTo(row);
  cell.text("Heure ")
  for(i = 1; i < cols; ++i){
    cell = $('<th/>').appendTo(row);
    cell.text("Terrain "+(i))
  }

  //Générer la table
  for (i = 0; i < rows-1; i++) {
    row = $('<tr/>').appendTo(table);

    cell = $('<td/>').appendTo(row);
    cell.text((heureDebut+i)+" - "+ (heureDebut+i+1));
    cell.addClass("thClass");

    for (j = 1; j < cols; j++) {

      cell = $('<td/>').appendTo(row);
      cell.attr("id",(heureDebut-5+i)*cols+j);
      cell.addClass("clickable");
      //Décommenter la ligne suivante pour afficher les ID de chaque case (pour tests)
      //cell.text((heureDebut-5+i)*cols+j);

    }
  }
}

//Indique si la plage horaire est réservée ou non
function estReserve(cellId, self){
  //alert(self);
  if(self)
    $("#"+cellId).addClass("self").removeClass("clickable").text("Votre r\351servation");
  else
    $("#"+cellId).addClass("thClass").removeClass("clickable").text("R\351serv\351");
}

//Retourne le numéro de la ligne sur laquelle se trouve idx
function getRow(idx) {
  return Math.floor(idx/cols);
}

//Retourne le numéro de la colonne sur laquelle se trouve idx
function getCol(idx) {
  return idx%cols;
}

function showTableRes() {
  alert("showTableRes()");
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp = new XMLHttpRequest();
  } else {
    // code for IE6, IE5
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      createTable('reserver');
      alert(this.responseText);
      eval(this.responseText);

    }
  };
  xmlhttp.open("GET","../formulaire/reservation.php",true);
  xmlhttp.send();

}
