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

    </br></br></br></br></br></br></br></br></br></br></br></br></br></br>
        </section>


        <footer>

            <p>Copyright ??? - Tous droits réservés - 
            <a href="Contact.php">Me contacter !</a></p>

        </footer>
            
        </form>
            
    </body>
</html>
