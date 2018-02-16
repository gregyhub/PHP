<?php
    require_once('inc/init.php');

    $content = '';
    $contenu_gauche='';
    $contenu_droit = '';

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
            <li class="<?= isset($_GET['categorie']) && $_GET['categorie']==$categorie['categorie'] ? 'active' : '' ?>"><a href="index.php?categorie=<?= $categorie['categorie'] ?>"><?= ucfirst($categorie['categorie']) ?></a></li>
            <?php
        }
        ?></ul><?php
    }
	$contenu_gauche = ob_get_clean();

   
    // 1 - Controler l'existence du produit demandé
    if ( isset($_GET['id_produit']) )
    {
        $resul = executeRequete("SELECT * FROM produit WHERE id_produit=:id_produit",array('id_produit' => $_GET ['id_produit']));
        if ( $resul ->rowCount() == 0)
        {
            header('location:index.php');
            exit();
        }
        // Si j'arrive ici c'est que j'ai un produit en base
        // 2 - Affichage et mise en forme de la fiche produit
        $produit=$resul->fetch(PDO::FETCH_ASSOC);
        

        $contenu_droit .= '<div class="row">
                        <div class="col-sm-12">
                            <h1 class="page-header">' .$produit['titre'].'</h1>
                        </div>
                    </div>';

        $contenu_droit .= '<div class="col-md-8">
                        <img class="img-responsive" src="photos/'.$produit['photo'].'" alt="" title="">                        
                    </div>';     

        $contenu_droit .= '<div class="col-md-4">
                        <h3>Description</h3>
                        <p>'.$produit['description'].'</p>
                        <h3>Détails</h3>
                        <ul>
                            <li>Catégorie : '.$produit['categorie'].'</li>
                            <li>Couleur : '.$produit['couleur'].'</li>
                            <li>Taille : '.$produit['taille'].'</li>
                        </ul>
                        <p class="lead">Prix : '.$produit['prix'].' €</p>                    
                    </div>';    

        //GERER L'AFFICHAGE DE L'AJOUT AU PANIER
        
        if ( $produit['stock'] > 0 ) 
        {
            $contenu_droit .='<div class="col-md-4">
                            <form method="post" action="panier.php">
                                <input type="hidden" name="id_produit" value="'.$produit['id_produit'].'">
                                <select name="quantite" class="form-group-sm form-control-static">';
                                // pour les quantités, on fixe un maximum a 5 à concurrence du stock disponible
            for ($i=1; $i<=$produit['stock'] && $i <=5; $i++)
            {
                $contenu_droit .='<option>'.$i.'</option>';                                            
            }
                $contenu_droit .='</select>
                                <input type="submit" name="ajout_panier" value="Ajouter au panier" class="btn bn-primary">
                                </form>
                            </div>';      
        }
        else 
        {
            $contenu_droit .='<div class="col-sm-4">
                            <p>Produit insidponible</p>
                        </div>';    
        }

        // Lien de retour à la boutique (en pré selectionnant la categorie du produit consulté)
        $contenu_droit .='<div class="col-md-4">
                        <p>
                            <a href="index.php?categorie='.$produit['categorie'].'">Produit de même catégorie</a>
                        </p>
                    </div>';    

        //Construction de la variable $aside// Exercice : alimenter aside
        // 1. Ecrire la requete pour selectionner les produits de même catégorie différents du produit consulté et limité a 2 produits
        // 2. exploiter le resultat pour stocker dans la variable aside le contenu html qui contiendra au moins la photo en vignette et le titre de l'article, et un lien pour aller sur sa fiche produit.    
        
    
        $resul = executeRequete("SELECT id_produit,photo,titre FROM produit WHERE categorie=:categorie AND id_produit != :id_produit limit 0,2",
        array('categorie' => $produit['categorie'],      // je dois mettre dans array autant d'entrée qu'il y a de variables
            'id_produit' => $produit['id_produit'] ));
        $aside='';
        while ( $suggestion = $resul->fetch(PDO::FETCH_ASSOC) ) 
        {
            $aside .='<div class="col-sm-3">
                        <div class="thumbnail">
                            <a href="?id_produit='.$suggestion['id_produit'].'">
                                <img class="img-responsive" src="photos/'.$suggestion['photo'].'"></a>
                                <div class="caption">
                                    <h4 class="text-center">'.$suggestion['titre'].'</h4>
                                </div>
                        </div>     
                    </div>';
        }
    }

    else
    {
        header('location:index.php');
            exit();
    }
    $popup = '';
    // Affichage de la confirmation de l'ajout de l'article au panier
    if (isset($_GET['statut_produit']) && $_GET['statut_produit'] == 'ajoute' )
    {
        $popup = '<div class="modal fade" id="myModal" role ="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Le produit à bien été ajouté au panier</h4>
                    </div>
                    <div class="modal-body">
                    <p><a href="panier.php">Voir le panier</a></p>
                    <p><a href="index.php">Continuer ses achats</a></p>
                    </div>
                </div>
            </div>
        </div>'; 
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
            <div class="row">
                <?= $aside ?>
            </div>
        </div>
    </div>
    <?php
	$content = ob_get_clean();


    include('inc/gabarit.php');

?>

<?php





echo $popup;
?>

<!-- Eventuel html -->
<script>
$(function(){
    $('#myModal').modal("show");
});
</script>