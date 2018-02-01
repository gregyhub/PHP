<?php
    require_once('../inc/init.php');

   //suppression d'un article
   if(isset($_GET['action']) && $_GET['action']=='supprimer' && estConnecteEtAdmin()){
       if(isset($_GET['id_produit'])){
        //je vérifie que l'id existe
            $sql="SELECT * FROM produit WHERE id_produit=:id_produit";
            $produitASupprimer = executeRequete($sql, array('id_produit' => $_GET['id_produit']));
            if($produitASupprimer->rowCount()==0){
                ?>
                <div class="jumbotron">
                    <p>Le produit que vous souhaitez supprimer n'existe pas.</p>
                </div>
                <?php
            } elseif($produitASupprimer->rowCount()==1){
                //le produit existe dans la base, je le supprime
                $sql="DELETE FROM produit WHERE id_produit=:id_produit";
               executeRequete($sql, array('id_produit' => $_GET['id_produit']));
               
            }
        }
        $_GET['id_produit']='';
        $_GET['action']='affichage';
   }

    //formulaire Ajout/modification d'un produit
    if($_POST && estConnecteEtAdmin()){
        //je fais les controles sur les champs 
        $controleChamps = champVide($_POST);
        $errorInscription = $controleChamps['champsvides'];
        //je test si l'id prod envoyé en post est identique à celui envoyé en get
        if($errorInscription['nbError']==0) {
            //il n'y a pas de champs vide donc je continue de tester les champs

            $listeChamps =  $controleChamps['champsvalides']; // cette variable contient tous les paramètres à envyer pour la requete sql.

            //controle sur la photo
            if(!empty($_FILES['photo']['name'])){
                $uploadPhoto = UploadPhoto($_FILES['photo']);
                echo $uploadPhoto['message'];
                $listeChamps['photo']=$uploadPhoto['nom']; // le nom du fichier photo
            }elseif(empty($_FILES['photo']['name']) && empty($_POST['photo'])){
                $listeChamps['photo']='';
            }

            //je gere le paramtre 'catégorie' pour la requete
            if(empty($_POST["categorie"])) {
                $listeChamps['categorie'] = $listeChamps['selectCateg'];
            }
            unset($listeChamps['selectCateg']);
            
            $sql = "REPLACE INTO produit values (:id_produit, :reference, :categorie, :titre, :description, :couleur, :taille, :public, :photo, :prix, :stock)";
           
            vdm($listeChamps);
            $insert = executeRequete($sql,  $listeChamps);
            $_GET['action']='affichage';
        }
    }


    if( !estConnecteEtAdmin()){
        //vérification des autorisation ! Il faut etre admin pour afficher la page
        ob_start();
        ?>
            <div class="jumbotron">
                <p>vous n'avez pas l'autorisation d'être sur cette Page.<br>Authentifiez vous.</p>
                <a href="../connexion.php">Pour vous connecter</a><br>
                <a href="../index.php">Pour vous retourner à l'accueil</a>
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
                //je vais afficher un tableau avec comme entete le nom des champs.
                ?>
                <table class="table  table-striped table-hover">
                    <tr>
                    <?php
                        //je génère les entete de colonnes
                        $nbColonnes = $produits->columnCount();
                        for($i=0; $i<$nbColonnes; $i++){
                            $infosColonne = $produits->getColumnMeta($i);
                            //donne dans un tableau les infos pour une colonne pour chaque index de  0 à N.
                            //ce tableau, à l'index 'name' donne le nom du champs.
                            ?>
                            <th class="text-center"><?= $infosColonne['name'] ?></th>
                            <?php
                        }
                    ?>
                        <th class="text-center">Modifier</th>
                        <th class="text-center">Supprimer</th>
                    </tr> <!-- fin de ligne d'entete -->
                <?php
                    while($OneProd = $produits->fetch(PDO::FETCH_ASSOC)){
                        $idProd = $OneProd['id_produit'];
                        ?>
                        <tr>
                        <?php
                        foreach($OneProd as $infoProd){
                            
                            ?>
                            <td class="text-center"><?= $infoProd ?></td>
                            <?php
                            //
                        }
                        ?>
                            <th class="text-center"><a href="?action=modifier&id_produit=<?= $idProd ?>"><span class="glyphicon glyphicon-pencil"></span><a></th>
                            <th class="text-center"><a href="?action=supprimer&id_produit=<?= $idProd ?>"><span class="glyphicon glyphicon-remove"></span></a></th>
                        </tr>
                        <?php
                    }
                ?>
                </table>

                <?php
                

            }
        }
        elseif(isset($_GET['action'])){
            
            if($_GET['action']=='modifier'){
                if(isset($_GET['id_produit'])){
                //je vérifie que l'id existe
                    $sql="SELECT * FROM produit WHERE id_produit=:id_produit";
                    $produitAModifier = executeRequete($sql, array('id_produit' => $_GET['id_produit']));
                    if($produitAModifier->rowCount()==0){
                        ?>
                        <div class="jumbotron">
                            <p>Le produit que vous souhaitez modifier n'existe pas.</p>
                        </div>
                        <?php
                    } elseif($produitAModifier->rowCount()==1){
                        //le produit existe dans la base
                        $_GET['action']='ajout';
                        $_POST=$produitAModifier->fetch(PDO::FETCH_ASSOC);
                    }
                }else{
                    //l'action correspond à 'modifier' mais le 2eme parametre id est différent 
                    ?>
                    <div class="jumbotron">
                        <p>l'action que vous demandez n'existe pas</p>
                    </div>
                    <?php
                }
            }
            if($_GET['action']=='ajout') {
            //j'ajoute ou je modifie un produit
            //je prépare le select option pour la Categorie
            $sql = "SELECT DISTINCT categorie FROM produit";
            $AllCatProduits = executeRequete($sql);
            
            //formulaire pour ajouter ou modifier un produit
            ?>
            <!-- ========================== 
                DEBUT DE FORMULAIRE 
                ============================ -->
            <form id="produit" action="" method="post" enctype="multipart/form-data">
            <!-- un champs input avec l'id_produit si il existe pour modifier le produit sinon un inputvide -->
            <input type="hidden"  name="id_produit" value="<?= $_POST['id_produit'] ?? 'NULL' ?>">

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
                    <div class="form-group <?= isset($errorInscription['categorie']) ? 'has-error' : '' ?>">
                        <label for="selectCateg">Catégorie</label>
                        <select id="selectCateg" name="selectCateg" class="form-control">
                            <option value="choisir" selected disabled>choisissez une catégorie</option>
                        <?php
                        while($OneCat = $AllCatProduits->fetch(PDO::FETCH_ASSOC)){
                            ?>
                                <option value="<?=$OneCat['categorie'] ?>" <?= isset($_POST['categorie']) && $_POST['categorie'] == $OneCat['categorie'] ? 'selected' : '' ?>><?= $OneCat['categorie'] ?></option>
                            <?php
                        }
                        ?>
                            <option value="nouvelleCat" <?= isset($_POST['selectCateg']) && $_POST['selectCateg'] == "nouvelleCat" ? 'selected' : '' ?>>Ajouter une nouvelle Catégorie</option>
                        </select>
                    
                        <input  <?= isset($_POST['selectCateg']) && $_POST['selectCateg'] == "nouvelleCat"  ? '' :  'style="display:none;"' ?>   type="text" class="form-control ajout-categ" id="categorie" name="categorie" placeholder="saisissez la categorie" value="<?= $_POST['categorie'] ?? '' ?>">
                        <?= $errorInscription['categorie'] ?? '' ?>
                    </div>
                    <?php
                }
                ?>
                <div class="form-group <?= isset($errorInscription['description']) ? 'has-error' : '' ?>">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" placeholder="saisissez la description"><?= $_POST['description'] ?? '' ?></textarea>
                    <?= $errorInscription['description'] ?? '' ?>
                </div>

                <div class="form-group <?= isset($errorInscription['couleur']) ? 'has-error' : '' ?>">
                    <label for="couleur">Couleur</label>
                    <input type="text" class="form-control" id="couleur" name="couleur" placeholder="saisissez la couleur" value="<?= $_POST['couleur'] ?? '' ?>">
                    <?= $errorInscription['couleur'] ?? '' ?>
                </div>
                
                <div class="form-group <?= isset($errorInscription['taille']) ? 'has-error' : '' ?>">
                    <label for="taille">Taille</label>
                    <select class="form-control" id="taille" name="taille">
                        <option value="s" <?= isset($_POST['taille']) && $_POST['taille']=='s' ? 'selected' : '' ?>>S</option>
                        <option value="m" <?= isset($_POST['taille']) && $_POST['taille']=='m' ? 'selected' : '' ?>>M</option>
                        <option value="l" <?= isset($_POST['taille']) && $_POST['taille']=='l' ? 'selected' : '' ?>>L</option>
                        <option value="xl" <?= isset($_POST['taille']) && $_POST['taille']=='xl' ? 'selected' : '' ?>>XL</option>
                    </select>                   
                    <?= $errorInscription['taille'] ?? '' ?>
                </div>

                <div class="form-group <?= isset($errorInscription['public']) ? 'has-error' : '' ?>">
                    <label for="public">Public</label>
                    <div class="radio">
                        <label>
                            <input type="radio" name="public" id="publicm" value="m" <?= isset($_POST['public']) && $_POST['public']=='m' ? 'checked' : '' ?>>
                            Homme
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="public" id="publicf" value="f" <?= isset($_POST['public']) && $_POST['public']=='f' ? 'checked' : '' ?>>
                            Femme
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="public" id="publicmmixte" value="mixte" <?= isset($_POST['public']) && $_POST['public']=='mixte' ? 'checked' : '' ?>>
                            Mixte
                        </label>
                    </div>
                    <?= $errorInscription['public'] ?? '' ?>
                </div>

                <div class="form-group <?= isset($errorInscription['photo']) ? 'has-error' : '' ?>">
                    <label for="photo">photo </label>
                    <input type="file" class="form-control" id="photo" name="photo" value="<?= $_POST['photo'] ?? '' ?>">
                    <?= $errorInscription['photo'] ?? '' ?>
                </div>
                <!-- si il y a déjà une photo dans la base, je l'affiche dans la balise img -->
                
                <?= !empty($_POST['photo']) ? 
                    '<input type="hidden" name="photo" value="'.$_POST['photo'].'">
                    <img src="'.RACINE_SITE.'photos/'.$_POST['photo'].'" alt="" title="" />'
                    : '' 
                ?>

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
                
                <button type="submit" class="btn btn-primary"><?= isset($produitAModifier) ? 'Modifier votre produit' : 'Créez le Produit'?></button>
                <?=  $errorLog ?? '' ?>
            </form>
            <?php
            } // fin du get action modifier / ajouter

        $content = ob_get_clean();

        } //fin du get
    }

   

    include('../inc/gabarit.php');

?>
