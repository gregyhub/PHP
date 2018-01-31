<?php
    require_once('../inc/init.php');

 

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
        $sql = 'SELECT  c.id_commande, c.montant, c.date_enregistrement, c.etat, 
                        dc.quantite, dc.prix,
                        m.id_membre, m.pseudo, m.nom, m.prenom,
                        p.id_produit, p.titre, p.reference
         FROM details_commande dc, produit p, membre m, commande c WHERE dc.id_produit=p.id_produit AND m.id_membre = c.id_membre AND dc.id_commande = c.id_commande ';
        $AllCommandes = executeRequete($sql);

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
                <table class="table table-striped table-hover">
                <tr class="info">
                    <?php
                        //je génère les entete de colonnes
                        $nbColonnes = $AllCommandes->columnCount();
                        for($i=0; $i<$nbColonnes; $i++){
                            $infosColonne = $AllCommandes->getColumnMeta($i);
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
            while($commande = $AllCommandes->fetch(PDO::FETCH_ASSOC)){
                ?>
                <tr>
                    <td>
                        <?= $commande['id_commande'] ?> 
                    </th>
                    <td>
                        <?= $commande['id_commande'] ?> 
                    </th>
                    <td>
                        <?= $commande['id_commande'] ?> 
                    </th>
                    <td>
                        <?= $commande['id_commande'] ?> 
                    </th>
                    <td>
                        <?= $commande['id_commande'] ?> 
                    </th>
                </tr>
                <?php
            }
            ?>
            </table>
        <?php
        }

        $content = ob_get_clean();

    } //fin du else CONNECTE et ADMIN
    

   

    include('../inc/gabarit.php');

?>
