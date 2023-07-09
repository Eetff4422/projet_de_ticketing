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

$req = "SELECT nom FROM clients ORDER BY nom";
$resultat = mysqli_query($id, $req);
$res = null;

if(isset($_POST["bout"])){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nom = $_POST["modify"];

        $req = "SELECT * FROM clients WHERE nom = ? ";
        $stmt = mysqli_prepare($id, $req);
        if ($stmt === false) {
            die('Erreur de préparation : ' . mysqli_error($id));
        }

        // 's' signifie que la variable est une chaîne.
        mysqli_stmt_bind_param($stmt, 's', $nom);

        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modifier les informations des clients</title>
  <link rel="stylesheet" href="styleChat.css">
</head>
<body>
    <div class='container_accueil_admin'>
        <form action="client_modify.php" method="post">
            <label for="modify"></label><br>
            <select id="modify" name="modify">
                <?php while($row = mysqli_fetch_assoc($resultat)) { ?>
                    <option value='<?php echo $row["nom"] ?>'><?php echo $row["nom"] ?></option>
                <?php   } ?>
            </select><br>
            <button class="back-button"><a href="client_management.php">Annuler</a></button><br><br>
            <input type="submit" name="bout" value="Modifier">
        </form>
    </div>

    <?php
        if ($res && mysqli_num_rows($res) > 0) {
            ?><div class='container_accueil_admin'>
            <?php while($row = mysqli_fetch_assoc($res)) {
                echo "<form action='update_client.php' method='post'>
                    <input type='hidden' name='id' value='" . $row["id"] . "'>
                    <input type='hidden' name='idUser' value='" . $row["idUser"] . "'>
                    Nom: <input type='text' name='nom' value='" . $row["nom"] . "'><br>
                    Prénom: <input type='text' name='prenom' value='" . $row["prenom"] . "'><br>
                    mail: <input type='text' name='mail' value='" . $row["mail"] . "'><br>
                    Téléphone: <input type='text' name='telephone' value='" . $row["telephone"] . "'><br>
                    <input type='submit' name='bout' value='Modifier'>
                    </form><br>";
            }?>
            <br><br>
            <button class="back-button"><a href="client_management.php">Annuler</a></button>
            </div>  <?php
        }
        mysqli_close($id);
        
        ?>
</body>
</html>
