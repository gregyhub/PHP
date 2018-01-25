<?php

    
   
    if($_GET && isset($_GET['pays'])) {
        $pays = $_GET['pays'];
        $un_an = 365 * 24 * 3600;
        setcookie("pays", $pays, time() + $un_an);
    } elseif(isset($_COOKIE['pays'])) {
        $pays = $_COOKIE['pays'];
    } else {
        $pays = 'fr';
    }

    switch($pays) {
        case 'fr' :
            $AffBienvenue = "bonjour, vous visitez actuellement le site en francais.";
            break;
        case 'en' :
            $AffBienvenue = "Hello, you are currently visiting the site in english.";
            break;
        case 'es' :
            $AffBienvenue = "Hola !, en est moment, esta visitando el sitio en español.";
            break;
        case 'it' :
            $AffBienvenue = "Cia, si sta attulmente visitando il sito en italiano.";
            break;
        default :
            $AffBienvenue = "Nous n'avons pas de traduction pour la langue que vous demandez.";
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>pays cookies</title>
</head>
<body>
    <ul>
        <li><a href='?pays=fr'>France</a></li>
        <li><a href='?pays=en'>Anglais</a></li>
        <li><a href='?pays=es'>Espagne</a></li>
        <li><a href='?pays=it'>Italie</a></li>
    </ul>
    <h2><?=$AffBienvenue?></h2>
</body>
</html>