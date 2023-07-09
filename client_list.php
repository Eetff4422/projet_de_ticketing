<?php
session_start();
if(!isset($_SESSION["adminId"]))
{
    header("location:connexion.php");
}

$adminId = $_SESSION["adminId"];
$id = mysqli_connect("127.0.0.1", "root", "", "ticketing");

if (!$id) {
    die("Erreur de connexion: " . mysqli_connect_error());
}

$req = "SELECT * FROM clients ORDER BY nom";
$resultat = mysqli_query($id, $req);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des clients</title>
    <link rel="stylesheet" href="styleChat.css">
</head>
<body>
    <div class="container_accueil_admin">
        <?php
            if (mysqli_num_rows($resultat) > 0) {
                echo "<table><tr><th>Nom</th><th>Prénom</th><th>Email</th><th>Téléphone</th></tr>";
                while($row = mysqli_fetch_assoc($resultat)) {
                    echo "<tr><td>" . $row["nom"]. "</td><td>" . $row["prenom"]. "</td><td>" . $row["mail"]. "</td><td>" . $row["telephone"]. "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "Aucun client trouvé";
            }
            mysqli_close($id);
        ?><br><br>
        <button class="back-button"><a href="client_management.php">Retour</a></button>
    </div>
</body>
</html>

