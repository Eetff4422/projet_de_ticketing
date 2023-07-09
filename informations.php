<?php
session_start();
if(!isset($_SESSION["clientId"]))
{
    header("location:connexion.php");
}

$clientId = $_SESSION['clientId'];
$id = mysqli_connect("127.0.0.1", "root", "", "ticketing");

if (!$id) {
    die("Erreur de connexion: " . mysqli_connect_error());
}

$req = "SELECT * FROM clients WHERE id = ? ";
$stmt = mysqli_prepare($id, $req);
if ($stmt === false) {
    die('Erreur de préparation : ' . mysqli_error($id));
}
// 'i' signifie que la variable est un entier.
mysqli_stmt_bind_param($stmt, 'i', $clientId);

mysqli_stmt_execute($stmt);
$resultat = mysqli_stmt_get_result($stmt);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes informations</title>
    <link rel="stylesheet" href="styleChat.css">
</head>
<body>
    <div class="container_accueil_admin">
    <hr><br><h2>Mes informations</h2><br><hr><br>
        <?php
            if (mysqli_num_rows($resultat) > 0) {
                echo "<table><tr><th>Nom</th><th>Prénom</th><th>Email</th><th>Téléphone</th></tr>";
                while($row = mysqli_fetch_assoc($resultat)) {
                    echo "<tr><td>" . $row["nom"]. "</td><td>" . $row["prenom"]. "</td><td>" . $row["mail"]. "</td><td>" . $row["telephone"]. "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "Aucune information trouvé";
            }
            mysqli_close($id);
        ?><br><br>
        <button class="back-button"><a href="user.php">Retour</a></button>
    </div>
</body>
</html>

