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


    if (!isset($_POST['identifiant'])) {
        ?>
        <p> Connectez vous <p/>
        <form method="post" action="Connexion.php"/>
        <p>
            Votre identifiant: <input type="text" name="identifiant" required/><br>
            Votre mot de passe <input type="text" name="password" required /><br>
            <input type="submit" value="Valider"/>
        </p>

        <?php
    } else {
        $password = $_POST['password'];
        $identifiant = $_POST['identifiant'];
        $sql = "SELECT MotDePasse FROM personnel WHERE Nom='$identifiant'";
        $req = mysqli_query($BDD, $sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
        $data = mysqli_fetch_array($req);

        if ($data['MotDePasse'] != $password) {
            echo '<p>Mauvais login / password. Merci de recommencer</p>';
            $_POST['identifiant'] = NULL;// Test 
           include('Connexion.php');
            exit;
        } else {
            $_SESSION['identifiant'] = $identifiant;


            echo 'Vous etes bien logué en tant que ' . $identifiant . '<br>';
            if ($_SESSION['identifiant'] == 'Gestionnaire') {
                echo'<a href="GestionEleve.php">Gestion des élèves</a></li>';
            }
        }
    }
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
