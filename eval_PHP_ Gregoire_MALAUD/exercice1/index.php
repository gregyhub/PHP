<?php
    //idéntité de l'utilisateur dans un tableau
    $identite=array(
        'prenom' => 'Grégoire',
        'nom' => 'MALAUD',
        'adresse' => '60 rue Haxo',
        'cp' => '75020',
        'ville' => 'PARIS',
        'email' => 'greg@hotmail.com',
        'tel' => '06.22.01.74.29',
        'date_naiss' => '1983-11-22',
    );

    ob_start();
    ?>
        <ul  class="list-group">
    <?php
    foreach($identite as $indice => $valeur){
        //si l'indice est la date de naissance, j'effectue une traitement spéciale pour l'afficher au format francais
        if($indice == 'date_naiss'){
            $valeur = new DateTime($valeur);
            $valeur = $valeur->format('d/m/Y');
        }
        ?>
            <li class="list-group-item"><?= $indice .' : '.$valeur  ?></li>
        <?php
    }

    ?>
        </ul>
    <?php
    $content = ob_get_clean();
?>




<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- css bootstrap CDN -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>On se Présente !</title>
</head>
<body>
    <div class="container">
        <h1 class="text-center">On se Présente !</h1>
        <h2>exercice 1</h2>
        <?= $content ?? '' ?>
    </div>

    <!-- JS Jquery et bootstrap CDN -->
    <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>