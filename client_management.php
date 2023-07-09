<?php
session_start();
if(!isset($_SESSION["adminId"]))
{
    header("location:connexion.php");
}

$adminId = $_SESSION["adminId"];
if(isset($_POST["bout"])){
  if($_POST["client_choice"] != 'select') {
    $client_choice = $_POST["client_choice"];
    if ($client_choice == "list") {
      header("location:client_list.php");
    } else if ($client_choice == "modify") {
      header("location:client_modify.php");
    }
  } else {
    $erreur = "Veuillez faire un choix avant de valider.";
  }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion des clients</title>
  <link rel="stylesheet" href="styleChat.css">
</head>
<body>
  
  <div class="container_accueil_admin">
    <hr><br><h2>Gestion des clients</h2><br><hr><br>
    <?php if(isset($erreur)) echo "<h4>$erreur</h4>";?><br>
    <form action="" method="post">
      <select name="client_choice">
        <option value="select">Sélectionner</option>
        <option value="list">Consulter la liste de clients</option>
        <option value="modify">Modifier les informations d'un client</option>
      </select>
      <br><br>
      <input type="submit" name="bout" value="Soumettre">
    </form>
    <br><br>
    <button class="back-button"><a href="admin.php">Retour</a></button>
  </div>
</body>
</html>
