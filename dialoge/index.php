
<?php
 /*
    01[x]. modélisation et création de la base (base dialogue/table commentaire)
    02[x]. connexion à la base
    03[x]. créer un formulaire HTML pour l'ajout d'un message (pseudo/message)
    04[x]. récupération et affichage des messages déjà saisis
    05[x]. requete pour enregistrer un nouveau message
    06[x]. confirmation à l'utilisateur (via POST)
    07[x]. attaque : injection SQL + xss
    08[x]. etude et moyen pour contrer les attaques
    09[x]. ordonner et mettre les dernier message en tete de liste
    010[x]. afficher le nb de message
    011[x]. améliorer le viseul (css)
    012[x]. Tests
 */
    //connexion BDD
    $bdd = new PDO('mysql:host=localhost; dbname=dialogue','root', '', 
    array(
        PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING,
        PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8'
    ));

    /*================================================================
    ========== Insertion des commentaires dans la base ===============
    =================================================================*/
    if($_POST) {
        if(empty($_POST['pseudo']) || empty($_POST['message'])) {
            $errPost = '<div class="error">une erreur dans votre formulaire : votre pseudo ou votre message est vide.</div>';
        }else {
            //hacher les ' qui serai envoyé dans le message
            $_POST['message'] = addslashes( $_POST['message']);
            //htmlspecialchars() // permet de rendre inoffensive les balises html en réécrivant les balises en chaines de caractere non interpreté.
            $_POST['message'] = htmlspecialchars( $_POST['message']);
            //strip_tags(); permet de supprimer les balises html
         //   $_POST['message'] = strip_tags( $_POST['message']);

            $sql = 'INSERT INTO commentaire VALUES(NULL, "' .$_POST['pseudo']. '", "' .$_POST['message']. '", NOW())';
            $nbRow = $bdd->exec($sql);
            if($nbRow == 0) {
                $errReq = '<div class="error">une erreur lors de l\'envoi de votre message, veuillez re-essayé.</div>';
                $_POST['message'] = stripslashes ( $_POST['message']);
            }else {
                $_POST['message']='';
                $sql='';
                $affInsert = '<p class="info">Message enregistré</p>';
            }
        }
    }
    /*================================================================
    ========== SUPPRESSION d'un commentaire  dans la base ===============  
      =================================================================*/
    if($_GET){
        $sqlDelet = 'DELETE FROM commentaire where id_commentaire='.$_GET['del'];
        $bdd->exec($sqlDelet);
      }
      
    /*================================================================
    ========== récupération des messages dans la base ================
    =================================================================*/
    $res = $bdd->query("SELECT *,
                                DATE_FORMAT(date_enregistrement, '%d/%m/%Y') as datefr,
                                DATE_FORMAT(date_enregistrement, '%H:%i:%s') as heurefr
                                     FROM commentaire ORDER BY date_enregistrement desc");
    //affichage des messages
    $nbMessage = $res->rowCount();
    if($nbMessage > 0) {
        //uniquement si j'ai des données dans la table
        $affMessage = '<fieldset><legend>Messages : '.$nbMessage.'</legend><form method="get" action="">';
        
        while($commentaire = $res->fetch(PDO::FETCH_ASSOC)) {
            $affMessage .= '<div class="message">
                                <div class="titre">            
                                    par : <span class="pseudo">'. $commentaire['pseudo'] .'</span>, le ' . $commentaire['datefr'] .' à ' . $commentaire['heurefr'] . '  
                                </div>
                                <div class="contenu">
                                    '.$commentaire['message'].'
                                    <input type="hidden" name="id" value="'.$commentaire['id_commentaire'].'" />
                                 <a href="?del='.$commentaire['id_commentaire'].'">supprimier</a>
                                </div>
                            </div>';
        }
        $affMessage .= '</form></fieldset>';
    }

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
    body {
        background: #e2e2e2;
    }
        form{width: 400px; margin:auto;}
        input{margin-left:20px;}
        textarea{height: 100px; width: 300px; margin-left:10px;}
        .error{
            color:red; border: 1px solid red; padding:2px;
        }
        .message{
            background: lightgrey;
            margin-top: 10px; 
            padding: 15px;
        }
        .titre{
            font-size:20px;
            margin-bottom:10px;
            border-bottom:1px dotted grey;
        }
        .info{
            padding:2px;
            color: green;
            border: 1px solid green;
        }
        .pseudo{
            color: #7a3535;
        }
    </style>
    <title>Dialogue</title>
</head>
<body>
    
    <form action="" method="post">
        <fieldset>
            <legend>Formulaire</legend>
            <p><label for="pseudo">Pseudo :</label><input type="text" id="pseudo" name="pseudo" value="<?= $_POST['pseudo'] ?? ''?>"/></p>
            <p><label for="message">Message :</label></p>
            <textarea id="message" name="message"><?= $_POST['message'] ?? '' ?></textarea>
            <p><input type="submit" name="poster" value="Poster"></p>
            <?= $errPost ?? '' ?>
            <?= $errReq ?? '' ?>
        </fieldset>
    </form>
    <?= $affInsert ?? '' ?>
    <?= $affMessage ?? '' ?>
</body>
</html>