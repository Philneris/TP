<?php
session_start();
$bdd= new PDO('mysql:host=127.0.0.1;dbname=tp','root','');

if(isset($_POST['connexion']))
{
    $emailconnect = htmlspecialchars($_POST['emailconnect']);
    $mdpconnect = $_POST['mdpconnect'];
    if(!empty($emailconnect AND !empty($mdpconnect)))
    {
        $requser = $bdd->prepare("SELECT * FROM users WHERE email = ? AND mot_de_passe = ?");
        $requser->execute(array($emailconnect, $mdpconnect));
        $userexist = $requser->rowCount();
        if($userexist == 1)
        {
            $userinfo = $requser->fetch();
            $_SESSION['id'] = $userinfo['id'];
            $_SESSION['nom'] = $userinfo['nom'];
            $_SESSION['prenom'] = $userinfo['prenom'];
            $_SESSION['sexe'] = $userinfo['sexe'];
            $_SESSION['contact'] = $userinfo['contact'];
            $_SESSION['email'] = $userinfo['email'];
            header("Location: users.php");
            
        }
        else
        {
            $notif = "Mauvais email ou mot de passe";
        }
    }
    else
    {
        $notif = "Tous les champs doivent etre remplis";
    }
}
?>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <h2>Connexion</h2>
    <form action="" method="post">

        <label for="email">Email:</label>
        <input type="email" name="emailconnect" required><br><br>

        <label for="mot_de_passe">Mot de passe:</label>
        <input type="password" name="mdpconnect" required><br><br>

        <input type="submit" name="connexion" value="Se connecter">
    </form>
    <div>
        <?php
            if(isset($notif)){
            echo '<font color="red">'.$notif.'</font>';
            }
        ?>
    </div>
</body>
</html>
