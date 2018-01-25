<?php

    $nomfichier = 'fichier.txt';
    $fichier = file($nomfichier);
    //la fonction file va lire le fichier et créer un tableau. chaque ligne du tableau corresspond à un chaque saut de lgine du fichier
    echo "<pre>";
    var_dump($fichier);
    echo "</pre>";

    $fichiercsv = file('fichier.csv');

    foreach( $fichiercsv as $ligne) {
        $info_ligne = explode(";", $ligne);
        foreach($info_ligne as $info) {
            echo $info .'<br>';
        }
        echo "<hr>";
    }
    
?>