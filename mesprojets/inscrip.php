<?php
$bdd= new PDO('mysql:host=127.0.0.1;dbname=tp','root','');
if(isset($_POST['inscription']))
{
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $sexe = htmlspecialchars($_POST['sexe']);
    $contact = htmlspecialchars($_POST['contact']);
    $email = htmlspecialchars($_POST['email']);
    $mdp = $_POST['mot_de_passe'];

    if(!empty($_POST['nom']) AND !empty($_POST['prenom'] )AND !empty($_POST['sexe']) AND !empty($_POST['contact'])AND !empty($_POST['email'] ) AND !empty($_POST['mot_de_passe']))
{
    $prenomlenght = strlen($prenom);
        $nomlenght = strlen($nom);
        if($nomlenght <= 50)
        {
            if($prenomlenght <= 50)
            {
                
                    if(filter_var($email, FILTER_VALIDATE_EMAIL))
                    {
                        $reqcontact = $bdd->prepare("SELECT*FROM users WHERE contact = ?");
                        $reqcontact->execute(array($contact));
                        $contactexist = $reqcontact->rowCount();
                        if($contactexist == 0)
                        {
                            $reqmail = $bdd->prepare("SELECT*FROM users WHERE email = ?");
                            $reqmail->execute(array($email));
                            $mailexist = $reqmail->rowCount();
                            if($mailexist == 0)
                            {
                                $insertuser = $bdd ->prepare("INSERT INTO users(nom, prenom, sexe, contact, email, mot_de_passe) VALUES(?, ?, ?, ?, ?, ?)");
                                $insertuser->execute(array($nom, $prenom, $sexe, $contact, $email, $mdp));
                                
                                header('Location: inscrip.php');
                                $notif = "Compte créé avec succès !";
                                
                                
                            }
                            else
                            {
                                $notif = "L'adresse mail existe déjà et ne peut etre utilisé plus d'une fois";
                            }
                        }
                        else
                        {
                            $notif = "Ce contact existe déjà et ne peut etre utilisé plus d'une fois";
                        }
                    }
                    else
                    {
                        $notif = "Votre email n'est pas valide";
                    }
                
                
            }
            else
            {
                $notif = "Votre prenom ne doit pas dépasser 50 caractères!";
            }
        }
        else
        {
                $notif = "Votre nom ne doit pas dépasser 50 caractères!";
        }
}
else
{
    $notif="Tous les champs doivent etre completé";
}
}
?>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <h2>Inscription</h2>
    <form action="" method="post">
        <label for="nom">Nom:</label>
        <input type="text" name="nom" required><br><br>

        <label for="prenom">Prénom:</label>
        <input type="text" name="prenom" required><br><br>

        <label for="sexe">Sexe:</label>
        <select name="sexe" required>
            <option value="Masculin">Masculin</option>
            <option value="Féminin">Féminin</option>
        </select><br><br>

        <label for="contact">Contact:</label>
        <input type="text" name="contact" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>

        <label for="mot_de_passe">Mot de passe:</label>
        <input type="password" name="mot_de_passe" required><br><br>

        <input type="submit" name="inscription" value="S'inscrire">
        <div>
            <?php
                if(isset($notif)){
                echo '<font color="red">'.$notif.'</font>';
                }
            ?>
        </div>
    </form>
</body>
</html>
