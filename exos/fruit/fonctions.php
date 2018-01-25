<?php
    function calcul($fruit, $poids) {
        $prixkg;
        switch ($fruit) {
            case 'cerises':
                $prixkg = $poids * 5.76;
                break;
            case 'bananes':
                 $prixkg = $poids * 1.09;
                break;
            case 'peches':
                $prixkg = $poids * 3.23;
                break;
            case 'pommes':
                $prixkg = $poids * 1.61;
               
                break;
        } 
        return "les $fruit coutent $prixkg € pour $poids Kg.";
    }

    
?>