        
        
let cardNumber = document.querySelector('input[name=card_number]');
let spanBrand = document.querySelector('span.brand');



cardNumber.addEventListener('keyup', function(){
    if(cardNumber.value.length >= 6){
        PagSeguroDirectPayment.getBrand({
            cardBin: cardNumber.value.substr(0,6),
           
            success: function(res){
                let imgFlag = `<img src="https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/${res.brand.name}.png">`
                spanBrand.innerHTML = imgFlag;
                document.querySelector('input[name=card_brand]').value = res.brand.name;
                getInstallments(amountTransaction, res.brand.name);
            },
            error: function(err){
                console.log(err);
            },
            complete: function(res){
               // console.log('Complete', res);
            }
        });
    }
});

let submitButton = document.querySelectorAll('button.processCheckout');

submitButton.forEach(function(el, k){
    el.addEventListener('click', function(event){

        event.preventDefault();

        let paymentType = event.target.dataset.paymentType;
        document.querySelector('div.msg').innerHTML = '';
    
        let buttonTarget = event.target;
        buttonTarget.disabled = true;
        buttonTarget.innerHTML = "Carregando...";
    
        if(paymentType === 'CREDITCARD'){
            PagSeguroDirectPayment.createCardToken({
                cardNumber:         document.querySelector('input[name=card_number]').value,
                brand:              document.querySelector('input[name=card_brand]').value,
                cvv:                document.querySelector('input[name=card_cvv]').value,
                expirationMonth:    document.querySelector('input[name=card_month]').value,
                expirationYear:     document.querySelector('input[name=card_year]').value,
                
                success: function(res){
                     processPayment(res.card.token, paymentType);
                },
        
                error: function(err){
                    buttonTarget.disabled = false;
                    buttonTarget.innerHTML = 'Efetuar Pagamento';
                    for(let i in err.errors){
                        document.querySelector('div.msg').innerHTML = showErrorMessages(errorsMapPagseguroJS(i));
                    }
                }
            });

            if(paymentType === 'BOLETO'){
                processPayment(null, paymentType);
            }
        }
    });
});


//Crio uma variável getHash que vai conter o valor da função
//que substitui a função getSenderHash, sendo esta "onSenderHashReady". 
let getHash = PagSeguroDirectPayment.onSenderHashReady(function(response){
                if(response.status == 'error') {
                    console.log("caiu no erro do onSenderHashReady" + response.message);
                    return false;
                }
                var hash = response.senderHash; //Hash estará disponível nesta variável.
            });