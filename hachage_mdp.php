<?php
$id = mysqli_connect("127.0.0.1", "root", "", "chatf2i"); 

$req = "SELECT * FROM users";
$resultat = mysqli_query($id, $req);

while($row = mysqli_fetch_assoc($resultat)) {
    $hashed_password = password_hash($row['mdp'], PASSWORD_DEFAULT);
    
    $update_req = "UPDATE users SET mdp = ? WHERE pseudo = ?";
    $stmt = mysqli_prepare($id, $update_req);

    mysqli_stmt_bind_param($stmt, 'ss', $hashed_password, $row['pseudo']);

    mysqli_stmt_execute($stmt);
}
?>
