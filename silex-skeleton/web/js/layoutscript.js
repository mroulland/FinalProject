/* Dynamisation du menu profil en haut
 * Quand l'utilisateur clique sur le bouton, le menu se déroule et se renroule 
*/
  function myFunction() {
        document.getElementById('myDropdown').classList.toggle('show');
    }

    // Cloture le menu si l'utilisateur clique ailleurs que sur le bouton
    window.onclick = function(event) {
      if (!event.target.matches.getElementById('#dropdown')) {

        var dropdowns = document.getElementsByClassName('dropdown-content');
        var i;
        for (i = 0; i < dropdowns.length; i++) {
          var openDropdown = dropdowns[i];
          if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
          }
        }
      }
    };



    
    
    
 $(document).ready(function(){
     /* Gestion inscription */
    /*$('#dropdown').click(function(evt) {
           evt.preventDefault();
           $('#myDropdown').slideToggle(function(){

          });
       });*/
     
      
     /* Gestion burger menu admin*/
    $('#navAdmin').click(function(evt) {
           evt.preventDefault();
           $('#menuAdmin').slideToggle(function(){

          });
       });
    
    /* Gestion burger menu */
    $('#menu').click(function(evt) {
        evt.preventDefault();
        $('#mainNav').slideToggle('slow',function(){

       });
    });
 });// Fin chargement DOM 
    
  