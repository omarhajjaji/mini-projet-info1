<?php
   try{
      $pdo=new PDO("mysql:host=localhost;dbname=gestion_etudiants","root","");
   }
   catch(PDOException $e){
      echo $e->getMessage();
   }
?>