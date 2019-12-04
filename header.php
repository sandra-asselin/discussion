<?php include_once('header_css.html');?>
<header>
    <div id="h_menu">
        <div class="menu-wrap">
            <input type="checkbox" class="toggler">
            <div class="hamburger">
                <div></div>
            </div>
            <div class="menu">
                <div>
                    <div>
                        <ul>
                            <li><a href="index.php">Accueil</a></li>
                            <li><a href="profil.php">Profil</a></li>
                            <li><a href="index.php?disc">Déconnecter</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="hamburger_menu"></div>
    </div>
    <div id="h_logo">
        <img src="images/icons/logos/logo.png">
    </div>
    <div id="h_titre">
        <h1>FacePlateforme<span>_</span></h1>
    </div>
    <div id="h_user_infos">
        <div id="h_username">
            <a href="profil.php"><h3><?php echo $_SESSION['username'] ?></h3></a>
        </div>
        <div id="h_avatar">
            <img src="<?php echo $_SESSION['avatar']; ?>">
        </div>
    </div>
</header>