
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        body{
            width:1000px;
            margin:auto;
        }
        .infoEmp{
            border:1px solid black;
            margin-top: 5px;
            background-color: grey;
        }
        th,td{
            border: 1px solid black;
        }
        tr:nth-child(even){
            background: grey;
        }
    </style>
    <title>PDO</title>
</head>
<body>

<?php

    
    echo '<h1>connexion</h1>';

    $pdo = new PDO('mysql:host=localhost; dbname=entreprise','root', '', 
                    array(
                        PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING,
                        PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8'
                    ));

     echo '<h1>INSERT / UPDATE / DELETE</h1>';
     /*
    $pdo->exec("INSERT INTO employes VALUES (NULL,'test','test','m','informatique','2018-01-22', 500)");
    $dernier_id = $pdo->lastInsertId();
    
    echo 'dernier id ajouté : ' . $dernier_id;
  
    $pdo->exec("UPDATE employes SET salaire=1000 WHERE id_employes=". $dernier_id); 
    $result =  $pdo->exec("DELETE FROM employes WHERE id_employes=992");
    echo $result; // le nombre de ligne affectée.
   */
    echo '<h1>SELECT </h1>';
    //une req avec 1 seul résultat.
    $sql = 'SELECT * FROM employes where prenom="Daniel"';
    $resul= $pdo->query($sql);
    echo '<pre>';
    var_dump($resul);
    var_dump(get_class_methods($resul));
    echo '</pre>';
    $emp_daniel = $resul->fetch(PDO::FETCH_ASSOC);echo '<pre>';
    var_dump($emp_daniel);
    echo '</pre>';

    echo "bonjour je suis ". $emp_daniel['prenom'] ." et je gagne ". $emp_daniel['salaire'] ." par mois !";

    /*
    $pdo est un objet(1) issu de la classe prédéfinie PDO
    Quand on execute une requete de la selection via la méthode query() sur l'objet PDO, on obtient un autre objet(2) issu de la classe PDOStatement qui a ses propres propriété et méthodes.

    Si on execute une requete de type insert/update/delete avec query() au lieu de exec(), on obtient un booléen.
    */

    echo '<hr>';

    //select avec plusieurs réponses
    $resul = $pdo->query('SELECT * FROM employes WHERE service="commercial"');

    echo 'nombre de commerciaux : '.$resul->rowCount().'<br>';

    while( $contenu = $resul->fetch(PDO::FETCH_ASSOC)) {
        echo $contenu['prenom']. ' ' . $contenu['nom'] . ' ('. $contenu['sexe'].').<br>';
    }    

    echo '<hr>';

    //select tableau multidimensionnel
    $resul = $pdo->query('SELECT * FROM employes WHERE service ="commercial"');

    $donnees = $resul->fetchAll(PDO::FETCH_ASSOC);
    echo '<pre>';
    var_dump($donnees);
    echo '</pre>';


    foreach($donnees as $row => $employe) {
        echo '<div style="text-align:center;width: 300px;border:1px solid black;margin-top: 5px;background-color: grey; padding: 5px;">';
        foreach($employe as $champ => $info) {
            echo "$champ : $info <br>";
        }
        echo '</div>';
    }

    echo '<hr>';
    //exercice : afficher la liste des base de données dans une liste HTML

    $resul = $pdo->query('SHOW DATABASES');
    $AllBdd = $resul->fetchAll(PDO::FETCH_ASSOC);
    echo '<ul>';
    foreach($AllBdd as $row => $OneBdd) {
       
        foreach($OneBdd as $databasename) {
            echo '<li style="width: 300px;border:1px solid black;margin-top: 5px;background-color: pink; padding: 5px;">'. $databasename .'';
            $sql = $pdo->exec('use '. $databasename); // je selectionne la base en cours
            $sql = $pdo->query('SHOW TABLES'); // je récupere les tables de la base en cours
            $AllTables = $sql->fetchAll(PDO::FETCH_ASSOC);
            echo '<ul>';
            foreach($AllTables as $table) {
                foreach($table as $name) {
                echo '<li>'.$name.'</li>';
                }
            }
            echo '</ul></li>';
        }
       
    }
    echo '</ul>';


    echo '<hr>';
    /*=============================
    =====Le parcorus de Table======
    ==============================*/
    $pdo->exec('USE BIBLIOTHEQUE');
    $nomTable="livre";
    $resul = $pdo->query("SELECT * FROM ".$nomTable);

    echo '<table><tr>';
    $bncolonnes = $resul->columnCount();
    for($i=0; $i<$bncolonnes; $i++){
        $infoscolonne = $resul->getColumnMeta($i);
        //donne dans un tableau les infos pour une colonne pour chaque index de  0 à N.
        //ce tableau, à l'index 'name' donne le nom du champs.
        echo '<th>'.$infoscolonne['name'].'</th>';
    }
    echo '</tr>';

    //parcours des enregistrements
    while($ligne = $resul->fetch(PDO::FETCH_ASSOC)){
        echo '<tr>';
        foreach($ligne as $information){
            echo '<td>'.$information.'</td>';
        }
        echo '</tr>';
    }

    echo '</table>';


    echo "<hr>";
    echo "<h2>Prepare / bindParam /bindValue / execute</h2>";

    $pdo->exec('USE entreprise');
    $nom = 'sennard';

    $resul = $pdo->prepare("SELECT * FROM employes where nom =:nom");
    $resul->bindParam('nom', $nom, PDO::PARAM_STR); //bindParam recoit exclusivement une variable || bindValue Idem mais on peut envoyer une chaine de caractere à la place de la variable
    $resul->execute();
    $donnees = $resul->fetch(PDO::FETCH_ASSOC);
    echo implode(' ', $donnees);
    echo '<br>';
    $nom = 'thoyer';
    $resul = $pdo->prepare("SELECT * FROM employes where nom =:nom");
    $resul->bindValue('nom', 'thoyer', PDO::PARAM_STR); //bindParam recoit exclusivement une variable || bindValue Idem mais on peut envoyer une chaine de caractere à la place de la variable
    $resul->execute();
    $donnees = $resul->fetch(PDO::FETCH_ASSOC);
    echo implode(' ', $donnees);

?>

    
</body>
</html>
