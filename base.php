<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style> 
        td {
            border:1px solid black;
        }
    </style>
    <title>PHP!!!!!</title>
</head>
<body>
    

<?php
    //phpinfo();
    echo 'bonjour';
    echo 'test';

    function aff($e){
        echo $e . '<br>';
    }
    
    function vdm($e){
        aff('<pre>' .var_dump($e).'<pre>' );
    }
?>

<?= 'hello'; 
    print '<br>test';
?>

<?php
    echo '<hr>';
    $a = 127;
    echo 'la variable a est de type ', gettype($a), ' qui vaut ', $a ,'<br>';
    echo 'la variable a est de type ' . gettype($a) . ' qui vaut ' . $a . '<br>';
?>

<?php
    $greg='greg';
    aff('bonjour ' . $greg);
?>
<?php
    echo '<h2>CONSTANTE et CONSTANTE MAGIQUE</h2>';
    define('CAPITAL','Paris'); // il n'est plus possible de la modifier ni de la redéfinir
    //la constante est sensible à la casse, à moins de définir un 3eme paramètre à 'true'
    aff(CAPITAL);
    aff(__FILE__);
    aff(__LINE__);
?>
<?php
    echo '<h2>conditions</h2>';
    $var1=0;
    $var2='';

    if(empty($var1)) aff('empty() => 0');
    $var1='';
    if(empty($var1)) aff('empty() => vide');
    $var1;
    if(empty($var1)) aff('empty() => non définie');
    $var1=' ';
    if(empty($var1)) aff('empty() => TEST');
    if(isset($var2)) aff('var 2 existe et est définir par rien');
    $a=10;
    $b=9;

    if( $a > $b ) {
        //
    }
    else {
        //
    }
    //équivament
    if( $a > $b ) :
        //
    else :
        //
    endif;


    //forme contractée du IF
    $a;
    aff( ( $a==10 ) ? 'a est égale à 10' : 'a n\'est pas égale à 10');
    //apres les ':' c'est le else
    $var1 = isset($maVar) ? $maVar : 'val par défaut ';
    aff($var1);

    // Ternaire courte PHP7
    $var2 = $maVar ?? 'valeur par defaut'; // ne fonction que pour le 'isset'
    aff($var2);

    $var3 = $maVar1 ?? $maVar2 ?? 'val par defaut';
    aff($var3);

    // Switch Case
    aff('<hr>');
    $page='presentation';
    switch($page) {
        case 'accueil' : aff('accueil');
        break;
        case 'contact' : aff('contact');
        break;
        case 'presentation' : aff('presentation');
        break;
        default : aff('defaut');
    }

    
    aff('<hr><h2>fonctions prédéfinies<h2>');
    aff(date('d/m/Y'));

    //traitement chaines de caractères 
    $email = 'g@g.com';
    aff(strpos($email, '@')); // le @ se trouve en 7eme position (en partant de 0)
    //strpos renvoie false si le caractère n'est pas trouvé
    aff(strlen($email)); // nb de caractère

    vdm($email);
    $pays='FRANCE';
    //global $pays; reste global mais hors de la fonction
    function globa() {
        global $pays;
        aff( $pays);
        aff( CAPITAL);
    }
    globa();

    function facultatif() {
        vdm( func_get_args() );
        vdm(func_get_arg(1)); // renvoie l'argument en fonctio nde son index
        foreach( func_get_args() as $indice => $element) {
            aff($indice . ' -> ' . $element );
        }
    }
    
    facultatif(1,2,3);

    // boucles 
    aff('<hr>');
    $i=0;
    while($i <3 ) {
        aff($i);
        $i++;
    }
    $i=0;
    while($i <=10 ) {
        aff($i);
        $i+=2;
    }

    for($i=0; $i<3; $i++) {
        aff($i);
    }

    echo '<hr><select>';
    for ($i = date('Y') ; $i > 1949; $i--) {
        echo '<option value="'.$i.'">'.$i.'</option>';
    }
    echo '</select>';

    // version de fred
?>
    <select>
<?php for( $a=date('Y') ; $a > 1949; $a--) : ?>
    <option value="<?= $a ?>"><?= $a ?></option>
<?php endfor; ?>
    </select>

<?php 
//boucles imbriquées
    //générer un tableau 15 colonne / 20 lignes
    // + un compteur de case
?>
<table>

<?php $case=1; for($l=0; $l<20; $l++) : ?>
    <tr>
    <?php for($c=0; $c<15; $c++) : ?>
        <td><?= $case ?></td>
    <?php $case++; endfor; ?>
    </tr>
<?php endfor; ?>
</table>

<?php
//inclusion
include_once('exemple.php');
include('exemple.php');
include_once('exemple.php');

/* foreach ($variable as $key => $value) {
    # code...
}
 */

$superheros= array(
    'SuperMan' => array('Nom' =>'Kent','Prenom' => 'Clark', 'Univers' => 'DC Comics'),
    'SpiderMan' => array('Nom' =>'Parker','Prenom' => 'Peter', 'Univers' => 'Marvel'),
    'BatMan' => array('Nom' =>'Wayne','Prenom' => 'Bruce', 'Univers' => 'DC Comics'),
    'IronMan' => array('Nom' =>'Stark','Prenom' => 'Tony', 'Univers' => 'Marvel')
);

vdm($superheros);
aff(count($superheros).' enregistrements dans le tableau');
aff(sizeof($superheros).' enregistrements dans le tableau');
aff($superheros['BatMan']['Prenom']);

$fruit=array('pomme','cerise','orange');
for($i=0; $i<count($fruit);$i++){
    aff('super héros : '.$fruit[$i]);
}


//les Clases
class Etudiant
{
    public $prenom  ="Julien";
    public $age     =25;
    public function pays(){
        return 'France';
    }

}

$objet = new Etudiant;
vdm($objet);
vdm(get_class_methods($objet));
aff($objet->pays());
aff($objet->prenom);
$objet->$prenom = "greg";
$objet2=new Etudiant;
?>



</body>
</html>
