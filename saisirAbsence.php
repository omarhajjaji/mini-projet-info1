<?php
//verif session
session_start();
   if($_SESSION["autoriser"]!="oui"){
      header("location:login.php");
      exit();
   }
include("connexion.php");
$erreur ="";
//Pour avoir la liste (select) des groupes de la base
$list_grp="<option value=\"\">Pas de groupes</option>";
$list_mdl="<option value=\"\">Pas de modules</option>";
$req="SELECT code FROM groupe";
$reponse = $pdo->query($req);
if($reponse->rowCount()>0) {
	$groupes = array();
  $list_grp="";
while ($row = $reponse ->fetch(PDO::FETCH_ASSOC)) {
         $code= $row["code"];
         $list_grp.="<option value=\"$code\">$code</option>"; // stocker les options dans la variable list_etd
    }
}
////Pour avoir la liste (select) des matieres de la base
$emailProf=$_SESSION['email'];
$req="SELECT id_mat FROM prof_mat WHERE id_prof='$emailProf'";
$reponse = $pdo->query($req);
if($reponse->rowCount()>0) {
	$matieres = array();
  $list_mdl="";
while ($row = $reponse ->fetch(PDO::FETCH_ASSOC)) {
         $id_mat= $row["id_mat"];
         $list_mdl.="<option value=\"$id_mat\">$id_mat</option>"; // stocker les options dans la variable list_mdl
    }
}

$nbrEtdGrp=0;

