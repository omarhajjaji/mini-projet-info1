<?php
   try{
      $pdo=new PDO("mysql:host=localhost;dbname=test","root","");
   }
   catch(PDOException $e){
      echo $e->getMessage();
   }
?>