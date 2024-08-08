<?php
$bdd= new PDO('mysql:host=127.0.0.1;dbname=tp','root','');

$reqsql = "SELECT nom, prenom FROM users";
$result = $bdd->query($reqsql);

if ($result->rowCount() > 0) {
    // Affichage des données de chaque ligne
    while($row = $result->fetch()) {
        echo "Nom: " . $row["nom"]. " Prénom: " . $row["prenom"]. "<br>";
    }
} else {
    echo "0 utilisateurs";
}

?>
