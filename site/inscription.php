<?php
    require_once('inc/init.php');

    if($_POST){

        //je fais les controles sur les champs 
        $controleChamps=champVide($_POST);
        $errorInscription = $controleChamps['champsvides'];

        if($errorInscription['nbError']==0) {
            //il n'y a pas de champs vide donc je continue de tester les champs

            //je controle que le pseudo soit disponible en AJAX -> monJS.js + ajax.php

            //vérifier qu'une chaine de caractère contient les caractères autorisé
             $verif_caractere = preg_match('#^[a-zA-Z0-9._-]+$#', $_POST['pseudo']);
             $verif_cp = preg_match('#^[0-9]{5}$#', $_POST['cp']);
            /*
                # - delimite l'expression au début et à la fin
                ^ signifie commence par tout ce qui suit
                $ signifie finit par tout ce qui précède
                [] pour delimiter les intervals
                + pour dire que les caractères sont accepté de 0 à x fois.
            */

            $mdpCrypte = md5($_POST['mdp']);
            $controleChamps['champsvalides']['mdp'] = $mdpCrypte;
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                //email non valide
            }

            //pas d'erreur donc j'ajoute le membre dans la base
            $listeChamps =  $controleChamps['champsvalides'];
            $sql = "INSERT INTO membre values (NULL, :pseudo, :mdp, :nom, :prenom, :email, :sexe, :ville, :cp, :adresse, 0)";
           
            $insert = executeRequete($sql,  $listeChamps);
            header("location:connexion.php?action=inscription");
            exit();
        }
        


   }

    ob_start();
	?>
	<form id="inscription" action="" method="post">
        <div class="form-group <?= isset($errorInscription['pseudo']) ? 'has-error' : '' ?>">
            <label for="pseudo">Pseudo</label>
            <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="saisissez votre pseudo" value="<?= $_POST['pseudo'] ?? '' ?>">
            <?= $errorInscription['pseudo'] ?? '' ?>
        </div>
        <div class="form-group <?= isset($errorInscription['prenom']) ? 'has-error' : '' ?>">
            <label for="prenom">Prenom</label>
            <input type="text" class="form-control" id="prenom" name="prenom" placeholder="saisissez votre prenom" value="<?= $_POST['prenom'] ?? '' ?>">
            <?= $errorInscription['prenom'] ?? '' ?>
        </div>
        <div class="form-group <?= isset($errorInscription['nom']) ? 'has-error' : '' ?>">
            <label for="nom">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" placeholder="saisissez votre nom" value="<?= $_POST['nom'] ?? '' ?>">
            <?= $errorInscription['nom'] ?? '' ?>
        </div>
        <div class="form-group <?= isset($errorInscription['email']) ? 'has-error' : '' ?>">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="saisissez votre email" value="<?= $_POST['email'] ?? '' ?>">
            <?= $errorInscription['email'] ?? '' ?>
        </div>
        <div class="form-group <?= isset($errorInscription['sexe']) ? 'has-error' : '' ?>">
        <label>Sexe</label>
            <div class="radio">
                <label>
                    <input type="radio" name="sexe" id="femme" value="f" checked <?php if(!empty($_POST['sexe']) && $_POST['sexe'] == "f"){ echo 'checked';} else { echo '';} ?> />
                Femme
                </label>
                </div>
                <div class="radio">
                <label>
                    <input type="radio" name="sexe" id="homme" value="m" <?php if(!empty($_POST['sexe']) && $_POST['sexe'] == "m"){ echo 'checked';} else { echo '';} ?> />
                Homme
                </label>
                <?= $errorInscription['sexe'] ?? '' ?>
            </div>
        </div>
        <div class="form-group <?= isset($errorInscription['ville']) ? 'has-error' : '' ?>">
            <label for="ville">Ville</label>
            <input type="text" class="form-control" id="ville" name="ville" placeholder="saisissez votre ville" value="<?= $_POST['ville'] ?? '' ?>">
            <?= $errorInscription['ville'] ?? '' ?>
        </div>
        <div class="form-group <?= isset($errorInscription['adresse']) ? 'has-error' : '' ?>">
            <label for="adresse">Adresse</label>
            <input type="text" class="form-control" id="adresse" name="adresse" placeholder="saisissez votre adresse" value="<?= $_POST['adresse'] ?? '' ?>">
            <?= $errorInscription['adresse'] ?? '' ?>
        </div>
        <div class="form-group <?= isset($errorInscription['cp']) ? 'has-error' : '' ?>">
            <label for="cp">Code Postal</label>
            <input type="text" class="form-control" id="cp" name="cp" placeholder="saisissez votre cp" value="<?= $_POST['cp'] ?? '' ?>">
            <?= $errorInscription['cp'] ?? '' ?>
        </div>
        <div class="form-group <?= isset($errorInscription['mdp']) ? 'has-error' : '' ?>">
            <label for="mdp">Password</label>
            <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Password">
            <?= $errorInscription['mdp'] ?? '' ?>
        </div>
        
        <button type="submit" class="btn btn-primary">Création du compte</button>
        <?=  $errorLog ?? '' ?>
    </form>
	<?php
	$content = ob_get_clean();

   

    include('inc/gabarit.php');

?>
