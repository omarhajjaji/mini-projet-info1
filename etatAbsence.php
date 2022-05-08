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
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCO-ENICAR Etat Absence</title>
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
              <h1 class="display-4">État des absences pour un groupe</h1>
              <p>Pour afficher l'état des absences, choisissez d'abord le groupe  et la periode concernée!</p>
            </div>
          </div>

<div class="container">
<form id="myform" action="" method="POST">
  <table><tr><td>Date de début (j/m/a) : </td><td>
    <input type="date" name="debut" size="10"  class="datepicker"/>
    </td></tr><tr><td>Date de fin : </td><td>
    <input type="date" name="fin" size="10"  class="datepicker"/>
    </td></tr></table>

<div class="form-group">
<label for="classe">Choisir une classe:</label><br>
<select id="classe" name="classe"  class="custom-select custom-select-sm custom-select-lg">
    <?php echo $list_grp;?>
</select>

</div>
<div class="form-group">
  <label for="matiere">Choisir une matiere:</label><br>
  <select id="matiere" name="matiere"  class="custom-select custom-select-sm custom-select-lg">
      <?php echo $list_mdl;?>
  </select>
  </div>
<button id="affAbsence" onclick="chercher()" type="button" class="btn btn-primary btn-block">Afficher</button>
<br>

<div class="table-responsive"> 
  <table  class="table table-striped table-hover">
  <thead>
  <tr class="gt_firstrow " ><th >CIN</th><th>Nom</th><th >Email</th><th >Nombre d'absences</th></tr>
  </thead>
  <tbody id="rslt">

  
  </tbody>
  <tfoot>
  </tfoot>
  </table>
  </div>

</form>
</div>  
</main>

<footer class="container">
    <p>&copy; ENICAR 2021-2022</p>
  </footer>

<script>
   function chercher()
    {
        
        var xmlhttp = new XMLHttpRequest();
        var url="http://localhost/MiniProj/mini-projet-info1/auth-php-mysql/chercherAbsence.php";
        
        //Envoie Req
        xmlhttp.open("POST",url,true);

        form=document.getElementById("myform");
        var formdata=new FormData(form);

        xmlhttp.send(formdata);
        

        //Traiter Res

        xmlhttp.onreadystatechange=function()
            {   
                if(this.readyState==4 && this.status==200){
                     console.log(this.responseText);
                     myFunction(this.responseText);
                  
                }
            }

        function myFunction(response){
		var obj=JSON.parse(response);
        if (obj.success==1)
        {
		var arr=obj.etudiants;
		var i;
		var out="";
		for ( i = 0; i < arr.length; i++) {
			out+="<tr><td>"+
			arr[i].cin +
			"</td><td>"+
			arr[i].nom+
			" "+
			arr[i].prenom+
			"</td><td>"+
      arr[i].email+
			"</td><td>"+
			arr[i].nbrAbs+
			"</td></tr>" ;
		}
		out +="</table>";
		document.getElementById("rslt").innerHTML=out;
       }
       else document.getElementById("rslt").innerHTML="Aucun etudiant absent!";

    }
}
</script>
</body>
</html>