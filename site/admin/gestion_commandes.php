<?php
    require_once('../inc/init.php');

   
   if(isset($_GET['traitement']) && $_GET['traitement']=='envoi' && estConnecteEtAdmin()){
        $sql='UPDATE commande SET etat = "envoyé" WHERE id_commande=:id_commande';
        $param = array(
            "id_commande" => $_GET["id_commande"]
        );
        $up = executeRequete($sql,$param);
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
        $AffCmd = ob_get_clean();

    }else {
        ob_start();
       /*  $sql = 'SELECT  c.id_commande, c.montant, c.date_enregistrement, c.etat, 
                        dc.quantite, dc.prix,
                        m.id_membre, m.pseudo, m.nom, m.prenom,
                        p.id_produit, p.titre, p.reference
         FROM details_commande dc, produit p, membre m, commande c WHERE dc.id_produit=p.id_produit AND m.id_membre = c.id_membre AND dc.id_commande = c.id_commande '; */
         $sql = 'SELECT c.id_commande, c.montant, c.date_enregistrement, c.etat,
                            m.id_membre, m.pseudo, m.nom, m.prenom
                 FROM membre m, commande c WHERE m.id_membre = c.id_membre';
        $param = array();   
        if(!empty($_POST['recherche'])) { // seuelemtn si je fais une recherche
            $sql .= ' AND id_commande='.$_POST['recherche']; 
            $param = array('id' => $_POST['recherche']);
        }
        $AllCommandes = executeRequete($sql,$param);

    
        if($AllCommandes->rowCount() == 0) {
            //pas de commande dans la base
            ?>
            <div class="jumbotron">
                <p>Il n'y a aucune commande à afficher</p>
            </div>
        <?php
        }
        else {//si il y a des commande, je les affiches
            ?>
                <table class="table">
                    <tr class="info">
                        <th class="text-center"></th>
                        <th class="text-center">N° Commande</th>
                        <th class="text-center">Pseudo du Membre</th>
                        <th class="text-center">Nom complet</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Montant</th>
                        <th class="text-center">Etat</th>
                        <th class="text-center">traiter</th>
                    </tr> <!-- fin de ligne d'entete -->
                <?php
            while($commande = $AllCommandes->fetch(PDO::FETCH_ASSOC)){
               
                ?>
                <tr>
                    <td class="text-center">
                        <button class="detailCmd" data="<?= $commande['id_commande'] ?>" type="button" href="" title="Affichez le détail de la commande">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            <span class="glyphicon glyphicon-minus" aria-hidden="true">
                        </button>
                    </th>
                    <td class="text-center"><?= $commande['id_commande'] ?></th>
                    <td class="text-center"><?= $commande['pseudo'] ?></th>
                    <td class="text-center"><?= $commande['prenom'].' '.$commande['nom'] ?></th>
                    <td class="text-center"><?= $commande['date_enregistrement'] ?></th>
                    <td class="text-center"><?= $commande['montant'] ?>€</th>
                    <td class="text-center <?= $commande['etat']=='en cours de traitement' ? 'text-danger' : 'text-success' ?>"><?= $commande['etat'] ?></th>
                    <td class="text-center">
                        <?= $commande['etat']=='en cours de traitement' ? '<a href="?traitement=envoi&id_commande='.$commande['id_commande'].'">valider la commande</a>' : 'mettre la commande à l\'état en cours' ?>
                    </th>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="6">
                    <!-- TABLEAU PRODUITS -->
                        <table class="table prod" id="<?= $commande['id_commande'] ?>">
                            <tr class="info">
                                <th class="text-center">Nom du produit</th>
                                <th class="text-center">quantité</th>
                                <th class="text-center">prix unitaire</th>
                                <th class="text-center">prix</th>
                            </tr>
                        <?php
                        //requete pour récupérer les produit de la commande
                        $sql = 'SELECT dc.quantite, dc.prix,
                                        p.id_produit, p.titre, p.reference
                                FROM details_commande dc, produit p WHERE dc.id_produit=p.id_produit AND id_commande=:id_commande';
                        $produits = executeRequete($sql, array('id_commande' => $commande['id_commande']));
                        while($prod = $produits->fetch(PDO::FETCH_ASSOC)){
                        ?>
                             <tr>
                                <td class="text-center"><?= $prod['titre'] ?></td>
                                <td class="text-center"><?= $prod['quantite'] ?></td>
                                <td class="text-center"><?= $prod['prix'] ?>€</td>
                                <td class="text-center"><?= $prod['prix'] * $prod['quantite'] ?>€</td>
                            </tr>
                        <?php
                        }
                        ?>
                        </table>
                    </td>
                    <td></td>
                </tr>
                <?php
            }
            ?>
            </table>
        <?php
        }

        $AffCmd = ob_get_clean();

    } //fin du else CONNECTE et ADMIN
    ob_start();
    ?>

    <div class="row">
        <form method="post" action="" class="navbar-form navbar-left">
            <div class="form-group">
                <input type="text" name="recherche" class="form-control" placeholder="Search">
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
        </form>
        <?= $AffCmd ?>
    </div>
    <?php
    $content = ob_get_clean();

    include('../inc/gabarit.php');

?>
