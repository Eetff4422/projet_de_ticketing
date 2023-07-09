<?php
session_start();

if(isset($_POST["bout"])) {
    $username = $_POST["username"];
    $mdp = $_POST["mdp"];
    if(empty($username) || empty($mdp)) {
        $erreur = "Veuillez entrer le nom d'utilisateur et le mot de passe.";
    } else {
        $id = mysqli_connect("127.0.0.1", "root", "", "ticketing");
        if(!$id) {
            die("Erreur de connexion à la base de données: " . mysqli_connect_error());
        }

        $req = "SELECT * FROM users WHERE username = ? AND mdp = ?";
        $stmt = mysqli_prepare($id, $req);
        if(!$stmt) {
            die("Erreur de préparation de requête: " . mysqli_error($id));
        }

        mysqli_stmt_bind_param($stmt, 'ss', $username, $mdp);

        mysqli_stmt_execute($stmt);

        $resultat = mysqli_stmt_get_result($stmt);
        if(!$resultat) {
            die("Erreur d'exécution de requête: " . mysqli_error($id));
        }

        if($row = mysqli_fetch_assoc($resultat)) {
            $_SESSION["isAdmin"] = $row['isAdmin'];
            if ($row['isAdmin']) {
                $idUser = $row['id'];
                $req = "SELECT id FROM administrateurs WHERE idUser = ?";
                $stmt = mysqli_prepare($id, $req);
                if(!$stmt) {
                    die("Erreur de préparation de requête: " . mysqli_error($id));
                }

                mysqli_stmt_bind_param($stmt, 'i', $idUser);

                mysqli_stmt_execute($stmt);

                $resultat = mysqli_stmt_get_result($stmt);
                if(!$resultat) {
                    die("Erreur d'exécution de requête: " . mysqli_error($id));
                }

                if($row = mysqli_fetch_assoc($resultat)) {
                    $_SESSION["adminId"] = $row['id'];
                    header("location:admin.php");
                } else {
                    $erreur = "Erreur : L'administrateur' n'a pas été trouvé.";
                }
            } else {
                $idUser = $row['id'];
                $req = "SELECT id FROM clients WHERE idUser = ?";
                $stmt = mysqli_prepare($id, $req);
                if(!$stmt) {
                    die("Erreur de préparation de requête: " . mysqli_error($id));
                }

                mysqli_stmt_bind_param($stmt, 'i', $idUser);

                mysqli_stmt_execute($stmt);

                $resultat = mysqli_stmt_get_result($stmt);
                if(!$resultat) {
                    die("Erreur d'exécution de requête: " . mysqli_error($id));
                }

                if($row = mysqli_fetch_assoc($resultat)) {
                    $_SESSION["clientId"] = $row['id'];
                    header("location:user.php");
                } else {
                    $erreur = "Erreur : Le client n'a pas été trouvé.";
                }
            }
        } else {
            $erreur = "Erreur de username ou de mot de passe.";
        }
    }
}


?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styleChat.css">
</head>
<body>
    <div class="fc">
        <hr><br>
        <h2><b>Formulaire de connexion</b></h2><br><hr><br><br>
        <form action="" method="post"> 
            <?php if(isset($erreur)) echo "<h3>$erreur</h3>";?>
            <input type="text" name="username" placeholder="username :" required><br><br>
            <input type="password" name="mdp" placeholder="Mot de passe :" required><br><br>
            <input type="submit" value="Connexion" name="bout" class="SConnexion">
        </form>
        
    </div>
</body>
</html>