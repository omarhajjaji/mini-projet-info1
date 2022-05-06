<?php

include("connexion.php");
$erreur ="";
//Pour avoir la liste (select) des matieres de la base
$list_mat="<input name=\"matieres\" type=\"checkbox\" value=\"\"/>Pas de matieres</br>";
$req="SELECT id_mat FROM matiere";
$reponse = $pdo->query($req);
if($reponse->rowCount()>0) {
	$groupes = array();
  $list_etd="";
while ($row = $reponse ->fetch(PDO::FETCH_ASSOC)) {
         $code= $row["id_mat"];
         $list_etd.="<input name=\"matieres[]\" type=\"checkbox\" value=\"$code\"/>$code  |  "; // stocker les options dans la variable list_etd
    }
}
if(isset($_POST['valider']))
{
  $nom= $_POST['nom'];
  $prenom= $_POST['prenom'];
  $pass= md5($_POST['pass']);
  $repass= md5($_POST['repass']);
  $matieres= $_POST['matieres'];
  $login= $_POST['login'];

  if($pass != $repass){
   $erreur ="Mot de passe n'est pas identique";
   goto end;
}

  
  
  //try{
      $sel=$pdo->prepare("select * from enseignant where login=? limit 1");
         $sel->execute(array($login));
         $tab=$sel->fetchAll();
         if(count($tab)>0)
            {$erreur="Login existe déjà!";}
         else{
            $resp=$pdo->exec("insert into enseignant (nom,prenom,login,pass) values ('$nom','$prenom','$login','$pass')")  or die("error");
            foreach($matieres as $matiere){
            $resp=$pdo->exec("insert into prof_mat (id_mat,id_prof) values ('$matiere','$login')")  or die("error");
            }
            header("location:login.php");
         }

  /*}catch(PDOException $e){
  $erreur = "Un probleme est survenu";
  }*/

  end:
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>SCO-ENICAR Inscription Enseignant</title>

    <!-- Bootstrap core CSS -->
<link href="./assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./assets/dist/css/signin.css" rel="stylesheet">
  </head>
  <body class="text-center">
    
<form class="form-signin" method="POST" action="">
  <img class="mb-4" src="./assets/brand/user-login.svg" alt="" width="72" height="72">
  <h1 class="h3 mb-3 font-weight-normal">Veuillez créer votre compte</h1>
  <?php
  if($erreur!=""){
  echo "<p class=\"mt -5 mb-3 alert alert-danger\">".$erreur."</p>"; 
  }
  ?>
  <input type="text" class="form-control" name="nom" placeholder="Nom" required autofocus /><br />
  <input type="text" class="form-control" name="prenom" placeholder="Prénom" required /><br />
  <input type="text" class="form-control" name="login" placeholder="Login" required /><br />
  <input type="password" class="form-control" name="pass" placeholder="Mot de passe" required /><br />
  <input type="password" class="form-control" name="repass" placeholder="Confirmer Mot de passe" required />
  
     <label for="matiere">Matieres:</label>
              <?php echo $list_etd;?>
 </br>
    
  <button class="btn btn-lg btn-primary btn-block" name="valider" type="submit">S'inscrire</button>

  <p class="mt-5 mb-3 text-muted">&copy; SOC-Enicar 2021-2022</p>
</form>


    
  </body>
</html>
