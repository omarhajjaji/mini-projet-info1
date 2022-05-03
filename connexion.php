<?php
//Connexion à la BD//
 $servername="localhost";
 $username="root";
 $password="";
 $dbname="gestion_etudiants";
try{
  $pdo=new PDO("mysql:host=$servername;dbname=$dbname","$username", $password);
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //echo"la connexion a ete bien etablie";
  }

catch(PDOException $e){
  //echo"la connexion a échoué:" . $e->getMessage();
}
?>