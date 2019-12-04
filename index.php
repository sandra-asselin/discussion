<?php include_once('configuration/config.php'); 

if(!isset($_SESSION['username']))
{
    header('Location: login.php');
}
if(isset($_GET['disc']))
{
    session_destroy();
    header('Location: index.php');
}
?>
<?php
    $db = $_SESSION['db'];
    $requete = "SELECT posts.titre, posts.message, utilisateurs.id ,utilisateurs.login, utilisateurs.avatar FROM posts INNER JOIN utilisateurs ON posts.id_auteur = utilisateurs.id ORDER BY posts.id DESC";
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
    <title>FacePlateforme | Fil de publications</title>
</head>
<body>
    <?php include('header.php') ?>
    <main id="main_index">
        <?php
        if(!empty($result))
        {
            $i = 0;
            foreach($result as $key)
            {
                $titre = $result[$i][0];
                $message = $result[$i][1];
                $iduser = $result[$i][2];
                $auteur = $result[$i][3];
                $avatar = $result[$i][4];
                echo "<div class=\"post\">";
                echo "<div id=\"post_author_infos\">";
                echo "<div id=\"author_avatar\">";
                echo "<img src=\"$avatar\">";
                echo "</div>";
                echo "<div id=\"author_username\">";
                echo "<a href=\"aprofil.php?iduser=$iduser\"><h4>$auteur</h4></a>";
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
            echo "<p style=\"text-align: center;\">Il n'y à pas de posts actuellement. Revenez plus tard</p>";
        }
        ?>
    </main>
</body>
</html>