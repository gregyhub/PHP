<?php 
    require_once('fonctions.php');
    $erreur='';
    if($_POST) {
        if( isset($_POST['fruit_choisi']) && is_numeric($_POST['poids'])) {
                 $affPrixKg =  calcul($_POST['fruit_choisi'], $_POST['poids']);
        }else {
            $erreur='il y a un pb';
        }
       
    }
?>

<h1>Formulaire Fruits</h1>
<form action="" method="post">
    <h3><?= $erreur ?? '' ?></h3>
    <select name="fruit_choisi" id="">
        <option value="cerises">cerises</option>
        <option value="bananes" <?= (isset($_POST['fruit_choisi']) && $_POST['fruit_choisi']== 'bananes') ? 'selected' : '' ?>>bananes</option>
        <option value="peches" <?= (isset($_POST['fruit_choisi']) && $_POST['fruit_choisi']== 'peches') ? 'selected' : '' ?>>peches</option>
        <option value="pommes" <?= (isset($_POST['fruit_choisi']) && $_POST['fruit_choisi']== 'pommes') ? 'selected' : '' ?>>pommes</option>
    </select>
    <br>
    <label for="poids">quantité en Kg</label>
    <input type="text" name="poids" id="poids" value="<?= $_POST['poids'] ?? '' ?>" />
    <input type="submit" value="envoie" name="envoie" />
    <h3><?= $affPrixKg ?? '' ?></h3>
</form>