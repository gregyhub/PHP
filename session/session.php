<?php

    session_start(); //créer un session ou en ouvrir une si elle existe
    $_SESSION['login'] = 'greg';
    echo '<pre>';
    var_dump($_SESSION);
    var_dump($_COOKIE);
    echo '</pre>';
   
    
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
    <h2></h2>
</body>
</html>