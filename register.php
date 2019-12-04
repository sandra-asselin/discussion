<?php include('configuration/config.php'); ?>
<?php
    $error = false;
        if(isset($_POST['regist']))
        {
            $db = $_SESSION['db'];
            $user = $_POST['username'];
            $mail = $_POST['email'];
            $result = mysqli_query($db, "SELECT count(id) AS same_users FROM utilisateurs WHERE login='$user' OR email='$mail'");
            $resultat = mysqli_fetch_all($result);
            if($resultat[0][0] == '0')
            {
                if($_POST['password'] == $_POST['cpassword'])
                {
                    $username = $_POST['username'];
                    $email = $_POST['email'];
                    $prenom = $_POST['prenom'];
                    $nom = $_POST['nom'];
                    $password = $_POST['password'];
                    register($username, $email, $prenom, $nom, $password);
                }
                else
                {
                    $error = true;
                    $msg = "Les mots de passe ne correspondent pas";
                }
            }
            else
            {
                $error = true;
                $msg = "Le nom d'utilisateur ou l'adresse mail est déjà utilisé";
            }
        }
    ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="images/icons/logos/logo.png"/>
    <title>FacePlateforme | Inscription</title>
</head>
<body>
    <main id="main_register">
        <h1>Inscription</h1>
        <form method="POST" action="register.php">
            <input type="text" name="username" placeholder="Nom d'utilisateur" required>
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="text" name="prenom" placeholder="Prénom" required>
            <input type="text" name="nom" placeholder="Nom" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <input type="password" name="cpassword" placeholder="Confirmer" required>
            <?php if($error == True){echo "<p style=\"margin: 0; color: red\">$msg</p>";} ?>
            <input type="submit" name="regist" value="S'inscrire">
        </form>
        <a href="login.php">Se connecter</a>
    </main>
    

</body>