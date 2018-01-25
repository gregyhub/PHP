<?php
    require_once('../inc/init.php');

    if($_POST){
        //je fais les controles sur les champs 
        $controleChamps = champVide($_POST);
        $errorInscription = $controleChamps['champsvides'];

        if($errorInscription['nbError']==0) {
            //il n'y a pas de champs vide donc je continue de tester les champs

            $listeChamps =  $controleChamps['champsvalides'];
            $sql = "INSERT INTO produit values (NULL, :reference, :categorie, :titre, :description, :couleur, :taille, :public, :photo, :prix, :stock)";
           
            $insert = executeRequete($sql,  $listeChamps);
            header("location:?action=affichage");
            exit();
        }
    }


    if( !estConnecteEtAdmin()){
        //vérification des autorisation ! Il faut etre admin pour afficher la page
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
        ?>
            <ul class="nav nav-tabs">
                <li><a href="?action=affichage">Affichage des Produits</a></li>
                <li><a href="?action=ajout">Ajouter un Produit</a></li>
            </ul>
        <?php

        if( (isset($_GET['action']) && $_GET['action']=='affichage') || !isset($_GET['action'])){
            //affichage des produits -> action par défaut.

            $sql = "SELECT * FROM produit";
            $produits = executeRequete($sql);

            if($produits->rowCount() == 0){
                //si aucun article dans la base
                ?>
                    <div class="jumbotron">
                        <p>il n'y a aucun produit disponible sur votre site.</p>
                        <p>cliquez sur le lien ci-joint pour ajouter votre premier article : <a href="?action=ajout">ajouter un produit</a></p>
                    </div>
                <?php
            }
            else{
                //si il y a des articles, je les affiche ici

            }
        }
        elseif(isset($_GET['action']) && $_GET['action']=='ajout'){
            //je prépare le select option pour la Categorie
            $sql = "SELECT DISTINCT categorie FROM produit";
            $AllCatProduits = executeRequete($sql);
            
            //formulaire pour ajouter ou modifier un produit
            ?>
            <form id="produit" action="" method="post" enctype="multipart/form-data">
                <div class="form-group <?= isset($errorInscription['reference']) ? 'has-error' : '' ?>">
                    <label for="reference">Reference</label>
                    <input type="text" class="form-control" id="reference" name="reference" placeholder="saisissez la reference" value="<?= $_POST['reference'] ?? '' ?>">
                    <?= $errorInscription['reference'] ?? '' ?>
                </div>
                <div class="form-group <?= isset($errorInscription['titre']) ? 'has-error' : '' ?>">
                    <label for="titre">Titre</label>
                    <input type="text" class="form-control" id="titre" name="titre" placeholder="saisissez le titre" value="<?= $_POST['titre'] ?? '' ?>">
                    <?= $errorInscription['titre'] ?? '' ?>
                </div>
                <?php
                if($AllCatProduits->rowCount() == 0){
                    //affichage spécifique pour les catégories -> si aucnue catégorie en base pour en ajouter une nouvelle
                    ?>
                    <div class="form-group ajout-categ <?= isset($errorInscription['categorie']) ? 'has-error' : '' ?>">
                        <label for="categorie">Ajouter une nouvelle catégorie</label>
                        <input type="text" class="form-control" id="categorie" name="categorie" placeholder="saisissez la categorie" value="<?= $_POST['categorie'] ?? '' ?>">
                        <?= $errorInscription['categorie'] ?? '' ?>
                    </div>
                    <?php
                }else{
                    //si j'ai déjà des catégories j'affiche un select/option
                    ?>
                    <select class="form-control">
                    <?php
                    while($OneCat = $AllCatProduits->fetch(PDO::FETCH_ASSOC)){
                        var_dump($OneCat);
                        ?>
                            <option><?= $OneCat['categorie'] ?></option>
                        <?php
                    }
                    ?>
                    </select>
                    <?php
                }
                
                ?>
                <div class="form-group <?= isset($errorInscription['description']) ? 'has-error' : '' ?>">
                    <label for="description">Description -> textarea</label>
                    <input type="text" class="form-control" id="description" name="description" placeholder="saisissez la description" value="<?= $_POST['description'] ?? '' ?>">
                    <?= $errorInscription['description'] ?? '' ?>
                </div>
                <div class="form-group <?= isset($errorInscription['couleur']) ? 'has-error' : '' ?>">
                    <label for="couleur">Couleur</label>
                    <input type="text" class="form-control" id="couleur" name="couleur" placeholder="saisissez la couleur" value="<?= $_POST['couleur'] ?? '' ?>">
                    <?= $errorInscription['couleur'] ?? '' ?>
                </div>
                <div class="form-group <?= isset($errorInscription['taille']) ? 'has-error' : '' ?>">
                    <label for="taille">Taille</label>
                    <input type="text" class="form-control" id="taille" name="taille" placeholder="saisissez la taille" value="<?= $_POST['taille'] ?? '' ?>">
                    <?= $errorInscription['taille'] ?? '' ?>
                </div>
                <div class="form-group <?= isset($errorInscription['public']) ? 'has-error' : '' ?>">
                    <label for="public">Public</label>
                    <input type="text" class="form-control" id="public" name="public" placeholder="saisissez le public" value="<?= $_POST['public'] ?? '' ?>">
                    <?= $errorInscription['public'] ?? '' ?>
                </div>
                <div class="form-group <?= isset($errorInscription['photo']) ? 'has-error' : '' ?>">
                    <label for="photo">photo -> fichier + changer le FORM</label>
                    <input type="text" class="form-control" id="photo" name="photo" placeholder="saisissez la photo" value="<?= $_POST['photo'] ?? '' ?>">
                    <?= $errorInscription['photo'] ?? '' ?>
                </div>
                <div class="form-group <?= isset($errorInscription['prix']) ? 'has-error' : '' ?>">
                    <label for="prix">prix</label>
                    <input type="text" class="form-control" id="prix" name="prix" placeholder="saisissez le prix" value="<?= $_POST['prix'] ?? '' ?>">
                    <?= $errorInscription['prix'] ?? '' ?>
                </div>
                <div class="form-group <?= isset($errorInscription['stock']) ? 'has-error' : '' ?>">
                    <label for="stock">Stock</label>
                    <input type="text" class="form-control" id="stock" name="stock" placeholder="saisissez le stock" value="<?= $_POST['stock'] ?? '' ?>">
                    <?= $errorInscription['stock'] ?? '' ?>
                </div>
                
                
                
                <button type="submit" class="btn btn-primary">Créez le Produit</button>
                <?=  $errorLog ?? '' ?>
            </form>
            <?php
        }

        $content = ob_get_clean();

    }


   

    include('../inc/gabarit.php');

?>
