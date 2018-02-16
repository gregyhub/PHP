<?php
    require_once('inc/init.php');

    if( !estConnecte()){
        ob_start();
        ?>
            <div class="jumbotron">
                <p>vous n'avez pas l'autorisation d'être sur cette Page.<br>Authentifiez vous ou créez un compte.</p>
                <a href="connexion.php">Pour vous connecter ou créer un compte</a><br>
                <a href="index.php">Pour vous retourner à l'accueil</a>
            </div>
            
        <?php
        $profil = ob_get_clean();

    }else {
        //affichage des Infos du Membre
        ob_start();
        ?>
            <div class="jumbotron">
            <p>Bievenu <?= $_SESSION['membre']['pseudo'] ?></p>
                </div>
        <?php    
        $profil = ob_get_clean();


        
        //affiche dans un tableau le récap des commandes
        ob_start();
        //je commence par regarder si il ya des commandes pour ce membre
        $sql = 'SELECT * FROM commande WHERE id_membre = :id_membre';
        $commandesClient = executeRequete($sql, array('id_membre'=>$_SESSION['membre']['id_membre']));
        if($commandesClient->rowCount() == 0){
            //il n'y a pas de commande pour ce membre
            ?>
            <div class="jumbotron"> <p>Vous n'avez passé aucune commande.</p><p><a href="index.php">Commencez vos achats !</a></p></div>
            <?php
        }
        else{
            while($commande = $commandesClient->fetch(PDO::FETCH_ASSOC)){
                //je récupère le détail de la commande
                $sql = 'SELECT titre, quantite, dc.prix FROM details_commande dc, produit p WHERE dc.id_produit=p.id_produit AND id_commande = :id_commande';
                $detailCommande = executeRequete($sql, array('id_commande'=>$commande['id_commande']));
                ?>
                    <table class="table table-condensed table-hover">
                        <tr class="info">
                            <th colspan="2">
                                Votre commande N°<?= $commande['id_commande'] ?> 
                            </th>
                            <th colspan="2">
                                Montant de la commande : <?= $commande['montant'] ?>€ à la date du <?= $commande['date_enregistrement'] ?> 
                            </th>
                            <th></th>
                            <th></th>
                        </tr>
                        <?php
                            //j'affiche maintenant les produit de la commande maintenant
                            while($prod = $detailCommande->fetch(PDO::FETCH_ASSOC)){
                                ?>
                                    <tr>
                                        <td>Produit : <?= $prod['titre'] ?></td>
                                        <td>Prix unitaire : <?= $prod['prix'] ?>€</td>
                                        <td>quantite : <?= $prod['quantite'] ?></td>
                                        <td>prix total : <?= $prod['prix'] * $prod['quantite'] ?>€</td>
                                    </tr>
                                <?php
                            }
                           
                        ?>
                    </table>
                <?php
            }
        }
        $commandes = ob_get_clean();
    }

    ob_start();
	?>
    <div class="row">
        <div class="col-md-6">
             <?= $profil ?? '' ?> 
        </div>
        <div class="col-md-6">
            <?= $commandes ?? '' ?> 
        </div>
        
    </div>
    <?php
    $content = ob_get_clean();



    include('inc/gabarit.php');

?>