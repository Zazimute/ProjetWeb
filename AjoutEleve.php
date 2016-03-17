<?php
session_start();
require("connect.php");

$Nom = $_POST['Nom'];
$Prenom = $_POST['Prenom'];
echo "Vous avez ajouté : <br>";
$lg = count($Nom);
for ($c = 0; $c < $lg; $c++) {
    // ajout de l'étudiant dans la table "personnel"
    $ajout = 'INSERT INTO personnel (IDPersonnel, Nom, Prenom, DateDeNaissance, MotDePasse, Informations, Promotion, GroupeTD)VALUES ("","' . $Nom[$c] . '","' . $Prenom[$c] . '", "", "","", "", "")';
    echo $Nom[$c] . "  " . $Prenom[$c] . "<br>";
    $req2 = mysqli_query($BDD, $ajout)or die('Erreur SQL !<br>' . $ajout . '<br>' . mysql_error());
}

   // recherche de son ID en vu de l'ajout dans la table "est"
for ($c = 0; $c < $lg; $c++) {
    $rechercheIDPersonnel = "SELECT IDPersonnel FROM personnel WHERE Nom='$Nom[$c]'";
    $req3 = mysqli_query($BDD, $rechercheIDPersonnel) or die('Erreur SQL !<br>' . $rechercheIDPersonnel . '<br>' . mysql_error());
    $data2 = mysqli_fetch_array($req3);
    echo $data2['IDPersonnel'];
    // insertion de l'élève et du type élève dans la table est
    $ajout2 = 'INSERT INTO est (DateHabilitation,IDType,IDPersonnel) VALUES ("GETDATE()","3","'.$data2['IDPersonnel'].'")';
    $req5=mysqli_query($BDD,$ajout2)or die('Erreur SQL !<br>' . $ajout2 . '<br>' . mysql_error());

}

unset($_SESSION['eleve']);
unset($_SESSION['nombre']);
echo '<a href="GestionEleve.php">Retour à la gestion</a>';
?>

