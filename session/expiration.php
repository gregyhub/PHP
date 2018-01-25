<?php

    session_start(); //créer un session ou en ouvrir une si elle existe
    
    echo "temps actuel : ". time() ."<br>";
    print_r($_SESSION);

    if(isset($_SESSION['temps'])) {
        if(time() > ($_SESSION['limite'] + $_SESSION['temps'])) {
            session_destroy();
            echo 'expiration de la session';
        }else{
            $_SESSION['temps'] = time();
            echo 'connexion mis à jour : 20 sec de plus !';
        }
    }else {
        echo 'connexion';
        $_SESSION['limite'] = 10; //je fixe le temps d'inactivité avant expiration de la session.
        $_SESSION['temps'] = time();

    }
    /* les infos d'une session sont enregistrées coté serveur..
    Cela crée dans le meme temps un COOKIE qui identifie la session : PHPSESSID
    */
?>


