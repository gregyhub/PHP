<?php
    //index front
    require_once('./inc/init.php');


    //je fais une requete pour vérifier que l'id existe et si oui, récupérer toutes les infos du film
    $sql = 'SELECT * FROM movies WHERE id_movie=:id_movie';
    $leFilm = executeRequete($sql, array('id_movie' => $_GET['id_film']));

    ob_start();
    if($leFilm->rowCount()==0){
        ?>
        <div class="jumbotron">
            <p class="text text-danger"><a href="index.php">ce film n'existe pas. retournez sur la page d'accueil</a></p>
        </div>
        <?php
    }else{
        $leFilm = $leFilm->fetch(PDO::FETCH_ASSOC);
    ?>
        <div class="row">
            <div class="col-md-6">
                <h3><?= $leFilm['title'] ?></h3>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-group">
                            <li class="list-group-item">acteurs : <?= $leFilm['actors'] ?></li>
                            <li class="list-group-item">Réalisateur : <?= $leFilm['director'] ?></li>
                            <li class="list-group-item">Producteur : <?= $leFilm['producer'] ?></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                    
                    <ul class="list-group">
                            <li class="list-group-item">Année de production : <?= $leFilm['year_of_prod'] ?></li>
                            <li class="list-group-item">Langue : <?= $leFilm['language'] ?></li>
                            <li class="list-group-item"><a href="<?= $leFilm['video'] ?>" target="_BLANC">Bande annonce</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h3>Synopsis</h3>
                <?= $leFilm['storyline'] ?>
            </div>
        </div>
            
        <div class="jumbotron">
            <a href="index.php">retour à l'acceuil</a>
        </div>
    <?php
    }
           
    $detailDuFilm = ob_get_clean();



    //affichage de mon 'content' du front
    ob_start();
    ?>
        <main>
            <h3>Détail du film </h3>
            <?= $detailDuFilm ?>
        </main>

    <?php
    $content = ob_get_clean();

    require_once('./inc/gabarit.php');
?>
