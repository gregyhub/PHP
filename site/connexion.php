<?php
    require_once('inc/init.php');

    //cliquer sur le bouton déconnexion
    if(isset($_GET['action']) && $_GET['action']=='deconnexion') {
        session_destroy();
      
    }
    if(estConnecte()){
        header('location:profil.php');
        exit();
    }
    if($_POST){ // équivalent à !empty($_POST)
        $mdpCrypte = md5($_POST['mdp']);
        //requete pour vérifier si les identifiants/mdp corresponde dans la bdd
        $sql = 'SELECT * FROM membre where pseudo=:pseudo AND mdp=:mdp';
        $res = executeRequete($sql, array('pseudo' => $_POST['pseudo'], 'mdp' => $mdpCrypte));
        if($res->rowCount() != 0){
            //j'ai un résultat en base donc j'autentifie l'utilisateur
            $membre = $res->fetch(PDO::FETCH_ASSOC);
            $_SESSION['membre'] = $membre;
            header('location:profil.php');
        }
        else{
            $errorLog = '<div class=bg-danger>Erreur sur les identifiants</div>';
        }
    }

    ob_start();
	?>
	<form id="connexion" action="" method="post">
        <div class="form-group">
            <label for="pseudo">Pseudo</label>
            <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="saisissez votre pseudo" value="<?= $_POST['pseudo'] ?? '' ?>">
        </div>
        <div class="form-group">
            <label for="mdp">Password</label>
            <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Password">
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="sess">
            <label class="form-check-label" for="sess">Rester connecté</label>
        </div>
        <button type="submit" class="btn btn-primary">Connexion</button>
        <?=  $errorLog ?? '' ?>
    </form>
	<?php
	$content = ob_get_clean();

   

    include('inc/gabarit.php');

?>
