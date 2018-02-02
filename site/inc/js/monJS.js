

//document ready
$(function(){


    /*===============================================================================
    ================== FONCTION AJAX POUR LE PSEUDO / Page Inscription.php============
    ==================================================================================*/
    $('#inscription #pseudo').on('focus', function(e){
       $('#pseudo').parent().find('.alert').remove();
       $('#pseudo').parent().removeClass('has-error');
    });
  
    $('#inscription #pseudo').on('focusout', function(e){
        //event sur la saisie dans l'input pseudo
        //je déclanche une requete ajax
        val = $(this).val();
        /* $.ajax({
            url: "inc/ajax.php",
            type: 'post',
            data: 'pseudo=' + val
          })    */ 
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

    /* ======================================================================================================
    ======  FONCTIONS pour la gestion des catégories dans le formulaire gestion_boutique  ====================
    ====================================================================================================== */
    $('#selectCateg').on("change", function(){
        if($(this).val()=='nouvelleCat'){
            $('.ajout-categ').show();
            $('.ajout-categ').val('');
        }else {
            $('.ajout-categ').hide();
            $('.ajout-categ').val($(this).val());
        }
    });

    
    /* ======================================================================================================
    ======  FONCTIONS POUR LA GESTION DES COMMANDES  ========================================================
    ====================================================================================================== */

    $(".detailCmd").on('click', function(e){
        //je récupère la valeur de l'attribut "data" du bouton sur la ligne commande. J'y ai inseré dynamiquement en php le numéro de l'id_commande qui fait référence à l'attribut "id"  du tableau détail commande.
        var idTab = $(this).attr('data');
        //je peux donc sélectionner en JQ ce tableau spécifique et l'afficher
       // $('#'+idTab).toggle();
        //puis je masque le bouton 'plus' pour afficher le bouton 'moins'
        $(this).find('span').toggle();
        $( '#'+idTab  ).toggle( 'blind', 500 );
        
    });


});
