<?php
    //index front
    require_once('./inc/init.php');


    //je fais une requete pour récupérer tous les films
    $sql = 'SELECT id_movie, title, director, year_of_prod FROM movies';
    $allMovies = executeRequete($sql);

    ob_start();
    ?>
        <table class="table">
            <tr>
                <th>Titre du film</th>
                <th>Réalisateur</th>
                <th>Année de production</th>
                <th></th>
            </tr>
    <?php
        if($allMovies->rowCount() == 0){
            //si aucun film dans la base
            ?>  
            <tr>
                <td colspan="4">Aucun film disponible</td>
            </tr>
        <?php
        }
        while($movie = $allMovies->fetch(PDO::FETCH_ASSOC)){
            ?>  
                <tr>
                    <td><?= $movie['title'] ?></td>
                    <td><?= $movie['director'] ?></td>
                    <td><?= $movie['year_of_prod'] ?></td>
                    <td><a href="film.php?id_film=<?= $movie['id_movie'] ?>">plus d'info</a></td>
                </tr>
            <?php

        }
    ?>
        </table>
    <?php


    $films = ob_get_clean();



    //affichage de mon 'content' du front
    ob_start();
    ?>
        <main>
            <ul class="nav nav-pills">
                <li class="active"><a  href="#">tous les films ici</a></li>
                <li><a class="active" href="admin/index.php">Ajouter un film</a></li>
            </ul>
            
            <?= $films ?>
        </main>

    <?php
    $content = ob_get_clean();

    require_once('./inc/gabarit.php');
?>
