<html>
    
    
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="MiseEnPage.css" />
        <title>Projet Web</title>
        <p class="logo"><img src="logo.png" alt="LOGO ENSC" /></p>
        <h2>Site web pour la création, la gestion et le partage de projets des différents modules de l'ENSC.</h2>
    </head>
    
    
    <body>
        <nav>
            </br>
            <ul id="menu">
                <li><a href="Projets.php">Projets</a>
                        <ul>
                                <li><a href="Projets.php">Liste des projets</a></li>
                                <li><a href="AjoutProjet.php">Ajouter un projet</a></li>
                                <li><a href="ModificationProjet.php">Modifier un projet</a></li>
                                <li><a href="PostulerProjet.php">Postuler à un pojet</a></li>
                        </ul>
                </li>
                <li><a href="Informations.php">Informations / Liens</a>
                        <ul>
                                <li><a href="Informations.php">Informations et liens généraux</a></li>
                        </ul>
                </li>
                <li><a href="Modules.php">Modules</a>
                        <ul>
                                <li><a href="Modules.php">Liste des modules</a></li>
                        </ul>
                </li>
                <!--<li><a href="Enseignants.php">Enseignants</a>
                        <ul>
                                <li><a href="Enseignants.php">Liste des enseignants</a></li>
                        </ul>
                </li>-->
                <li><a href="Annuaire.php">Annuaire</a>
                        <ul>
                                <li><a href="Enseignants.php">Enseignants</a></li>
                                <li><a href="Etudiants.php">Etudiants</a></li>
                                <li><a href="Clients.php">Clients</a></li>
                                <li><a href="Contact.php">Contact administrateur</a></li>
                        </ul>
                </li>
                <li><a href="Profil.php">Mon profil</a>
                        <ul>
                                <li><a href="Profil.php">Modifications de vos informations personnelles</a></li>
                        </ul>
                </li>
                <li><a href="Connexion.php">Connexion / Inscription</a>
                        <ul>
                                <li><a href="Connexion.php">Connexion</a></li>
                                <li><a href="Inscription.php">Inscription</a></li>
                        </ul>
                </li>
            </ul>
        </nav>

        
        
        <section>
        </br></br>
        
        
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



            </br></br></br></br></br></br></br></br></br></br></br></br></br></br>
        </section>


        <footer>

            <p>Copyright ??? - Tous droits réservés - 
            <a href="Contact.php">Me contacter !</a></p>

        </footer>
            
        </form>
            
    </body>
</html>
