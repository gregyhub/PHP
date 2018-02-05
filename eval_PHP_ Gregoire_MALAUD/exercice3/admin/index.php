<?php
    //index back
    require_once('../inc/init.php');

    //pour répondre au sujet, je prépare un tableau de langue qui sera affiché dans un menu déroulant du formulaire
    $langue=array('Francais', 'Anglais', 'Espagnole', 'Japonais', 'Allemand');

    //pour répondre au sujet, je prépare un tableau de catégories identique aux catégorie énuméré dans MySQL qui sera affiché dans un menu déroulant du formulaire
    $categories=array('thriller', 'romance', 'war');
    //je prépare le formulaire d'ajour d'un film
   

    /** TRAITEMENT POST */
    if($_POST){
        $testForm = champVide($_POST);
        if($testForm['champsvides']['nbError'] > 0){
            //j'ai au moins une erreur sur le formulaire
            $errorMovie=$testForm['champsvides'];
        }else{
            //si pas d'erreur de champs vide
            $sql = 'INSERT INTO movies VALUES(NULL, :title, :actors, :director, :producer, :year_of_prod, :language, :category, :storyline, :video)';
            executeRequete($sql, $testForm['champsvalides']);
            ob_start();
            ?>
                <div class="jumbotron">
                    <p class="text text-success">Félicitation, vous venez d'ajouter "<?= $_POST['title'] ?>" à votre vidéotheque </p>
                </div>
            <?php
            $ajoutSuccess = ob_get_clean();
            unset($_POST);
        }
    }




    ob_start();
?>
    <?= $ajoutSuccess ?? '' ?>
    <form method="post" action="">
        <!-- Titre -->
        <div class="form-group  <?= $errorMovie['title'] ? 'has-error' : '' ?>">
            <label for="title">Titre</label>
            <input type="text" class="form-control" name="title" id="title" value="<?= $_POST['title'] ?? '' ?>">
            <?= $errorMovie['title'] ?? '' ?>
        </div>

        <!-- Acteur -->
        <div class="form-group  <?= $errorMovie['actors'] ? 'has-error' : '' ?>">
            <label for="actors">Acteur</label>
            <input type="text" class="form-control" name="actors" id="actors" value="<?= $_POST['actors'] ?? '' ?>">
            <?= $errorMovie['actors'] ?? '' ?>
        </div>

        <!-- Réalisateur -->
        <div class="form-group  <?= $errorMovie['director'] ? 'has-error' : '' ?>">
            <label for="director">Réalisateur</label>
            <input type="text" class="form-control" name="director" id="director" value="<?= $_POST['director'] ?? '' ?>">
            <?= $errorMovie['director'] ?? '' ?>
        </div>

        <!-- Producteur -->
        <div class="form-group  <?= $errorMovie['producer'] ? 'has-error' : '' ?>">
            <label for="producer">Producteur</label>
            <input type="text" class="form-control" name="producer" id="producer" value="<?= $_POST['producer'] ?? '' ?>">
            <?= $errorMovie['producer'] ?? '' ?>
        </div>

        <!-- Année de prod -->
        <label for="year_of_prod">Année de production</label>
        <select id="year_of_prod" name="year_of_prod" class="form-control">
        <?php
            //Je fais une boucle pour gérer les années depuis 1930 jusqu'à l'année en cours
            for($i=1930; $i<= date('Y'); $i++){ 
        ?>
          <option value="<?= $i ?>" <?= isset($_POST['year_of_prod']) && $_POST['year_of_prod']==$i ? 'selected' : '' ?> ><?= $i ?></option>
        <?php
            }
        ?>
        </select>

        <!-- Langue -->
        <label for="language">Langue</label>
        <select id="language" name="language" class="form-control">
        <?php
            //Je fais une boucle pour gérer les années depuis 1930 jusqu'à l'année en cours
            foreach($langue as $lang){ 
        ?>
          <option value="<?= $lang ?>" <?= isset($_POST['language']) && $_POST['language']==$lang ? 'selected' : '' ?> ><?= $lang ?></option>
        <?php
            }
        ?>
        </select>

        <!-- Catégorie -->
        <label for="category">Catégories</label>
        <select id="category" name="category" class="form-control">
        <?php
            //Je fais une boucle pour gérer les années depuis 1930 jusqu'à l'année en cours
            foreach($categories as $cat){ 
        ?>
          <option value="<?= $cat ?>" <?= isset($_POST['category']) && $_POST['category']==$cat ? 'selected' : '' ?> ><?= $cat ?></option>
        <?php
            }
        ?>
        </select>
        
        <!-- Synopsis -->
        <div class="form-group  <?= $errorMovie['storyline'] ? 'has-error' : '' ?>">
            <label for="storyline">Synopsis</label>
            <textarea id="storyline" name="storyline"  class="form-control"><?= $_POST['storyline'] ?? '' ?></textarea>
            <?= $errorMovie['storyline'] ?? '' ?>
        </div>
        
        <!-- Vidéo -->
        <div class="form-group  <?= $errorMovie['video'] ? 'has-error' : '' ?>">
            <label for="video">Bande Annonce</label>
            <input type="text" class="form-control" name="video" id="video" value="<?= $_POST['video'] ?? '' ?>">
            <?= $errorMovie['video'] ?? '' ?>
        </div>
        
        
        
    
        <button type="submit" class="btn btn-default">envoyez</button>
    </form>

<?php
    $AjoutFilm = ob_get_clean();
    

    //affichage de mon 'content' admin
    ob_start();
    ?>
        <main>
        <ul class="nav nav-pills">
                <li><a href="../index.php">tous les films ici</a></li>
                <li class="active"><a href="#">Ajouter un film</a></li>
            </ul>
            <?= $AjoutFilm ?>
        </main>

    <?php
    $content = ob_get_clean();

    require_once('../inc/gabarit.php');
?>
