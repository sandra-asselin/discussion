<?php
session_start();
    $_SESSION['db'] = mysqli_connect('localhost', 'root', '', 'discussion');

    function register($username, $email, $prenom, $nom, $password)
    {   
        $db = $_SESSION['db'];
        $username = mysqli_real_escape_string($db, $username);
        $email = mysqli_real_escape_string($db, $email);
        $prenom = mysqli_real_escape_string($db, $prenom);
        $nom = mysqli_real_escape_string($db, $nom);
        $password = mysqli_real_escape_string($db, $password);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $requete = "INSERT INTO utilisateurs (login, password, email, prenom, nom) VALUES ('$username', '$password', '$email', '$prenom', '$nom')";
        mysqli_query($db, $requete);
        header('Location: login.php');
    }

    function login($username, $password)
    {
        $db = $_SESSION['db'];
        // On sécurise la saisie
        $username = mysqli_real_escape_string($db, $username);
        $password = mysqli_real_escape_string($db, $password);
        // On vérifie si l'utilisateur existe
        $checkuser = "SELECT login FROM utilisateurs WHERE login = '$username'";
        $checkuserquery = mysqli_query($db,$checkuser);
        $result = mysqli_num_rows($checkuserquery);
        if($result <= 0)
        {
            $_SESSION['error'] = true;
        }
        else
        {
            // On récupère le mot de passe de l'utilisateur
            $checkpass = "SELECT password FROM utilisateurs WHERE login = '$username'";
            $checkpassquery = mysqli_query($db, $checkpass);
            $cryptedpass = mysqli_fetch_all($checkpassquery);
            $cryptedpass = $cryptedpass[0][0];
            $passencrypt = password_verify($password, $cryptedpass);
            if($passencrypt == true)
            {
                $user_infos = "SELECT id, login, email, prenom, nom, avatar FROM utilisateurs WHERE login='$username'";
                $query = mysqli_query($db, $user_infos);
                $result = mysqli_fetch_all($query);
                session_start();
                $_SESSION['id'] = $result[0][0];
                $_SESSION['username'] = $result[0][1];
                $_SESSION['email'] = $result[0][2];
                $_SESSION['prenom'] = $result[0][3];
                $_SESSION['nom'] = $result[0][4]; 
                $_SESSION['nb_post'] = $result[0][5];
                $_SESSION['avatar'] = $result[0][6];
                header('Location: index.php');
            }
            else
            {
                $_SESSION['error'] = true;
            }
        }
    }


    function post($title, $message)
    {
        $db = $_SESSION['db'];
        $id_auteur = $_SESSION['id'];
        $title = mysqli_real_escape_string($db, $title);
        $message = mysqli_real_escape_string($db, $message);
        $requete = "INSERT INTO posts (id_auteur, titre, message) VALUES ('$id_auteur', '$title', '$message');";
        mysqli_query($db, $requete);
    }

    function getMessages($idfriend, $id)
    {
        $msg = "";
        $db = $_SESSION['db'];
        $query = mysqli_query($db, "SELECT message, id_utilisateur, id_interlocuteur, date FROM messages WHERE id_utilisateur='$id' && id_interlocuteur='$idfriend' or id_utilisateur='$idfriend' && id_interlocuteur='$id'");
        $result = mysqli_fetch_all($query);
        if($result == 0)
        {
            $msg = "Vous n'avez pas encore discuter";
        }
        else
        {
           $i = 0;
            foreach($result as $key)
            {
                $message = $result[$i][0];
                $auteur = $result[$i][1];
                $interlocuteur = $result[$i][2];
                $heure = $result[$i][3];
                if($auteur == $id)
                {
                    echo "<div class=\"message\" id=\"me\">
                    <div class=\"heure\">$heure</div>
                            <div class=\"mymessage\">
                                <p>$message
                                </p>
                            </div>
                            </div>";
                }
                else
                {
                    echo "<div class=\"message\" id=\"other\">
                    <div class=\"omessage\">
                    <p>
                    $message
                    </p>
                    </div>
                    <div class=\"heure\" id=\"o\">$heure</div>
                </div>";
                }
                $i++;
            } 
        }
        return($msg);
    }
    function sendMessage($id, $idfriend)
    {
        $db = $_SESSION['db'];
        $date = date("Y-m-d H:i:s");
        $message = mysqli_real_escape_string($db, $_POST['message']);
        mysqli_query($db, "INSERT INTO messages (message, id_utilisateur, id_interlocuteur, date) VALUES ('$message', '$id', '$idfriend', '$date')");
    }
?>