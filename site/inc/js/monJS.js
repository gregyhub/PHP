

//document ready
$(function(){

    $('#inscription > #pseudo').on('focusin', function(e){
       test = $('#pseudo').parent();
       console.log(test);
       test.remove('.alert');
    });
  
    $('#inscription #pseudo').on('focusout', function(e){
        //event sur la saisie dans l'input pseudo
        //je déclanche une requete ajax
        val = $(this).val();
        $.ajax({
            url: "inc/ajax.php",
            type: 'post',
            data: 'pseudo=' + val
          })    
          $.post(
            'inc/ajax.php', // Le fichier cible côté serveur.
            {
                pseudo : val // Nous supposons que ce formulaire existe dans le DOM.
            },
            AfficheError, // Nous renseignons uniquement le nom de la fonction de retour.
            'text' // Format des données reçues.
        );
        
        function AfficheError(libre){
            //si j'ai une erreur : libre = nondispso, j'affiche un message 
            if(libre == "nondispo") {
                msg = '<div class="alert alert-danger">Pseudo non dispo !</div>';
                $('#pseudo').parent().addClass('has-error');
            } else {
                msg ='<div class="alert alert-success">pseudo dispo !</div>';
                $('#pseudo').parent().addClass('has-success');
            }

            $('#pseudo').parent().append(msg);
            // Du code pour gérer le retour de l'appel AJAX.
        }
    });

});
