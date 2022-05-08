<?php
 session_start();
 if($_SESSION["autoriser"]!="oui"){
	header("location:login.php");
	exit();
 }
else {
include("../connexion.php");
$debut = $_REQUEST['debut'];
$fin = $_REQUEST['fin'];
$classe = $_REQUEST['classe'];
$matiere = $_REQUEST['matiere'];
//echo $debut."  ".$fin;
//exit();
$req="SELECT etudiant.cin,nom,prenom,email,classe, count(etudiant.cin) FROM 
etudiant, absence
WHERE etudiant.cin=absence.cin and dateAbs>='$debut' and dateAbs<='$fin' 
and classe ='$classe' and matiere='$matiere'
GROUP BY etudiant.cin,nom,prenom,email,classe
"; 
$reponse = $pdo->query($req);
if($reponse->rowCount()>0) {
	$outputs["etudiants"]=array();
while ($row = $reponse ->fetch(PDO::FETCH_ASSOC)) {
        $etudiant = array();
        $etudiant["cin"] = $row["cin"];
        $etudiant["nom"] = $row["nom"];
        $etudiant["prenom"] = $row["prenom"];
        $etudiant["email"] = $row["email"];
        $etudiant["classe"] = $row["classe"];
        $etudiant["nbrAbs"] = $row["count(etudiant.cin)"];
         array_push($outputs["etudiants"], $etudiant);
    }
    // success
    $outputs["success"] = 1;
     echo json_encode($outputs);
} else {
    $outputs["success"] = 0;
    $outputs["message"] = "Pas d'étudiants";
    // echo no users JSON
    echo json_encode($outputs);
}
}
?>