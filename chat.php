<?php
    session_start();
    if(!isset($_SESSION["username"]))
    {
        header("location:connexion.php");
    }
    $username = $_SESSION["username"];


    $id = mysqli_connect("127.0.0.1", "root", "", "chatf2i");
    $reqq = "select pseudo from users where pseudo != '$pseudo'" ;
    $result = mysqli_query($id, $reqq);
    if(isset($_POST["bouton"]))
    {
        $destinataire = $_POST["pselect"];
        $message = $_POST["message"];
        $req = "insert into messages values (null,'$pseudo','$destinataire','$message',now())";
        $res = mysqli_query($id, $req);
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbox</title>
    <link rel="stylesheet" href="styleChat.css">
</head>
<body>
    <div class="container">
        <h1 class="hUser">Bonjour <?php echo $_SESSION["pseudo"];?> Chattez en direct ! Chatbox</h1>
        <div class="messages">
            <ul>
                    <?php

                        //execution d'une requete sql et affectation du resultat à $resultat
                        $resultat = mysqli_query($id, "select * from messages where pseudo = '$pseudo' or destinataire = '$pseudo' or destinataire = 'Tous' order by date desc");
                        //recupération d'une ligne de resultat
                        while($ligne = mysqli_fetch_assoc($resultat))
                        {?>
                           <li class="message"><?php echo $ligne["date"]?> - <?php echo $ligne["destinataire"]?>: <?php echo $ligne["message"]?>
                        <?php 
                        }
                        ?> 
                        
            </ul>
        </div>
        <div class="formulaire">
            <form action="" method="post">
                Destinataire :&nbsp;&nbsp;&nbsp;
                <select name="pselect">
                    <?php
                        while($lig = mysqli_fetch_assoc($result))
                        {
                            echo "<option value='".$lig["pseudo"]."'>".$lig["pseudo"]."</option>";
                        }
                        ?>
                    <option value="Tous">Tous</option>    
                    <?php
                    ?>
                </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                <input type="text" name="message" placeholder="Message :" required><br><br>
                <input type="submit" value="Envoyer" name="bouton">
            </form><br>
            <button><a href="deconnexion.php">Déconnexion</a></button>
        </div>
    </div>
</body>
</html>