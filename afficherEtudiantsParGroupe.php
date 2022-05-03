<?php

include("connexion.php");
$erreur ="";
//Pour avoir la liste (select) des groupes dans la base
$list_etd="<option value=\"\">Pas de groupes</option>";
$req="SELECT code FROM groupe";
$reponse = $pdo->query($req);
if($reponse->rowCount()>0) {
	$groupes = array();
  $list_etd="";
while ($row = $reponse ->fetch(PDO::FETCH_ASSOC)) {
         $code= $row["code"];
         $list_etd.="<option value=\"$code\">$code</option>"; // stocker les options dans la variable list_etd
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCO-ENICAR Supprimer Groupe </title>
    <!-- Bootstrap core CSS -->
<link href="./assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap core JS-JQUERY -->
<script src="./assets/dist/js/jquery.min.js"></script>
<script src="./assets/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom styles for this template -->
    <link href="./assets/jumbotron.css" rel="stylesheet">

</head>
<body>
    

<?php include("header.php");?>
    <main role="main">
      <div class="jumbotron">
        <div class="container">
          <h1 class="display-4">Afficher la liste d'étudiants par groupe</h1>
          <p>Cliquer sur la liste afin de choisir un groupe!</p>
        </div>
      </div>

      <div class="container">
        <form id="myform" method="POST">
          <div class="form-group">
            <label for="classe">Choisir un groupe:</label><br />
            <select
              id="code"
              name="code"
              class="custom-select custom-select-sm custom-select-lg"
            >
              <?php echo $list_etd;?>
            </select>
          </div>
        </form>
     <button  type="button" class="btn btn-primary btn-block" onclick="refresh()" name="afficher_etd">Afficher</button>
     <br>
     <table id="rslt" class="table table-striped table-hover">

  </table>
     <div class="table-responsive"> 
  
 </div>
 </form> 
</div>  
</main>


<footer class="container">
    <p>&copy; ENICAR 2021-2022</p>
  </footer>

<script>
    function refresh() {
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
		var out="<tr><th>CIN</th><th>Nom</th><th>Prénom</th><th>Email</th><th>Classe</th></tr>";
		for ( i = 0; i < arr.length; i++) {
			out+="<tr><td>"+
			arr[i].cin +
			"</td><td>"+
			arr[i].nom+
			"</td><td>"+
			arr[i].prenom+
			"</td><td>"+
      arr[i].email+
			"</td><td>"+
			arr[i].classe+
			"</td></tr>" ;
		}
		out +="</table>";
		document.getElementById("rslt").innerHTML=out;
       }
       else document.getElementById("rslt").innerHTML="Aucune Inscription!";

    }
}
</script>
</body>

</html>