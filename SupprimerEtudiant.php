<?php
//verif session
session_start();
   if($_SESSION["autoriser"]!="oui"){
      header("location:login.php");
      exit();
   }

$erreur ="";

if(isset($_POST['supprimer_etd']))
{
  $cin= $_POST['cin'];

  
  
try{
  //Connexion à la base
include("connexion.php");
            $sel=$pdo->prepare("delete from etudiant where cin=?");
            $sel->execute(array($cin));
            if($sel->rowCount()>0){//test si il a trouvé la valeur
            $erreur ="<p style=\"color:green\">Etudiant $cin supprimé avec succès</p>";
            }else{
              $erreur ="<p style=\"color:red\">Pas d'etudiant avec ce cin</p>";
            }
         echo $erreur;
}catch(PDOException $e){
  $erreur = "<p style=\"color:red\">Un probleme est survenu</p>";
    echo $erreur;
}

  
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCO-ENICAR Supprimer etudiant </title>
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
              <h1 class="display-4">Supprimer un etudiant</h1>
              <p>Veuillez choisir le cin de l'etudiant à supprimer!</p>
            </div>
          </div>

<div class="container">
 <form id="myform" method="post" action="">
     <!--Code-->
    <div class="form-group">
    <div id="demo"><?php echo $erreur; ?></div>
     <label for="code">Code:</label><br>
     <input type="text" id="cin" name="cin" class="form-control" required pattern="[0-9]{8}" title="8 chiffres">
    </div>
     <button  type="submit" class="btn btn-primary btn-block" name="supprimer_etd">Supprimer</button>

 </form> 
</div>  
</main>


<footer class="container">
    <p>&copy; ENICAR 2021-2022</p>
  </footer>

<script  src="./assets/dist/js/inscrire.js"></script>
</body>
</html>