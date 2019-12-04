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
    if(isset($_POST['post']))
    {
        $title = $_POST['title'];
        $message = $_POST['message'];
        post($title, $message);
        $nb_postrequete = "SELECT count(id_auteur) FROM posts WHERE id_auteur = $id";
        $nb_postquery = mysqli_query($db, $nb_postrequete);
        $nb_postresult = mysqli_fetch_all($nb_postquery);
        $_SESSION['nb_post'] = $nb_postresult[0][0];
    }
    $db = $_SESSION['db'];
    $id = $_SESSION['id'];
    $requete = "SELECT posts.titre, posts.message, utilisateurs.login, utilisateurs.avatar FROM posts INNER JOIN utilisateurs ON posts.id_auteur = utilisateurs.id WHERE utilisateurs.id = '$id' ORDER BY posts.id DESC";
    $query = mysqli_query($db, $requete);
    $result = mysqli_fetch_all($query);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="images/icons/logos/logo.png"/>
    <title>FacePlateforme | Mon profil</title>
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
                    <h3><?php echo $_SESSION['username']; ?></h3>
                </div>
            </div>
        </section>
        <section id="outils">
            <div id="posts_tools">
                <div id="create_post">
                    <form action="profil.php" method="post">
                        <div id="post_infos">
                            <input type="text" name="title" placeholder="Titre" required autocomplete="off">
                            <input type="submit" name="post" value="Poster" required autocomplete="off">
                        </div>
                        <div id="post_message">
                            <textarea name="message" cols="30" rows="10" placeholder="Comment vous sentez vous aujourd'hui ?" required></textarea>
                        </div>
                    </form>
                </div>
                <div id="timeline">
                <?php
        if(!empty($result))
        {
            $i = 0;
            foreach($result as $key)
            {
                $titre = $result[$i][0];
                $message = $result[$i][1];
                $auteur = $result[$i][2];
                $avatar = $result[$i][3];
                echo "<div class=\"post\">";
                echo "<div id=\"post_author_infos\">";
                echo "<div id=\"author_avatar\">";
                echo "<img src=\"$avatar\">";
                echo "</div>";
                echo "<div id=\"author_username\">";
                echo "<h4>$auteur</h4>";
                echo "</div></div>";
                echo "<div id=\"post_message_infos\">";
                echo "<div id=\"post_title\">";
                echo "<h5>$titre</h5>";
                echo "</div>";
                echo "<div id=\"post_message\">";
                echo "<p>$message</p>";
                echo "</div></div></div>";
            $i++;
            }
        }
        else
        {
            echo "<p style=\"text-align: center;\">".$_SESSION['username']." n'a rien posté actuellement</p>";
        }
        ?>
                </div>
            </div>
            <div id="infos_tools">
                <div id="infos">
                    <h3><?php echo $_SESSION['prenom']; ?></h3>
                    <h3><?php echo $_SESSION['nom']; ?></h3>
                    <h3><?php echo $_SESSION['email']; ?></h3>
                    <h3>Posts : <?php echo $_SESSION['nb_post']; ?></h3>
                    <form method="get" action="index.php">
                        <input type="submit" name="disc" value="Se déconnecter">
                    </form>
                </div>
                <div id="change_infos">
                       <form action="profil.php" method="post">
                       <input type="text" name="username" value="<?php echo $_SESSION['username'] ?>" required>
                       <input type="email" name="email" value="<?php echo $_SESSION['email'] ?>" required>
                       <input type="text" name="prenom" value="<?php echo $_SESSION['prenom'] ?>" required>
                       <input type="text" name="nom" value="<?php echo $_SESSION['nom'] ?>" required>
                       <input type="password" name="password" placeholder="Mot de passe" required>
                       <input type="password" name="cpassword" placeholder="Confirmer" required>
                       <input type="submit" name="modify" value="Modifier">
                    </form>
                    <?php
                    if($_SESSION['id'] == '1')
                    {
                        echo "<a href=\"admin.php\" style=\"color: white; text-decoration: none;\">Admin tool</a>";
                    }

                    if(isset($_POST['modify']))
                    {
                        $username = $_POST['username'];
                        $email = $_POST['email'];
                        $prenom = $_POST['prenom'];
                        $nom = $_POST['nom'];
                        $password = $_POST['password'];
                        $id = $_SESSION['id'];
                        $password = password_hash($password, PASSWORD_DEFAULT);
                        mysqli_query($db, "UPDATE utilisateurs SET login = '$username', password='$password', email='$email', prenom='$prenom', nom='$nom' WHERE id='$id'");
                    }
                    ?>
                </div>
            </div>
        </section>
    </main>
</body>