// Fonction d'attente de chargement du DOM

$(document).ready(function(){

    console.log("le dom est chargé");    
    
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

    // Afficher le select durée pour offrir

    $("#offrir").click(function(){
        $('.showselect').slideUp('slow');
        $('.hideselect').slideDown('slow');
    });
    
    $("#abonnement").click(function(){
        $('.hideselect').slideUp('slow');
        $('.showselect').slideDown('slow');
    });
    
    
    
    // Fonction pour afficher le prix 
    $('#formabonnement').change(function(){
        
        // Si la case abonnement est cochée
        if($('input[name=offre]:checked').val() === 'abonnement'){
            console.log('on est dans abonnement');

            // Si le mode de livraison est à domicile
            if($('input[name=mode]:checked').val() === '1'){
                console.log('on est dans domicile');

                if($('#selectproduit2').val() == 'moyen' && $('#frequency').val() == 'une fois par mois'){
                    $("#price").html("35€");

                }else if ($('#selectproduit2').val() == 'moyen' && $('#frequency').val() == 'deux fois par mois'){
                   $("#price").html("60€");

                } else if ($('#selectproduit2').val() == 'gros' && $('#frequency').val() == 'une fois par mois'){
                   $("#price").html("45€");

                } else if ($('#selectproduit2').val() == 'gros' && $('#frequency').val() == 'deux fois par mois'){
                   $("#price").html("75€");
                }

            }else if($('input[name=mode]:checked').val() === '2'){
                console.log('on est dans points fleurs')

                if($('#selectproduit2').val() == 'moyen' && $('#frequency').val() == 'une fois par mois'){
                    $("#price").html("30€");

                }else if ($('#selectproduit2').val() == 'moyen' && $('#frequency').val() == 'deux fois par mois'){
                   $("#price").html("55€");

                } else if ($('#selectproduit2').val() == 'gros' && $('#frequency').val() == 'une fois par mois'){
                   $("#price").html("40€");

                } else if ($('#selectproduit2').val() == 'gros' && $('#frequency').val() == 'deux fois par mois'){
                   $("#price").html("70€");
                }
            }

        // Ou si la case offrir est cochée
        } else if($('input[name=offre]:checked').val() === 'offrir'){
            
            // Si le mode de livraison est à domicile
            if($('input[name=mode]:checked').val() === '1'){
                console.log('on est dans domicile');
                
                // Premier produit 
                if($('#selectproduit2').val() == 'moyen' && $('#frequency').val() == 'une fois par mois'){
                    // Prix selon la durée achetée
                    if($('#selectproduit3').val() === '1'){
                        $("#price").html("35€");
                    } else if($('#selectproduit3').val() === '3'){
                        $("#price").html("105€");
                    } else{
                        $("#price").html("210€");
                    }
                 
                // Deuxième produit
                }else if ($('#selectproduit2').val() == 'moyen' && $('#frequency').val() == 'deux fois par mois'){
                   
                    if($('#selectproduit3').val() === '1'){
                        $("#price").html("60€");
                    } else if($('#selectproduit3').val() === '3'){
                        $("#price").html("180€");
                    } else{
                        $("#price").html("340€");
                    }

                } else if ($('#selectproduit2').val() == 'gros' && $('#frequency').val() == 'une fois par mois'){
                   
                    if($('#selectproduit3').val() === '1'){
                        $("#price").html("45€");
                    } else if($('#selectproduit3').val() === '3'){
                        $("#price").html("135€");
                    } else{
                        $("#price").html("270€");
                    }

                } else if ($('#selectproduit2').val() == 'gros' && $('#frequency').val() == 'deux fois par mois'){
                   
                    if($('#selectproduit3').val() === '1'){
                        $("#price").html("75€");
                    } else if($('#selectproduit3').val() === '3'){
                        $("#price").html("225€");
                    } else{
                        $("#price").html("450€");
                    }
                }

            }else if($('input[name=mode]:checked').val() === '2'){
            // Si le mode de livraison est points relais    

                // Premier produit 
                if($('#selectproduit2').val() == 'moyen' && $('#frequency').val() == 'une fois par mois'){
                    // Prix selon la durée achetée
                    if($('#selectproduit3').val() === '1'){
                        $("#price").html("30€");
                    } else if($('#selectproduit3').val() === '3'){
                        $("#price").html("90€");
                    } else{
                        $("#price").html("180€");
                    }
                 
                // Deuxième produit
                }else if ($('#selectproduit2').val() == 'moyen' && $('#frequency').val() == 'deux fois par mois'){
                   
                    if($('#selectproduit3').val() === '1'){
                        $("#price").html("55€");
                    } else if($('#selectproduit3').val() === '3'){
                        $("#price").html("165€");
                    } else{
                        $("#price").html("230€");
                    }
                    
                // Troisième produit
                } else if ($('#selectproduit2').val() == 'gros' && $('#frequency').val() == 'une fois par mois'){
                   
                    if($('#selectproduit3').val() === '1'){
                        $("#price").html("40€");
                    } else if($('#selectproduit3').val() === '3'){
                        $("#price").html("120€");
                    } else{
                        $("#price").html("240€");
                    }
                
                // Quatrième produit
                } else if ($('#selectproduit2').val() == 'gros' && $('#frequency').val() == 'deux fois par mois'){
                   
                    if($('#selectproduit3').val() === '1'){
                        $("#price").html("70€");
                    } else if($('#selectproduit3').val() === '3'){
                        $("#price").html("210€");
                    } else{
                        $("#price").html("420€");
                    }
                }
            }
            

        }
    });
        

});