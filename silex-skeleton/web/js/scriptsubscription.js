// Fonction d'attente de chargement du DOM

$(document).ready(function(){
    
    
    
    $('#selectproduit2').change(function(){
         
                // Modifier l'image au choix de l'utilisateur
                if($(this).val() === 'moyen'){
                    $('#photoproduit').attr('src', '../img/product1.jpg');

                }else{
                    $('#photoproduit').attr('src', '../img/product3.jpg');

                };
        });
    
  

        $('#radiomode2').click(function() {
        $('#mappointrelais').slideDown('slow', function() {
            // Animation complete.
        });
    });

        $('#radiomode1').click(function() {
       $('#mappointrelais').slideUp('slow', function(){

        });
    });


});