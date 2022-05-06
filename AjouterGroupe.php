<?php
//verif session
session_start();
   if($_SESSION["autoriser"]!="oui"){
      header("location:login.php");
      exit();
   }


  $erreur="";
if(isset($_POST['ajouter_grp']))
{
  $code= $_POST['code'];
  $niveau= $_POST['niveau'];
  $nb_eleves= $_POST['nb_eleves'];
  $nb_AbsenceJ= $_POST['nb_AbsenceJ'];
  //connexion à la base 
  $nb_AbsenceNJ= $_POST['nb_AbsenceNJ'];
  include("connexion.php");

  $sel=$pdo->prepare("select code from groupe where code=? limit 1");
         $sel->execute(array($code));
         $tab=$sel->fetchAll();
         if(count($tab)>0)
            $erreur="<p style=\"color:red\">Groupe existe deja</p>";// Groupe existe déja
         else{
            $req="insert into groupe values ('$code','$niveau','$nb_eleves','$nb_AbsenceJ','$nb_AbsenceNJ')";
            $reponse = $pdo->exec($req) or die("error");
            $erreur ="<p style=\"color:green\">Groupe créé avec succès</p>";
         }  
         echo $erreur;

  
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCO-ENICAR Ajouter Groupe </title>
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
              <h1 class="display-4">Ajouter un Groupe</h1>
              <p>Remplir le formulaire ci-dessous afin d'ajouter un Grooupe!</p>
            </div>
          </div>

<div class="container">
 <form id="myform" method="post" action="">
     <!--
                        TODO: Add form inputs
                        Prenom - required string with autofocus
                        Nom - required string
                        Email - required email address
                        CIN - 8 chiffres
                        Password - required password string, au moins 8 letters et chiffres
                        ConfirmPassword
                        Classe - Commence par la chaine INFO, un chiffre de 1 a 3, un - et une lettre MAJ de A à E
                        Adresse - required string
                    -->
     <!--Code-->
     <div class="form-group">
       <div id="demo"><?php echo $erreur; ?></div>
     <label for="code">Code:</label><br>
     <input type="text" id="code" name="code" class="form-control" required pattern="INFO[1-3]{1}-[A-E]{1}"
     title="Pattern INFOX-X. Par Exemple: INFO1-A, INFO2-E, INFO3-C">
    </div>
     <!--Niveau-->
     <div class="form-group">
     <label for="niveau">Niveau:</label><br>
     <input type="int" id="niveau" name="niveau" class="form-control" required pattern="[1-3]{1}">
    </div>
     <!--Capacite-->
     <div class="form-group">
        <label for="nb_eleves">Nombre des Elèves:</label><br>
        <input type="int" id="nb_elevess" name="nb_eleves" class="form-control" required pattern="[0-9]{2}">
       </div>
     <!--Nombre d'absences justifiés-->
     <div class="form-group">
     <label for="nb_AbsenceJ">Nombre des absences jusitifiées:</label><br>
     <input type="int" id="nb_AbsenceJ" name="nb_AbsenceJ"  class="form-control" required pattern="[0-4]{1}" />
    </div>
     <!--Nombre d'absences non justifiées-->
     <div class="form-group">
     <label for="nb_AbsenceNJ">Nombre des absences non jusitifiées:</label><br>
     <input type="int" id="nb_AbsenceNJ" name="nb_AbsenceNJ" class="form-control"  required pattern="[0-4]{1}"/>
    </div>
     
     <!--Bouton Ajouter-->
     <button  type="submit" class="btn btn-primary btn-block" name=ajouter_grp>Ajouter</button>


 </form> 
</div>  
</main>


<footer class="container">
    <p>&copy; ENICAR 2021-2022</p>
  </footer>

<script  src="./assets/dist/js/inscrire.js"></script>
</body>
</html>