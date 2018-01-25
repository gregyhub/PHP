<?php
    require_once('inc/init.php');

    $content = '';
    $contenu_gauche = 'testgauche';
    $contenu_droit = 'testdroit';


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
        </div>
    </div>
    <?php
	$content = ob_get_clean();


    include('inc/gabarit.php');

?>