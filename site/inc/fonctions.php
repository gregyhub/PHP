<?php

    /*
    FONCTION pour executer les requetes
    */
    function executeRequete($sql, $params=array()) {
        if(!empty($params)){
            foreach($params as $indice => $param){
                $params[$indice] = htmlspecialchars($param, ENT_QUOTES);
            }
         }

         global $pdo;
         $r = $pdo->prepare($sql);
         $r->execute($params);

         if( !empty($r->errorInfo()[2])){
             die('<p class="label label-danger">Erreur rencontrée pendant la requete. <br> Message : '.$r->errorInfo()[2].'</p>');
         }
         return $r;
    }

    /*
    fonctin pour vérifier si les champs formulaire son vide ou non
    */
    function champVide($champs){
        $champsvides = array('nbError' => 0);
        $champsvalides = array();
        $i=0;
        foreach($champs as $indice => $champ){
            if(empty($champ) xor $champ==" "){
                $champsvides[$indice]='<div class="alert alert-danger" role="alert">Vous devez saisir votre '.$indice.' pour valider le formulaire.</div>';
                $i++;
            }else{
                $champsvalides[$indice] = $champ;
            }
        }
        $champsvides['nbError']=$i;
        return array('champsvides' => $champsvides, 'champsvalides' => $champsvalides);
    }


    function estConnecteEtAdmin() {
        if(estConnecte() && $_SESSION['membre']['statut']==1){
            return true;
        }
        else{
            return false;
        }
    }

    function estConnecte() {
        if(isset($_SESSION['membre'])){
            return true;
        }
        else{
            false;
        }
    }

    function nbArticlesPanier() {

    }

  
?>