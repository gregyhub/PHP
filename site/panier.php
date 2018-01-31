<?php

require_once('inc/init.php');

/* traitement */
if ( isset($_POST['ajout_panier']) )
{
    $resultat_de_ma_requete= executeRequete('SELECT * FROM produit WHERE id_produit=:id_produit',
    array('id_produit'=>$_POST['id_produit']));

    if ( $resultat_de_ma_requete->rowCount() > 0) /* si le resultat est superieur à 0 */
    {
        $produit=$resultat_de_ma_requete->fetch(PDO::FETCH_ASSOC);

        /* fonction d ajout au panier */
        ajouterProduitDansPanier($produit['id_produit'],$_POST['quantite'],$produit['prix']);

        /* Retour à la fiche produit avec la prise en compte de la mise au panier*/
        header('location:fiche_produit.php?statut_produit=ajoute&id_produit='.$_POST['id_produit']);

    }
    else
    {
        header('location:fiche_produit.php?id_produit='.$_POST['id_produit']);
    }
}

//Vider PANIER
if(isset($_GET['action']) && $_GET['action']=='vider'){
    unset($_SESSION['panier']);
}

//supprimer un article du panier
if(isset($_GET['action']) && $_GET['action']=='supprimer_article' && isset($_GET['id_produit'])){
    retirerProduitPanier($_GET['id_produit']);
}

//valider le panier
if(isset($_POST['valider'])){
    $id_membre = $_SESSION['membre']['id_membre'];
    $montant_total=montantTotal();

    $sql = "INSERT INTO commande (id_membre,montant,date_enregistrement) VALUES(:id_membre, :montant, NOW())";
    executeRequete($sql, array('id_membre'=>$id_membre, 'montant'=>$montant_total));
    $id_commande = $pdo->lastInsertId();
    
    for($i=0; $i<count($_SESSION['panier']['id_produit']); $i++){
        $id_produit = $_SESSION['panier']['id_produit'][$i];
        $quantite = $_SESSION['panier']['quantite'][$i];
        $prix = $_SESSION['panier']['prix'][$i];

        $sql = "INSERT INTO details_commande (id_commande, id_produit, quantite, prix) VALUES(:id_commande, :id_produit, :quantite, :prix)";
        executeRequete($sql, array('id_commande'=>$id_commande, 'id_produit'=>$id_produit, 'quantite'=>$quantite, 'prix'=>$prix));

        //maj du stock
        $sql = "UPDATE produit SET stock = stock - :quantite WHERE id_produit=:id_produit";
        executeRequete($sql, array('id_produit'=>$id_produit, 'quantite'=>$quantite));
    }
    unset($_SESSION['panier']);
    header('location:?succesCommande=succes&id_com='.$id_commande);
}

if(isset($_GET['succesCommande'])&& $_GET['succesCommande']=="succes"){
    ob_start();
    ?>
        <div class="alert alert-success">
            <p>Merci pour votre Commande. votre numéro de commande est le suivant : <?= $_GET['id_com'] ?></p>
        </div>
    <?php
    $succesCommande = ob_get_clean();
}


//affichage
ob_start();
if(empty($_SESSION['panier']['id_produit'])){
   
    ?> <div class="jumbotron">Votre panier est vide, <a href="index.php">retournez faire vos achats</a></div> <?php
}
else{
    ?> 
    <table class="table table-striped">
        <tr class="info">
            <th>Titre</th>
            <th>Identifiant</th>
            <th>Quantité</th>
            <th>Prix Unitaire</th>
            <th>Action</th>
        </tr>
    <?php
    for( $i=0; $i< count($_SESSION['panier']['id_produit']);$i++)        {

        $id_produit = $_SESSION['panier']['id_produit'][$i];
        $titreProd = executeRequete("SELECT titre FROM produit WHERE id_produit=:id_produit",array('id_produit' => $id_produit));
        $titreProd = $titreProd->fetch(PDO::FETCH_ASSOC);
        ?>
        <tr>
            <td><a href="fiche_produit.php?id_produit=<?= $id_produit ?> "><?= $titreProd['titre'] ?></a></td>
            <td><?= $id_produit ?></td>
            <td><?= $_SESSION['panier']['quantite'][$i] ?> ex.</td>
            <td><?= $_SESSION['panier']['prix'][$i] ?></td>
            <td><a href="?action=supprimer_article&id_produit=<?= $id_produit ?>">Supprimer l'article</a></td>
        </tr>
        <?php
    }  
    ?>
        <tr class="info">
                <td colspan="3">Total</td>
                <td colspan="2"><?= montantTotal() ?> €</td>
        </tr>
    <?php
        //si l'internaute est connecté, j'affiche un bouton pour valider le panier, sinon je l'invite à se connecter ou créer un compte
        if(estConnecte()){
            ?>
                <form action="" method="post">
                    <tr class="text-center">
                        <td colspan="5">
                            <input type="submit" name="valider" value="Valider le panier" class="btn btn-primary">
                        </td>
                    </tr>        
                </form>
            <?php
        }else{
            ?>
                <tr class="text-center">
                    <td colspan="5"> <p>Veuillez vous <a href="inscription.php">inscrire</a>
                             ou vous <a href="connexion.php">connecter</a> afin de valider votre panier.</p>
                        </td></td>
                </tr>
            <?php
        }
    ?>
        <tr class="text-center">
            <td colspan="5"><p><a href="?action=vider">Vider le panier</a></p></td>
        </tr>
    </table>
    <?php
}



$affPanier = ob_get_clean();
ob_start();
?>
<div class="row">
    <div class="col-md-12">
    <?= $affPanier ?>
    <?= $succesCommande ?? '' ?>
    </div>
</div>
<?php
$content = ob_get_clean();


include('inc/gabarit.php');
