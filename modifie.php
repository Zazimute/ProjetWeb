<?php

require("connect.php");

session_start();

if (!isset($_POST['elevModi'])) {
    $EleveMod = $_POST['elevSupp'];
    $_SESSION['nb']=$lg3 = count($EleveMod);
    echo ' Vous allez modifier ' . $lg3 . ' élèves.<br> ';
    echo 'Effectuez les changements souhaités :<br>';
    for ($c = 0; $c < $lg3; $c++) {
        $EleveModo = "SELECT IDPersonnel ,Nom, Prenom FROM personnel WHERE IDPersonnel='$EleveMod[$c]'";
        $req6 = mysqli_query($BDD, $EleveModo)or die('Erreur SQL !<br>' . $EleveModo . '<br>' . mysql_error());
        $data4 = mysqli_fetch_array($req6);
        $elevStock[$data4['IDPersonnel']] = array($data4['Nom'] => $data4['Prenom']);
    }

    function affichTab($tab) {
        foreach ($tab as $cle => $valeur) {
            '<tr>';
            if (is_array($valeur)) {
                echo "<input type='hidden', name= 'eleveID[]' value=" . $cle .">";
                echo '<td>' . $cle . '<td>';
                affichTab($valeur);
            } else {
                echo "<td><input type='text', name='elevModi[]' placeholder=" . $cle . "></td>";
                echo "<td><input type='text', name='elevModi2[]' placeholder=" . $valeur . "></td>";
            }
            echo'</tr>';
        }
    }

    echo '<form action="modifie.php" method="post">';
    echo "<table>
                       <tr>
              <th>ID</th>
              <th>Nom </th>
              <th>Prenom </th>
              </tr>";
    affichTab($elevStock);
    echo'</table><input type ="submit" value="Valider"/>';
    echo '</form><br>';
} else {
    $nouveauNom = $_POST["elevModi"];
    $nouveauPre = $_POST['elevModi2'];
    $idEleve = $_POST['eleveID'];


    for ($c = 0; $c < $_SESSION['nb']; $c++) {
        // si isset nom & prenom, si isset nom, si isset prenom
        $req9 = "UPDATE Personnel SET Nom='". $nouveauNom[$c] . "' Prenom='" . $nouveauPre[$c] . "' WHERE ID PERSONNEL ='" . $idEleve[$c] . "'";
        echo $req9;
    }
}    