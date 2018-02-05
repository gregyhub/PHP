<?php
    
    /**
     * Fonction qui permet de convertir un montant dans la devise Euros ou USD.
     * @param type int/float $montant que l'utilisateur souhaite convertir
     * @param type string $devise dans laquelle l'utilisateur souhaite faire la convertion / attendu 'EUR' ou 'USD
     * @return type int/float du montant converti dans la devise demandée  / false si erreur de traitement
     */
    function convertir($montant, $devise){
        switch ($devise){
            case 'EUR':
                //la devise saisie est Euro
                //1 USD = 0.802 EUR
                $ratio = 0.802;
                break;
            case 'USD':
                //la devise saisie est Dollar
                //1 EUR = 1.24 USD
                $ratio = 1.247;
                break;
            default:
                 //la devise saisi ne correspond pas
                return false;
                break;
        }
            return(round($montant * $ratio, 2));
    } //fin de fonction
    

    if($_POST){
        //si la valeur envoyé est numérique
        if(is_numeric($_POST['montant'])){
            //je transforme en float la valeur
            $_POST['montant'] = floatval($_POST['montant']);

            //j'appelle ma fonction
            $montantConverti = convertir($_POST['montant'], $_POST['devise']);
            ob_start();
            if($montantConverti === false){
                //j'ai une erreur avec la devise
                ?>
                    <p class="text text-success">la devise demandé n'existe pas dans notre base.</p>
                <?php
            }else{
                ?>
                    <p class="text text-success"><?= $montantConverti.' '.$_POST['devise'] ?></p>
                <?php
            }
            $ressultat = ob_get_clean();
        }else{
            //j'affiche un message d'erreur
            ob_start();
            ?>
                <p class="text text-danger">vous devez saisir un nombre</p>
            <?php
            $erreurMontant = ob_get_clean();
        }
    }

   
 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- css bootstrap CDN -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <title>On part en voyage !</title>
</head>
<body>
    <div class="container">
        <h1 class="text-center">On part en voyage !</h1>
        <h2>exercice 2</h2>

        <!-- Formulaire pour saisir le montant et la devise -->
        <div class="row">
            <div class="col-md-6">
                <form method="post" action="">
                    <div class="form-group  <?= $erreurMontant ? 'has-error' : '' ?>">
                        <label for="monant">Montant à convertir</label>
                        <input type="number" step="any" class="form-control" name="montant" id="monant" value="<?= $_POST['montant'] ?? '' ?>">
                        <?= $erreurMontant ?? '' ?>
                    </div>

                    <select for="devise" name="devise" class="form-control">
                        <option name="devise" value="USD" <?= isset($_POST['devise']) && $_POST['devise']=='USD' ? 'selected' : '' ?> >EUR > USD</option>
                        <option name="devise" value="EUR" <?= isset($_POST['devise']) && $_POST['devise']=='EUR' ? 'selected' : '' ?>>USD > EUR</option>
                    </select>
                
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div>
            <div class="col-md-6">
            <!-- zone d'affichage du résulstat -->
                <div class="jumbotron">
                     <?= $ressultat ?? '' ?>
                </div>
            </div>
            
            
        </div>
    </div>

    <!-- JS Jquery et bootstrap CDN -->
    <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>