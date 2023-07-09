<?php
session_start();
if(!isset($_SESSION["clientId"])) {
    header("location:connexion.php");
    exit();
}

$clientId = $_SESSION['clientId'];


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un ticket</title>
    <link rel="stylesheet" href="styleChat.css">
</head>
<body>
<div class="container_accueil_admin">
<hr><br><h2>Créer un ticket</h2><br><hr><br>
    <form action="submit_ticket.php" method="post" enctype="multipart/form-data">
        <label for="ticketNumber">Numéro de Demande:</label><br>
        <?php $ticketNumber = uniqid();?>
        <input type="text" id="ticketNumber" name="ticketNumber" value="<?php echo $ticketNumber; ?>" readonly><br>

        <label for="requestType">Type de Demande:</label><br>
        <select id="requestType" name="requestType">
            <option value="">Type de la demande *</option>
            <option value="Hardware_Problem">Problème Matériel</option>
            <option value="Software_Problem">Problème Logiciel</option>
            <option value="Network_Issue">Problème de Réseau</option>
            <option value="Access_Problem">Problème d'Accès</option>
            <option value="Service_Request">Demande de Service</option>
        </select><br>

        <label for="priority">Priorité:</label><br>
        <select id="priority" name="priority">
            <option value="">Choisissez la priorité *</option>
            <option value="Low">Basse</option>
            <option value="Medium">Moyenne</option>
            <option value="High">Élevée</option>
            <option value="Critical">Critique</option>
        </select><br>

        <label for="subject">Sujet:</label><br>
        <input type="text" id="subject" name="subject"><br>

        <label for="message">Message:</label><br>
        <textarea id="message" name="message" rows="4" cols="50"></textarea><br>

        <label for="file">Pièce jointe:</label><br>
        <input type="file" id="file" name="file"><br>
        
        <button class="back-button"><a href="user.php">Annuler</a></button><br><br>
        <input type="submit" value="Créer un ticket">
    </form>
</div>
</body>
</html>
