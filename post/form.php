<?php 

    function aff($e){
        echo $e . '<br>';
    }
    
    function vdm($e){
        aff('<pre>' .var_dump($e).'<pre>' );
    }

    if($_POST && !empty($_POST['prenom'])){
       //implode
       $param = implode('#', $_POST);
       vdm($param);
       vdm($_POST);

       //explode
       $date = '19/01/2018';
       $date_tableau = explode('/', $date);

       //extract => extrai dans des variables portant comme nom le noms des indices du tableau
       vdm($_POST);
       extract($_POST);
       aff($prenom);
       aff($message);

    }


    $famille = array( 'a' => 'test1',
                    'b' => 'test2',
                    'c' => 'test3');
    var_dump($famille);
    extract($famille);
    aff($a);
    aff($b);
    aff($c);
?>


    <form action="" method="post" name="test">
        <p><label for="prenom">prenom</label>
        <input type="text" id="prenom" name="prenom" value="<?= $_POST['prenom'] ?? '' ; ?>"></p>
        <p><label for="message">Message</label>
        <textarea name="message" id="message" cols="30" rows="10"><?= $_POST['message'] ?? '' ; ?></textarea></p>
        <input type="submit" value="Valider">
    </form>
