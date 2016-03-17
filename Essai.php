<html>
    <?php
    session_start();
    //session_destroy();
    require("connect.php");
    echo'<h2>Gestion des Eleves</h2>';
    if (!isset($_POST['eleve']) && !isset($_POST['nombre']) && !isset($_SESSION['eleve'])) {
        ?>
        <p>Souhaitez vous</p>
        <form action="Essai.php" method="post">
            <input type="radio" name="eleve" value="ajout"> Ajouter un ou des élève(s)<br>
            <input type="radio" name="eleve" value="supprime">Supprimer un ou des élève(s)<br>
            <input type="radio" name="eleve" value="modifie">Mettre à jour les informations d'un ou de plusieurs élève(s)<br>
            <input type="submit" value ="Valider"> </form>

        <?php
    }
    if (isset($_POST ['eleve']) || isset($_SESSION['eleve'])) {
        if (isset($_POST['eleve'])) {
            $_SESSION['eleve'] = $_POST['eleve'];
        }

        if ($_SESSION['eleve'] == 'ajout' && !isset($_POST ['nombre']) && !isset($_SESSION['nombre'])) {
            echo'<form action="Essai.php" method="post">';
            echo'Combien d\'ajouts souhaitez vous effectuer? <input type="number" name="nombre" min="1" required><br>';
            echo'<input type="submit" value ="Valider"> </form>';
            echo '<input type="hidden" name="eleve" value="ajout"';
        } elseif ($_SESSION['eleve'] == 'ajout' && isset($_POST['nombre'])) {
            $_SESSION['nombre'] = $_POST['nombre'];
            $i = $_POST['nombre'];
            echo '<p>Vous souhaitez ajouter ' . $i . ' élèves. Remplissez les champs ci-dessous:</p>';
            echo'<form action="Essai.php" method="post">';
            for ($c = 0; $c < $i; $c++) {
                echo'<p>Eleve ' . ($c + 1) . '<br>';
                echo 'Nom: <input type="text" name="Nom[]" required><br>';
                echo 'Prénom: <input type="text" name="Prenom[]" required><br></p>';
            }
            echo'<input type= "submit" value= "Envoyer">';
            echo '</form>';
        } elseif ($_SESSION['eleve'] == 'ajout' && isset($_SESSION['nombre'])) {
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
                $ajout2 = 'INSERT INTO est (DateHabilitation,IDType,IDPersonnel) VALUES ("GETDATE()","3","' . $data2['IDPersonnel'] . '")';
                $req5 = mysqli_query($BDD, $ajout2)or die('Erreur SQL !<br>' . $ajout2 . '<br>' . mysql_error());
            }
            unset($_SESSION['eleve']);
            unset($_SESSION['nombre']);
            echo '<a href="Essai.php">Retour à la gestion</a>';
        } elseif (isset($_SESSION['eleve']) && !isset($_POST['elevSupp'])) {// mettre dans la meme 
            $affichEleve = "SELECT Nom, Prenom, personnel.IDPersonnel FROM typepersonne, est, personnel WHERE typepersonne.IDType=est.IDType AND est.IDPersonnel=personnel.IDPersonnel AND est.IDType=3 ORDER BY Nom; ";
            $req4 = mysqli_query($BDD, $affichEleve);

            if ($_SESSION['eleve'] == 'supprime' && !isset($_POST['elevSupp'])) {
                echo '<p>Cochez les élèves à supprimer :</p>';
                            echo '<form action="Essai.php" method="post">';
            } else {
                echo '<p>Cochez les élèves à modifier :</p>';
                            echo '<form action="modifie.php" method="post">';
            }

            echo "<table>
                       <tr>
              <th></th>
              <th>Identifiant</th>
              <th>Nom </th>
              <th>Prenom </th>
              </tr>";
            while ($data3 = mysqli_fetch_array($req4)) {
                echo "<tr><td><input type='checkbox', name='elevSupp[]' value=" . $data3['IDPersonnel'] . "></td>";
                echo "<td>" . $data3['IDPersonnel'] . "</td>";
                echo "<td>" . $data3['Nom'] . "</td>";
                echo "<td>" . $data3['Prenom'] . "</td></tr>";
            }
            echo'</table><input type ="submit" value="Valider"/>';
            echo '</form>';
        } elseif (isset($_POST['elevSupp']) && $_SESSION['eleve'] == 'supprime') {
            $EleveSupp = $_POST['elevSupp'];
            $lg2 = count($EleveSupp);
            echo ' Vous avez supprimé :' . $lg2 . ' élèves: ';
            for ($c = 0; $c < $lg2; $c++) {
                $EleveASupprimer = "SELECT Nom, Prenom FROM personnel WHERE IDPersonnel='$EleveSupp[$c]'";
                $req6 = mysqli_query($BDD, $EleveASupprimer)or die('Erreur SQL !<br>' . $EleveASupprimer . '<br>' . mysql_error());
                $data4 = mysqli_fetch_array($req6);

                $suppression = "DELETE FROM est WHERE IDPersonnel='$EleveSupp[$c]'";
                $suppression2 = "DELETE FROM personnel WHERE Nom='" . $data4['Nom'] . "'";
                $req7 = mysqli_query($BDD, $suppression)or die('Erreur SQL!<br>' . $suppression . '<br>' . mysql_error());
                $req8 = mysqli_query($BDD, $suppression2)or die('Erreur SQL!<br>' . $suppression2 . '<br>' . mysql_error());
                echo $data4['Nom'] . " " . $data4['Prenom'] . '<br>';
            }
            unset($_SESSION['eleve']);
            echo '<a href="Essai.php">Retour à la gestion</a>';
        } elseif ($_SESSION['eleve'] == 'modifie') {
            echo'Je suis bien dans la page modification<br>';
            $eleveAModifier = $_POST['elevSupp'];

            unset($_SESSION['eleve']);
            echo '<a href="Essai.php">Retour à la gestion</a>';
        }
    }
    ?>
</html>