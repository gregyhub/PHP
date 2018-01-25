<?php

    if($_POST && !empty($_POST)) {
        echo '<pre>'; 
        var_dump($_POST);
        echo '</pre>'; 
        extract($_POST);
        $expediteur = 'from: ' . $mail;
        $destinataire = 'gregmalaud@hotmail.com';
        mail($destinataire, $objet, $msg, $expediteur);
    }

?>

<h2>Contact</h2>
<div class="col6">
    <form method="post" action="" class="row">
        <label for="mail">votre email</label>
        <input type="email" id="mail" name="mail" required />
        <label for="objet">Objet de votre message</label>
        <input type="text" id="objet" name="objet" required />
        <label for="msg">votre message</label>
        <textarea id="msg" name="msg" required ></textarea> 
        <input type="submit" name="envoyer" value="Envoyer" />
        <input type="reset" name="annuler" value="Annuler" />
    </form>
</div>

