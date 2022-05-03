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

//Modification des données de l'utilisateur
if(isset($_POST['modifier_etd']))
{
$cin=$_POST['cin'];
$nom=$_POST['nom'];
$prenom=$_POST['prenom'];
$email=$_POST['email'];
$adresse=$_POST['adresse'];
$pwd=md5($_POST['pwd']);
$cpwd=md5($_POST['cpwd']);
$classe=$_POST['classe'];

if($pwd != $cpwd){
   $erreur ="<p style=\"color:red\">Mot de passe n'est pas identique</p>";
   goto fin;
}
  
try{
            $sel=$pdo->prepare("update etudiant set nom=? , prenom=? , email=? , adresse=? , password=? 
            , cpassword=? , classe=? where cin=?");
            $sel->execute(array($nom,$prenom,$email,$adresse,$pwd,$cpwd,$classe,$cin));
            if($sel->rowCount()>0){//test si il a trouvé la valeur
            $erreur ="<p style=\"color:green\">Succcès de modification</p>";
            }else{
              $erreur ="<p style=\"color:red\">Pas d'etudiant avec ce code</p>";
            }
         
}catch(PDOException $e){
  $erreur = "<p style=\"color:red\">Un probleme est survenu $e</p>";
}
fin:

}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCO-ENICAR Modifier Etudiant</title>
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
              <h1 class="display-4">Modifier un étudiant</h1>
              <p>Saisir le numero de CIN pour trouver l'etudiant ensuite le modifier!</p>
            </div>
          </div>


<div class="container">
    <!--Recherche-->
 <form id="formCherch" method="GET">
     <!--CIN-->
     <div class="form-group">
    <div id="err"><?php echo $erreur; ?></div>
     <label for="cin">CIN:</label><br>
     <input type="text" id="cinCher" name="cin"  class="form-control" required pattern="[0-9]{8}" title="8 chiffres"/>
    </div>
     <!--Bouton Chercher-->
     <button  type="button" onclick="chercher()" class="btn btn-primary btn-block">Chercher</button>
     <div id="error"></div>
 </form> 
 <br>
 <!--Modification-->
  <form id="formMod" method="POST" action="" hidden>
     <div class="form-group">
     <label for="nom">Nom:</label><br>
     <input type="text" id="nom" name="nom" class="form-control" required autofocus>
    </div>
     <!--Prénom-->
     <div class="form-group">
     <label for="prenom">Prénom:</label><br>
     <input type="text" id="prenom" name="prenom" class="form-control" required>
    </div>
     <!--Email-->
     <div class="form-group">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" class="form-control" required>
       </div>
    <!--CIN-->
     <div class="form-group" hidden>
     <label for="cin">CIN:</label><br>
     <input type="text" id="cin" name="cin"  class="form-control" required pattern="[0-9]{8}" title="8 chiffres"/>
    </div>
     <!--Password-->
     <div class="form-group">
     <label for="pwd">Mot de passe:</label><br>
     <input type="password" id="pwd" name="pwd" class="form-control"  required pattern="[a-zA-Z0-9]{8,}" title="Au moins 8 lettres et nombres"/>
    </div>
    <!--ConfirmPassword-->
    <div class="form-group">
        <label for="cpwd">Confirmer Mot de passe:</label><br>
        <input type="password" id="cpwd" name="cpwd" class="form-control"  required/>
    </div>
     <!--Classe-->
     <div class="form-group">
     <label for="classe">Classe:</label><br>
 
        <select
              id="classe"
              name="classe"
              class="custom-select custom-select-sm custom-select-lg"
            >
              <?php echo $list_etd;?>
            </select>
    </div>
     <!--Adresse-->
     <div class="form-group">
     <label for="adresse">Adresse:</label><br>
     <input id="adresse" name="adresse" rows="10" cols="30" class="form-control" required>
     </input>
    </div>
     <!--Bouton Ajouter-->
     <button  type="submit" name="modifier_etd" class="btn btn-primary btn-block">Modifier</button>
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

        form=document.getElementById("formCherch");
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
        document.getElementById("formMod").removeAttribute("hidden");//afficher le formulaire
        //remplir le formulaire avec les données de l'etudiant a modier
        document.getElementById("nom").value=arr[0].nom;
        document.getElementById("prenom").value=arr[0].prenom;
        document.getElementById("email").value=arr[0].email;
        document.getElementById("classe").value=arr[0].classe;
        document.getElementById("cin").value=arr[0].cin;
        document.getElementById("adresse").value=arr[0].adresse;
        document.getElementById("error").innerHTML="Etudiant trouvé! Vous pouvez modifier"
        document.getElementById("error").style.color="green";
       }
       else {document.getElementById("error").innerHTML="Aucune inscription avec ce CIN!";
            document.getElementById("error").style.color="red";}

    }
}
        
        
    </script>
</body>
</html>