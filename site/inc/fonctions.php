<?php
/*  =============================================================================================================
=================== FONCTIONS ADMIN ============================================================================= 
===============================================================================================================*/
    function vdm($e, $ex = ''){
        echo '<pre>';
        var_dump($e);
        echo '</pre>';
        if($ex == "ex"){
            exit;
        }
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



    function UploadPhoto ($file) {
 
        // Tableaux de donnees
        $tabExt = array('jpg','gif','png','jpeg');    // Extensions autorisees
        $infosImg = array();
        
        // Variables
        $extension = '';
        $message = '';
        $nomImage = '';

        /************************************************************
         * Script d'upload
         *************************************************************/
    
        // Recuperation de l'extension du fichier
        $extension  = pathinfo($file['name'], PATHINFO_EXTENSION);
    
        // On verifie l'extension du fichier
        if(in_array(strtolower($extension),$tabExt)){
            // On recupere les dimensions du fichier
            $infosImg = getimagesize($file['tmp_name']);
        
            // On verifie le type de l'image
            if($infosImg[2] >= 1 && $infosImg[2] <= 14){
                // On verifie les dimensions et taille de l'image
                if(($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && (filesize($file['tmp_name']) <= MAX_SIZE)){
                    // Parcours du tableau d'erreurs
                    if(isset($file['error']) && UPLOAD_ERR_OK === $file['error']){
                        // On renomme le fichier
                        $nomImage = md5(uniqid()) .'.'. $extension;
            
                        // Si c'est OK, on teste l'upload
                        if(move_uploaded_file($file['tmp_name'], ROOT.'photos/'.$nomImage)){
                            $message = 'Upload réussi !';
                            
                        }
                        else{
                            // Sinon on affiche une erreur systeme
                            $message = 'Problème lors de l\'upload !';
                        }
                    }
                    else{
                        $message = 'Une erreur interne a empêché l\'uplaod de l\'image';
                    }
                }
                else{
                // Sinon erreur sur les dimensions et taille de l'image
                $message = 'Erreur dans les dimensions de l\'image !';
                }
            }
            else{
                // Sinon erreur sur le type de l'image
                $message = 'Le fichier à uploader n\'est pas une image !';
            }
        }
        else{
        // Sinon on affiche une erreur pour l'extension
        $message = 'L\'extension du fichier est incorrecte !';
        }
        return array('nom' => $nomImage, 'message' => $message);
    } //fin fonction









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