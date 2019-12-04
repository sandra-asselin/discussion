<?php include_once('configuration/config.php');
if(!isset($_SESSION['username']))
{
    header('Location: index.php');
} 
    $db = $_SESSION['db'];
    $iduser = $_GET['iduser'];
    $recup = mysqli_query($db, "SELECT login, email, prenom, nom, avatar FROM utilisateurs WHERE id='$iduser'");
    $resultat = mysqli_fetch_all($recup);
    $nb_postrequete = "SELECT count(id_auteur) FROM posts WHERE id_auteur = $iduser";
    $nb_postquery = mysqli_query($db, $nb_postrequete);
    $nb_postresult = mysqli_fetch_all($nb_postquery);
    $nb_post = $nb_postresult[0][0];
    $username = $resultat[0][0];
    $mail = $resultat[0][1];
    $prenom = $resultat[0][2];
    $nom = $resultat[0][3];
    $avatar = $resultat[0][4];

    $requete = "SELECT posts.titre, posts.message, utilisateurs.login, utilisateurs.avatar FROM posts INNER JOIN utilisateurs ON posts.id_auteur = utilisateurs.id WHERE utilisateurs.id = '$iduser' ORDER BY posts.id DESC";
    $query = mysqli_query($db, $requete);
    $result = mysqli_fetch_all($query);

    if($iduser == $_SESSION['id'])
    {
        header('Location: profil.php');
    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="images/icons/logos/logo.png"/>
    <title>FacePlateforme | <?php echo $username; ?></title>
</head>
<body>
    <?php include_once('header.php'); ?>
    <main id="main_profil">
        <section id="user">
            <div id="user_infos">
                <div id="avatar">
                    <img src="<?php echo $avatar; ?>">
                </div>
                <div id="username">
                    <h3><?php echo $username; ?></h3>
                </div>
            </div>
        </section>
        <section id="outils">
            <div id="posts_tools">
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
            echo "<p style=\"text-align: center;\">".$username." n'a rien posté actuellement</p>";
        }
        ?>
                </div>
            </div>
            <div id="infos_tools">
                <div id="infos">
                    <h3><?php echo $prenom; ?></h3>
                    <h3><?php echo $nom; ?></h3>
                    <h3><?php echo $mail; ?></h3>
                    <h3>Posts : <?php echo $nb_post; ?></h3>
                    <a href="discussion?iduser=<?php echo $_GET['iduser']; ?>"><img src="images/icons/message.png"></a>
                </div>
            </div>
        </section>
    </main>
</body>