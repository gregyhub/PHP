<?php
 session_start();
/*
    creer un formulaire pour demander le pseudo
    quand il valide son pseudo, on garde l'info en session
    quand il revient sur la page, on lui indique "votre pseudo est : " et on masquee le formulaire
    ne pas enregistrer la session si pseudo vide.
*/
  /*  var_dump($_POST); */

    
    if(isset($_POST['valider']) && $_POST['valider'] == "valider") {
        // si il valide le forumlaire
        if(empty($_POST['pseudo'])) {
            //champs pseudo vide
            $erreurPseudo = "<p>vous devez saisir un pesudo</p>";
        } else {
            //champs pseudo OK Donc je creer ma SESSION
            $_SESSION['pseudo'] = $_POST['pseudo'];
        }
    }
    if(isset($_SESSION['pseudo'])) {
        // si la variable sesssion existe déjà
        $MessBienvenue = '<h2>Bienvenu, votre pseudo est : '. $_SESSION['pseudo'].'</h2>';
        $formDeconnexion = '<form action="" method="post">       
        <input type="submit" value="deconnexion" name="deconnexion">
    </form>';
    } else {
        $formConnexion = '<form action="" method="post">
                                <label for="pseudo">Pseudo</label><input type="text" name="pseudo" id="pseudo">
                            <input type="submit" value="valider" name="valider">
                        </form>';
    }
    if (isset($_POST['deconnexion']) && $_POST['deconnexion'] == "deconnexion") {
        session_destroy();
        header('');
      
    }
        // par défaut
       
       
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>form Session</title>
</head>
<body>
    

    <?= $MessBienvenue ?? $formConnexion ?>
    <?= $formDeconnexion ?? '' ?>

    <?= $erreurPseudo ?? '' ?>
</body>
</html>

