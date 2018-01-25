<?php
    /*fichier sera inclus dans tous les scripts pour innitialiser les éléments suivants :
    -création/ouverture de session
    -connexion à la BDD site
    -definition du chemin du site
    -inclusion de notre ficher fonction utilisateur (fonction.php)
    */

    //session
    session_start();

    //bdd
    $pdo = new PDO('mysql:host=localhost; dbname=site','root', '', 
    array(
        PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING,
        PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8'
    ));


    //chemin du site
    define('RACINE_SITE', '/PHP/site/');

    require_once('fonctions.php');
?>