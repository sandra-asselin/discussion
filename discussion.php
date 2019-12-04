<?php include_once('configuration/config.php'); 
    $id = $_SESSION['id'];
    $idfriend = $_GET['iduser'];
    $msg = "";
    if(empty($idfriend))
    {
        header('Location: profil.php');
    }
    if($_GET['iduser'] == $_SESSION['id'])
    {
        header('Location: profil.php');
    }

    $result = mysqli_query($_SESSION['db'], "SELECT login FROM utilisateurs WHERE id='$idfriend'");
    $resultat = mysqli_fetch_all($result);
    $friendname = $resultat[0][0];
    if(isset($_POST['send']))
    {
        sendMessage($id, $idfriend);
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="images/icons/logos/logo.png">
    <title>Chat</title>
</head>
<body>
    <a href="index.php" style="text-decoration: none; color: white;">Accueil</a>
    <main id="main_chat">
        <?php echo $friendname ?>
        <section>
            <?php
                if($msg != "")
                {
                    echo $msg;
                }
                getMessages($idfriend, $id);

            ?>
            
        </section>
        <div id="create_message">
            <form action="discussion.php?iduser=<?php echo $idfriend; ?>" method="post">
                <input type="text" name="message" autocomplete="off" required>
                <input type="submit" name="send" value="Envoyer">
            </form>
        </div>
    </main>
</body>
</html>