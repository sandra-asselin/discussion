<?php include_once('configuration/config.php'); ?>
<?php
$_SESSION['error'] = false;
$msg = "Identifiant ou mot de passe incorrecte";

    if(isset($_POST['login']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        login($username, $password);
    }


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="images/icons/logos/logo.png"/>
    <title>FacePlateforme | Connexion</title>
</head>
<body>
    <main id="main_login">
        <h1>Connexion</h1>
        <form method="POST" action="login.php">
            <input type="text" name="username" placeholder="Nom d'utilisateur" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <?php if($_SESSION['error'] == 1){echo "<p style=\"margin: 0; color: red\">$msg</p>";} ?>
            <input type="submit" name="login" value="Se connecter">
        </form>
        <a href="register.php">S'inscrire</a>
    </main>
    

</body>