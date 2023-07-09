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

$req = "SELECT * FROM tickets WHERE idAdmin = ? ";
$stmt = mysqli_prepare($id, $req);
if ($stmt === false) {
    die('Erreur de préparation : ' . mysqli_error($id));
}
// 'i' signifie que la variable est un entier.
mysqli_stmt_bind_param($stmt, 'i', $adminId);

mysqli_stmt_execute($stmt);
$resultat = mysqli_stmt_get_result($stmt);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulter les tickets</title>
    <link rel="stylesheet" href="styleChat.css">
</head>
<body>
    <div class="container_accueil_admin">
    <hr><br><h2>Gérer les tickets</h2><br><hr><br>
    <?php
        if (mysqli_num_rows($resultat) > 0) {
            echo "<table><tr><th>Numéro de Demande</th><th>Type de Demande</th><th>Priorité</th><th>Sujet</th><th>Message</th></tr>";
            while($row = mysqli_fetch_assoc($resultat)) {
                echo "<tr><td>" . $row["numeroDemande"]. "</td><td>" . $row["typeDemande"]. "</td><td>" . $row["priorite"]. "</td><td>" . $row["sujet"]. "</td><td>" . $row["message"]. "</td>";
                echo "<td><button><a href=''>Ouvrir</a></button></td></tr>";
            }
            echo "</table>";
        } else {
            echo "Aucun ticket trouvé. ";
        }
        mysqli_close($id);
    ?><br><br>
        <button class="back-button"><a href="admin.php">Retour</a></button>
    </div>
</body>
</html>

