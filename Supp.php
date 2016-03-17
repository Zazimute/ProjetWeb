<?php

require("connect.php");

session_start();

$EleveSupp = $_POST['elevSupp'];
$lg2 = count($EleveSupp);
echo ' Vous avez supprimé :'.$lg2.' élèves: ';
for ($c = 0; $c < $lg2; $c++) {
    $EleveASupprimer = "SELECT Nom, Prenom FROM personnel WHERE IDPersonnel='$EleveSupp[$c]'";
    $req6 = mysqli_query($BDD, $EleveASupprimer)or die('Erreur SQL !<br>' . $EleveASupprimer . '<br>' . mysql_error());
    $data4 = mysqli_fetch_array($req6);

    $suppression = "DELETE FROM est WHERE IDPersonnel='$EleveSupp[$c]'";
    $suppression2 = "DELETE FROM personnel WHERE Nom='".$data4['Nom']."'";// essayer '$EleveSupp[$c]'
    $req7=mysqli_query($BDD,$suppression)or die('Erreur SQL!<br>' . $suppression . '<br>' . mysql_error());
    $req8=mysqli_query($BDD,$suppression2)or die('Erreur SQL!<br>' . $suppression2 . '<br>' . mysql_error());
echo $data4['Nom']." ".$data4['Prenom'].'<br>';
}
unset($_SESSION['eleve']);
echo '<a href="GestionEleve.php">Retour à la gestion</a>';
        ?>

