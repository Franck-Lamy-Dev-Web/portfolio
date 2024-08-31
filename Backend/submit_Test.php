<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Contact</title>
</head>
<body>

<h1>Formulaire de Contact</h1>

<form method="POST" action="">
    <label for="nom">Nom:</label>
    <input type="text" name="nom" id="nom" required>
    <br>
    <label for="prenom">Prénom:</label>
    <input type="text" name="prenom" id="prenom" required>
    <br>
    <button type="submit">Envoyer</button>
</form>

<?php


    // Nettoyage des données entrées
    $nom = htmlspecialchars(trim($_POST['nom']));
    $prenom = htmlspecialchars(trim($_POST['prenom']));

    echo ($nom . '<br>' . $prenom);

?>

</body>
</html>
