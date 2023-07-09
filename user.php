<?php
session_start();
if(!isset($_SESSION["clientId"]))
{
    header("location:connexion.php");
}

$clientId = $_SESSION['clientId'];
if(isset($_POST["bout"])){
    if(isset($_POST["choice"])){
        $choice = $_POST["choice"];
        if ($choice == "create_ticket") {
            header("location:create_ticket.php");
        } else if ($choice == "consult_ticket") {
            header("location:consult_ticket.php");
        }else if ($choice == "informations"){
            header("location:informations.php");
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
        <input type="radio" id="create_ticket" name="choice" value="create_ticket">
        <label for="create_ticket">Créer un ticket</label><br>

        <input type="radio" id="consult_ticket" name="choice" value="consult_ticket">
        <label for="consult_ticket">Consulter les tickets</label><br>

        <input type="radio" id="informations" name="choice" value="informations">
        <label for="informations">Mes informations</label>
        <br><br>
        <input type="submit" name="bout" value="Valider">
    </form>
</div>
</body>
</html>
