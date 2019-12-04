<?php include_once('configuration/config.php'); 
$db = $_SESSION['db'];
$id = $_SESSION['id'];
$nb_postrequete = "SELECT count(id_auteur) FROM posts WHERE id_auteur = $id";
$nb_postquery = mysqli_query($db, $nb_postrequete);
$nb_postresult = mysqli_fetch_all($nb_postquery);
$_SESSION['nb_post'] = $nb_postresult[0][0];
    if(!isset($_SESSION['username']))
    {
        header('Location: index.php');
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="images/icons/logos/logo.png"/>
    <title>FacePlateforme | Outil administrateur</title>
</head>
<body>
    <?php include_once('header.php'); ?>
    <main id="main_profil">
        <section id="user">
            <div id="user_infos">
                <div id="avatar">
                    <img src="<?php echo $_SESSION['avatar']; ?>">
                </div>
                <div id="username">
                    <h1><?php echo $_SESSION['username']; ?></h1>
                </div>
            </div>
        </section>
        <section id="users_admin">
            <?php
                $db = $_SESSION['db'];
                $users_infos = mysqli_query($db, "SELECT login, prenom, nom, email, avatar FROM utilisateurs");
                $result = mysqli_fetch_all($users_infos);
            
                $i = 0;
                foreach($result as $key)
                {
                    $login = $result[$i][0];
                    $prenom = $result[$i][1];
                    $nom = $result[$i][2];
                    $email = $result[$i][3];
                    $avatar = $result[$i][4];
                    
                    echo "<h1>User".$i."</h1>";
                    echo "<p>Login : ".$login."</p>";
                    echo "<p>Prénom : ".$prenom."</p>";
                    echo "<p>Nom : ".$nom."</p>";
                    echo "<p>E-mail : ".$email."</p>";
                    echo "<p>Avatar : ".$avatar."</p>";
                $i++;
                }
            ?>
        </section>
    </main> 
</body>