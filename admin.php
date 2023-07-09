<?php
session_start();
if(!isset($_SESSION["adminId"]))
{
    header("location:connexion.php");
}

$adminId = $_SESSION["adminId"];
if(isset($_POST["bout"])){
    if(isset($_POST["choice"])){
        $choice = $_POST["choice"];
        if ($choice == "client") {
            header("location:client_management.php");
        } else if ($choice == "ticket") {
            header("location:ticket_management.php");
        }
    }else{
        $erreur = "Veuillez sélectionner un choix. ";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="styleChat.css">
</head>
<body>

<div class="container_accueil_admin">
    
    <button class="logout-button"><a href="deconnexion.php">Déconnexion</a></button>
    <hr><br><h2>Page d'accueil de l'administrateur</h2><br><hr><br>

    <form action="" method="post">
        <?php if(isset($erreur)) echo "<h4>$erreur</h4>";?><br>

        <input type="radio" id="ticket" name="choice" value="ticket">
        <label for="ticket">Gestion des tickets</label><br>
        
        <input type="radio" id="client" name="choice" value="client">
        <label for="client">Gestion des clients</label>
        <br><br>
        <input type="submit" name="bout" value="Valider">
    </form>
</div>
</body>
</html>
