<?php

    function vdm($e){
        echo '<pre>';
        var_dump($e);
        echo '</pre>';
    }

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
    j'envoie le POST
    Je revoie un tableau indice
        - 'champs vide' avec les champs vide et leur indice + un indice nbError qui compte les erreur 
        - 'champs valide' la valeur du champs valide à l'indice du champs valide
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
                //je test le nombre de caractère des champs titre, réalisateur, acteur et producteur et synopsis
                if($indice == 'title' or $indice == 'director' or $indice == 'actors' or $indice == 'producer' or $indice == 'storyline'){
                    if(strlen($champ) < 5){
                        $champsvides[$indice]='<div class="alert alert-danger" role="alert">au moins 5 caractères.</div>';
                        $i++;
                    }
                }
                if($indice == 'video'){
                    //je valide que l'url est valide
                    if (!filter_var($champ, FILTER_VALIDATE_URL)) {
                        $champsvides[$indice]='<div class="alert alert-danger" role="alert">Le liens vers la bande annonce n\'est pas valide</div>';
                        $i++;
                    }
                }
                $champsvalides[$indice] = $champ;
            }
        }
        $champsvides['nbError']=$i;
        return array('champsvides' => $champsvides, 'champsvalides' => $champsvalides);
    }


?>
