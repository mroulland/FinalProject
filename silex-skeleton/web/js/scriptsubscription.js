// Fonction d'attente de chargement du DOM

$(document).ready(function(){
    
    
    
    $('#selectproduit2').change(function(){
         
                // Modifier l'image au choix de l'utilisateur
                if($(this).val() === 'moyen'){
                    $('img').attr('src', 'img/produit1.jpg');

                }else{
                    $('img').attr('src', 'img/produit2.jpg');

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


   //$("#selectproduit2").change(function(){
     //$("img[name=image-swap]").attr("src",$(this).val());

   //});

});