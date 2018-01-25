<?php 
    
    function aff($e){
        echo $e . '<br>';
    }
    
    function vdm($e){
        aff('<pre>' .var_dump($e).'<pre><br>test' );
    }

?>