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

// récupérer les données POST
$client_id = intval($_POST["id"]);
$user_id = intval($_POST["idUser"]);
$nom = $_POST["nom"];
$prenom = $_POST["prenom"];
$mail = $_POST["mail"];
$telephone = $_POST["telephone"];


// valider les données
$errors = [];

if (!preg_match("/^[a-zA-Z-' ]*$/",$nom)) {
    $errors[] = "Le nom ne doit contenir que des lettres et des espaces.";
}
if (!preg_match("/^[a-zA-Z-' ]*$/",$prenom)) {
    $errors[] = "Le prénom ne doit contenir que des lettres et des espaces.";
}
if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "L'adresse e-mail n'est pas valide.";
}
if (!preg_match("/^[0-9]*$/",$telephone)) {
    $errors[] = "Le numéro de téléphone doit contenir uniquement des chiffres.";
}

if (!empty($errors)) {
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
} else {
    // préparer la requête
    
    $req = "UPDATE clients SET nom = ?, prenom = ?, mail = ?, telephone = ? WHERE id = ? AND idUser = ?";

    $stmt = mysqli_prepare($id, $req);

    // i pour integer, s pour string.
    mysqli_stmt_bind_param($stmt, 'ssssii',  $nom, $prenom, $mail, $telephone, $client_id, $user_id);

    // exécuter la requête
    if(mysqli_stmt_execute($stmt)){
        echo "Informations du client mises à jour avec succès.... <br> Redirection en cours....";
        header("refresh:1;url=client_management.php");
    } else {
        echo "Erreur lors de la mise à jour des informations du client: " . mysqli_error($id);
    }
    
}

mysqli_close($id);
?>
