// Fonction d'attente de chargement du DOM

$(document).ready(function(){

    $('#radiomode2').click(function() {
    $('#mappointrelais').slideDown('slow', function() {
        // Animation complete.
    });
});

    $('#radiomode1').click(function() {
    $('#mappointrelais').slideUp('slow', function(){

    });
});


   $("#selectproduit2").change(function(){
     $("img[name=image-swap]").attr("src",$(this).val());

   });

});