if(isset($_POST['valider']))
{
  include("connexion.php");
  $groupe = $_POST['code'];
  $matiere = $_POST['module'];
  $absences = $_POST['absences'];
  echo $groupe." ".$matiere."\n";
  foreach($absences as $absence){
    $cin = substr($absence,0,8);
    $date = substr($absence,8);
    $req="insert into absence values ('$cin','$groupe','$matiere',STR_TO_DATE('$date', '%d/%m/%Y'))";
            $reponse = $pdo->exec($req) or die("error");
    echo "--".$cin."; ".$date."\n";
  }
  header("location:index.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCO-ENICAR Saisir Absence</title>
    <!-- Bootstrap core CSS -->
<link href="./assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap core JS-JQUERY -->
<script src="./assets/dist/js/jquery.min.js"></script>
<script src="./assets/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom styles for this template -->
    <link href="./assets/jumbotron.css" rel="stylesheet">

</head>
<body>
<?php include("header.php"); ?>
      
<main role="main">
        <div class="jumbotron">
            <div class="container">
              <h1 class="display-4">Signaler l'absence pour tout un groupe</h1>
              <p>Pour signaler, annuler ou justifier une absence, choisissez d'abord le groupe, le module puis l'étudiant concerné!</p>
            </div>
          </div>

<div class="container">
<form method="POST" action="" id="myform">
<div class="form-group">
  <label for="semaine">Choisir une semaine:</label><br>
  <input id="semaine" type="week" name="debut" size="10" class="datepicker" required/>
</div>
  <div class="form-group">
<label for="classe">Choisir un groupe:</label><br>
<select
              id="code"
              name="code"
              class="custom-select custom-select-sm custom-select-lg"
            >
              <?php echo $list_grp;?>
            </select>
</div>


<div class="form-group">
  <label for="module">Choisir un module:</label><br>
  <select id="module" name="module"  class="custom-select custom-select-sm custom-select-lg">
      <?php echo $list_mdl;?>
  </select>
  </div>

  
 <!--Bouton Afficher-->
 <button id="affSem" type="button" class="btn btn-primary btn-block">Afficher semaine</button>
<br>
<table id="tableau" rules="cols" frame="box" hidden>
  <tr><th id="nbrEtd"></th>
  
<th colspan="2" width="100px" style="padding-left: 5px; padding-right: 5px;">Lundi</th>
<th colspan="2" width="100px" style="padding-left: 5px; padding-right: 5px;">Mardi</th>
<th colspan="2" width="100px" style="padding-left: 5px; padding-right: 5px;">Mercredi</th>
<th colspan="2" width="100px" style="padding-left: 5px; padding-right: 5px;">Jeudi</th>
<th colspan="2" width="100px" style="padding-left: 5px; padding-right: 5px;">Vendredi</th>
<th colspan="2" width="100px" style="padding-left: 5px; padding-right: 5px;">Samedi</th>
</tr><tr><td>&nbsp;</td>
<th colspan="2" id='dateJ1' width="100px" style="padding-left: 5px; padding-right: 5px;">07/03/2022</th>
<th colspan="2" id='dateJ2' width="100px" style="padding-left: 5px; padding-right: 5px;">08/03/2022</th>
<th colspan="2" id='dateJ3' width="100px" style="padding-left: 5px; padding-right: 5px;">09/03/2022</th>
<th colspan="2" id='dateJ4' width="100px" style="padding-left: 5px; padding-right: 5px;">10/03/2022</th>
<th colspan="2" id='dateJ5' width="100px" style="padding-left: 5px; padding-right: 5px;">11/03/2022</th>
<th colspan="2" id='dateJ6' width="100px" style="padding-left: 5px; padding-right: 5px;">12/03/2022</th>
</tr>

</table>
<br>
 <!--Bouton Valider-->
 <button id="valider" type="submit" name="valider" class="btn btn-primary btn-block" hidden>Valider</button>

</form>
</div>  
</main>

<footer class="container">
    <p>&copy; ENICAR 2021-2022</p>
  </footer>
<script>
  let button = document.getElementById('affSem');
button.onclick = () => {
  document.getElementById("tableau").removeAttribute("hidden");
  document.getElementById("valider").removeAttribute("hidden");
  button.disabled =true;
  let week = document.getElementById('semaine');
  let dates = parseDates(week.value);
  //console.log(dates);
  for(let i=0;i<6;i++){
    affichDate = document.getElementById('dateJ'+(i+1).toString());
    affichDate.innerHTML = dates[i].toLocaleDateString("fr");
   // console.log(dates[i],affichDate,(i+1).toString());
  }
  //REQUEST POUR AFFICHER LES ETUDIANTS DE CHAQUE GROUPE
         var xmlhttp = new XMLHttpRequest();
        var url = "http://localhost/MiniProj/mini-projet-info1/auth-php-mysql/afficherParGroupe.php";

    //Envoie de la requete
	xmlhttp.open("POST",url,true);
 

  form=document.getElementById("myform");

        var formdata=new FormData(form);
        xmlhttp.send(formdata);

     //Traiter la reponse
     xmlhttp.onreadystatechange=function()
            {  // alert(this.readyState+" "+this.status);
                if(this.readyState==4 && this.status==200){
                    myFunction(this.responseText);
                    //alert(this.responseText);
                    //console.log(this.responseText);

                }
            }


    //Parse la reponse JSON
	function myFunction(response){
		var obj=JSON.parse(response);
        if (obj.success==1)
        {
		var arr=obj.etudiants;
		var i;
    var out=``;
    document.getElementById("nbrEtd").innerHTML=arr.length.toString()+" Etudiants";
		for ( i = 0; i < arr.length; i++) {
			out+=`<tr class="row_3 text-center"><td><b>`+arr[i].nom +` `+arr[i].prenom+`</b></td>`;
      for(let j=0;j<6;j++){
          let value=arr[i].cin+dates[j].toLocaleDateString("fr"); //Pour identifier chaque checkbox
          out+=`<td colspan="2"><input name="absences[]" value="`+value+`" type="checkbox"></td>`
  
          }
 
      out+=`</tr>` ;
		}
    
		document.getElementById("tableau").innerHTML+=out;
       }
       else document.getElementById("etudiants").innerHTML="Aucune Inscription!";

    }

}
//fonction qui calcule et retourne les jours de la semaines (pour les afficher dans le tableau)
let parseDates = (inp) => {
  let year = parseInt(inp.slice(0,4), 10);
  let week = parseInt(inp.slice(6), 10);

  let day = (1 + (week ) * 7); // 1st of January + 7 days for each week

  let dayOffset = new Date(year, 0, 1).getDay(); // we need to know at what day of the week the year start

  dayOffset--;  // depending on what day you want the week to start increment or decrement this value. This should make the week start on a monday

  let days = [];
  for (let i = 0; i < 7; i++) // do this 7 times, once for every day
    days.push(new Date(year, 0, day - dayOffset + i)); // add a new Date object to the array with an offset of i days relative to the first day of the week
  return days;
}

</script>
</body>
</html>