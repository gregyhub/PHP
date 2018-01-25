<?php
    require_once('inc/init.php');

    if( !estConnecte()){
        ob_start();
        ?>
            <div class="jumbotron">
                <p>vous n'avez pas l'autorisation d'être sur cette Page.<br>Authentifiez vous ou créez un compte.</p>
                <a href="connexion.php">Pour vous connecter ou créer un compte</a><br>
                <a href="index.php">Pour vous retourner à l'accueil</a>
            </div>
            
        <?php
        $content = ob_get_clean();

    }else {

        ob_start();
        var_dump($_SESSION['membre']);
        ?>
            
        <?php
        $content = ob_get_clean();
    }

   
  



    include('inc/gabarit.php');

?>