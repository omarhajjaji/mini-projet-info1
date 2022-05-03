<?php

$erreur ="";

if(isset($_POST['modifier_grp']))
{
  $code= $_POST['code'];
  $niveau= $_POST['niveau'];
  $nb_eleves= $_POST['nb_eleves'];
  $nb_AbsenceJ= $_POST['nb_AbsenceJ'];
  $nb_AbsenceNJ= $_POST['nb_AbsenceNJ'];
  
  
try{
  //Connexion à la base
include("connexion.php");
            $sel=$pdo->prepare("update groupe set niveau=? , nb_eleves=? , nb_AbsenceJ=? , nb_AbsenceNJ=?
                  where code=?");
            $sel->execute(array($niveau,$nb_eleves,$nb_AbsenceJ,$nb_AbsenceNJ,$code));
            if($sel->rowCount()>0){//test si il a trouvé la valeur
            $erreur ="<p style=\"color:green\">Succcès de modification</p>";
            }else{
              $erreur ="<p style=\"color:red\">Pas de groupe avec ce code</p>";
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
    <title>SCO-ENICAR Modifier Groupe </title>
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
              <h1 class="display-4">Modifier un Groupe</h1>
              <p>Veuillez bien choisir le code du groupe à modifier!</p>
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
     <button  type="submit" class="btn btn-primary btn-block" name="modifier_grp">Modifier</button>


 </form> 
</div>  
</main>


<footer class="container">
    <p>&copy; ENICAR 2021-2022</p>
  </footer>

<script  src="./assets/dist/js/inscrire.js"></script>
</body>
</html>