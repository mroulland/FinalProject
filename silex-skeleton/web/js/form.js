Stripe.setPublishableKey('pk_test_EONcjbwaYwY6HwyzCP1D5xR6')

    var $form = $('#payment_form');
    $form.submit(function (e){ 
        e.preventDefault();
        
        $form.find('.button').attr('disabled', true);
    
        Stripe.card.createToken($form, function(status, response){

            if(response.error){
                $form.find('.message').remove();
                $form.prepend('<div class="ui negative message>' + response.error.message + ' </div>');
            } else {
                var token = response.id;
                $form.append($('<input type="hidden" name="stripeToken">').val(token));
                $form.get(0).submit();
            }
            
        });
    });