<?php 
//verif session
session_start();
   if($_SESSION["autoriser"]!="oui"){
      header("location:login.php");
      exit();
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCO-ENICAR Chercher Etudiant</title>
    <!-- Bootstrap core CSS -->
<link href="./assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap core JS-JQUERY -->
<script src="./assets/dist/js/jquery.min.js"></script>
<script src="./assets/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom styles for this template -->
    <link href="./assets/jumbotron.css" rel="stylesheet">

</head>
<body>
    <!--Hello Nour -->
      <?php include("header.php");?>
<main role="main">
        <div class="jumbotron">
            <div class="container">
              <h1 class="display-4">Chercher un étudiant</h1>
              <p>Saisir le numero de CIN pour trouver l'etudiant!</p>
            </div>
          </div>


<div class="container">
 <form id="myForm" method="GET">
     <!--CIN-->
     <div class="form-group">
     <label for="cin">CIN:</label><br>
     <input type="text" id="cin" name="cin"  class="form-control" required pattern="[0-9]{8}" title="8 chiffres"/>
    </div>
     <!--Bouton Chercher-->
     <button  type="button" onclick="chercher()" class="btn btn-primary btn-block">Chercher</button>
 </form> 
 <br>
     <table id="rslt" class="table table-striped table-hover">

    </table>
</div>  

</main>


<footer class="container">
    <p>&copy; ENICAR 2021-2022</p>
  </footer>
<script>
    function chercher()
    {
        
        var xmlhttp = new XMLHttpRequest();
        var url="http://localhost/MiniProj/mini-projet-info1/auth-php-mysql/chercherEtd.php";
        
        //Envoie Req
        xmlhttp.open("POST",url,true);

        form=document.getElementById("myForm");
        var formdata=new FormData(form);

        xmlhttp.send(formdata);
        

        //Traiter Res

        xmlhttp.onreadystatechange=function()
            {   
                if(this.readyState==4 && this.status==200){
                     //console.log(this.responseText);
                     myFunction(this.responseText);
                  
                }
            }

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
       else document.getElementById("rslt").innerHTML="Aucune inscription avec ce CIN!";

    }
}
        
        
    </script>
</body>
</html>