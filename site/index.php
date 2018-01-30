<?php
    require_once('inc/init.php');

    $content = '';
    $contenu_gauche='';
    $contenu_droit = 'testdroit';

    //gestion du menu des catégorie
    $sql = "SELECT DISTINCT categorie FROM produit";
    $menuCategories = executeRequete($sql);
    ob_start();
    if($menuCategories->rowCount()==0){
        ?><div>aucune catégorie à afficher</div><?php
    }else{
        ?><ul class="nav nav-pills nav-stacked"><?php
        while($categorie = $menuCategories->fetch(PDO::FETCH_ASSOC)){
           ?>
            <li class="<?= isset($_GET['categorie']) && $_GET['categorie']==$categorie['categorie'] ? 'active' : '' ?>"><a href="?categorie=<?= $categorie['categorie'] ?>"><?= ucfirst($categorie['categorie']) ?></a></li>
            <?php
        }
        ?></ul><?php
    }
	$contenu_gauche = ob_get_clean();

    //affichage des produits d'une categorie
    if(isset($_GET['categorie'])){
        $sql = "SELECT * FROM produit WHERE categorie = :categorie";
        $prodCategorie = executeRequete($sql, array('categorie' => $_GET['categorie']));
        ob_start();
        if($prodCategorie->rowCount()==0){
            ?><div class="jumbotron">aucun prodduit à afficher correspondant à la catégorie choisie</div><?php
        }else{
            while($produit = $prodCategorie->fetch(PDO::FETCH_ASSOC)){
            ?>
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                        <a href="fiche_produit.php?id_produit=<?= $produit['id_produit'] ?>">
                        <img src="<?= RACINE_SITE.'photos/'.$produit['photo'] ?>" alt="...">
                        <div class="caption">
                            <h3><?= $produit['titre'] ?></h3>
                            <p class="text-center btnPanier"><a href="#" class="btn btn-primary" role="button">ajouter au panier</a></p>
                        </div>
                        </a>
                    </div>
                </div>
                <?php
            }
        }
        $contenu_droit = ob_get_clean();
    }
    else {
        //gestion affichage de tous les produits (sans GET)
        $sql = "SELECT * FROM produit";
        $affichageProduits = executeRequete($sql);
        ob_start();
        if($affichageProduits->rowCount()==0){
            ?><div>aucun prodduit à afficher</div><?php
        }else{
            while($produit = $affichageProduits->fetch(PDO::FETCH_ASSOC)){
            ?>
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                        <a href="fiche_produit.php?id_produit=<?= $produit['id_produit'] ?>">
                        <img src="<?= RACINE_SITE.'photos/'.$produit['photo'] ?>" alt="...">
                        <div class="caption">
                            <h3><?= $produit['titre'] ?></h3>
                            <p class="text-center btnPanier"><a href="#" class="btn btn-primary" role="button">ajouter au panier</a></p>
                        </div>
                        </a>
                    </div>
                </div>
                <?php
            }
        }
        $contenu_droit = ob_get_clean();
    }
    
    

    ob_start();
	?>
    <div class="row">
        <div class="col-md-3">
            <?= $contenu_gauche ?>
        </div>
        <div class="col-md-9">
            <div class="row">
                 <?= $contenu_droit ?>
            </div>
        </div>
    </div>
    <?php
	$content = ob_get_clean();


    include('inc/gabarit.php');

?>