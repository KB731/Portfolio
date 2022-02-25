<?php

    require_once '../database.php';

    if (isset($_FILES['file'])) {
        $tmpName = $_FILES['file']['tmp_name'];
        $name = $_FILES['file']['name'];
        $size = $_FILES['file']['size'];
        $error = $_FILES['file']['error'];
        $type = $_FILES['file']['type'];

        // Scinde une chaîne de caractères en segments 
        $tabExtension = explode('.', $name);
        $extension = strtolower(end($tabExtension));

        // Tableau des extensions autorisées
        $extensionsAutorisees = ['jpg', 'jpeg', 'gif', 'png'];
        $tailleMaxImg = 400000;

        if(in_array($extension, $extensionsAutorisees) && $size <= $tailleMaxImg && $error == 0){

            $uniqueNameImg = uniqid('', true);
            $fileName = $uniqueNameImg. '.' .$extension;

            move_uploaded_file($tmpName, '../assets/uploads/' .$fileName);

            $requete = $db->prepare('INSERT INTO projects (picture) VALUES (?)');
            $requete->execute([$fileName]);

            echo 'Image enregistrée';
        }
        else{
            echo 'Mauvaise extension ou taille trop importante';
        }

        
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add_project</title>
</head>

<body>
    <!-- Formulaire pour ajouter un projet au portfolio -->
    <form method="POST" action="addProject.php" enctype="multipart/form-data">
        <label for="title">Entrez un titre : </label>
        <input type="text" name="title" id="title">

        <label for="description">Entrez une description : </label>
        <textarea name="description" id="description" cols="30" rows="10"></textarea>

        <!-- Upload une image -->
        <label for="file">Fichier</label>
        <input type="file" name="file">

        <!-- Boutton pour soumettre le formulaire  -->
        <button type="submit">Enregistrer</button>
    </form>
</body>

</html>