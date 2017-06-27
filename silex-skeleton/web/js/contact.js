$(document).ready(function(){ 

    // Afficher ou non l'input 'nom de la société' au click sur le select
    $('#choice').on('change',function(){ 
        if($(this).val()=== "entreprise"){
        $("#societyName").fadeIn();
        $("#society").fadeIn();
        }
        else{
        $("#societyName").hide();
        $("#society").hide();
        }
    });
    
   // Media queries 
   $(window).resize(function() {

        // Si la taille de l'écran dépasse 750px
        if( $(window).width()> 750){
            // Afficher/cacher les textes, labels et placeholders
            $('#profiles span').show();
            $('label').show();
            $('input, textarea').removeAttr('placeholder');
        }else{

            $('#profiles span').hide();
            $('label').hide();

        }

    });

    // Ouvrir/fermer la map
     $('.fa').click(function() {

        $('#place iframe').slideToggle('slow', function(){

       });
    });

});  
