<?php 


// Synthèse
// variables affectation
$variable1 = 5;
$variable2= "chaine";

// constante
define('CONSTANTE','42');

// tableau
$tab = array();
$tab[] =1;
$tab[] =2;
echo $tab[0]; // 1
echo $tab[1]; // 2
$tab['toto'] = 'titi';
echo $tab['toto']; // titi

// boucles
// while
$i=0; // init
while ( $i < 10) {  // condition d'arret
    echo $i;
    $i++; //incrémentation
}
// for
for ($i=0; $i<10 ; $i++){ // ( //init; //condition d'arret ; //incrémentation )
    echo $i;
}
// foreach (spécial tableaux et objets)
foreach ( $tab as $index => $value )
{
    //je parcoure le tableau, j'ai le nom de l'indice et sa valeur
}

// Fonctions
// permet de répeter une serie d'instructions en appelant une fonction
function mise_au_carre($nombre){
    return $nombre*$nombre;
}

echo mise_au_carre(4); // 16

function addition($a,$b=10)
{
    return $a+$b;
}
echo addition(2,3); // 5
echo addition(7); // 17

// objets
// ex : PDO
// Autre exemple DateTime
$madate = new DateTime;
echo $madate->format('Y-m-d H:i:s') . '<br>';

$madate2 = new DateTime('2018-01-31 15:32:23');
echo $madate2->format('Y-m-d H:i:s'). '<br>';
//équivalement à 
$madate3 = new DateTime;
$madate3->setTimestamp(mktime(15,42,23,1,31,2018));
echo $madate3->format('Y-m-d H:i:s'). '<br>';
?>