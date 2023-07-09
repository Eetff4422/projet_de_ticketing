<?php
    session_start();
    session_destroy();
    echo "vous êtes déconnecté.... <br> Redirection en cours....";
    header("refresh:1;url=connexion.php");
?>