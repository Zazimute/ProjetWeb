<html>
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
</html>