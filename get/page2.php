<?php 
    //require_once('../functions.php');
    function aff($e){
        echo $e . '<br>';
    }
    
    function vdm($e){
        aff('<pre>' .var_dump($e).'<pre>' );
    }
?>
<?php
       
            aff('<pre>' .var_dump($_GET).'<pre>' );
        
        if($_GET && !empty($_GET['article'])) {
            aff($_GET['article']);
        }
       
    ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recoit le Get</title>
</head>
<body>
    <h1>Page2 - Affiche le Jeans du Get</h1>

    

</body>
</html>