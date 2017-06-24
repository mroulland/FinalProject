// Fonction d'attente de chargement du DOM

$(document).ready(function(){

    //  $('select').niceSelect();



    function swapImage() {
        var image = document.getElementById("photoproduit");
        var frequency = document.getElementById("frequency").value;
        var size = document.getElementById("size").value;
        var imagename = size + '_' + frequency + '.png';

        image.src = "img/" + imagename;
    }


});
