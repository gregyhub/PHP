<?php
    require_once('fonctions.php');
    require_once('init.php');

    /*===========================
    ===========AJAX==============
    ============================ */
   //requete ajax pour tester le pseudo
    if( !empty($_POST) && isset($_POST['pseudo'])) {
        $libre = 'dispo';
        $sql = 'SELECT pseudo FROM membre WHERE pseudo=:pseudo';
        $verifPseudo = executeRequete($sql,  array('pseudo' => $_POST['pseudo']));
        if($verifPseudo->rowCount() != 0){
            $libre = 'nondispo';
        }
        echo $libre;
    }
?>