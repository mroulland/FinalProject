$(document).ready(function(){ 

    // Ouvrir la modal
    $('.pop').click(function(){
       var id = $(this).data('id');
       console.log(id);
       $('#modal').fadeIn();

    });

    // Fermer la modal
    $('#closeModal').click(function(){
       $('aside').fadeOut();

    });

});  