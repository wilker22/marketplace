        
        
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

let submitButton = document.querySelector('button.processCheckout');

submitButton.addEventListener('click', function(event){

    event.preventDefault();
    document.querySelector('div.msg').innerHTML = '';

    let buttonTarget = event.target;
    buttonTarget.disabled = true;
    buttonTarget.innerHTML = "Carregando...";

    PagSeguroDirectPayment.createCardToken({
        cardNumber:         document.querySelector('input[name=card_number]').value,
        brand:              document.querySelector('input[name=card_brand]').value,
        cvv:                document.querySelector('input[name=card_cvv]').value,
        expirationMonth:    document.querySelector('input[name=card_month]').value,
        expirationYear:     document.querySelector('input[name=card_year]').value,
        
        success: function(res){
             processPayment(res.card.token, buttonTarget);
        },

        error: function(err){
            buttonTarget.disabled = false;
            buttonTarget.innerHTML = 'Efetuar Pagamento';
            for(let i in err.errors){
                document.querySelector('div.msg').innerHTML = showErrorMessages(errorsMapPagseguroJS(i));
            }
        }
    });
});

//Crio uma vari??vel getHash que vai conter o valor da fun????o
//que substitui a fun????o getSenderHash, sendo esta "onSenderHashReady". 
let getHash = PagSeguroDirectPayment.onSenderHashReady(function(response){
                if(response.status == 'error') {
                    console.log("caiu no erro do onSenderHashReady" + response.message);
                    return false;
                }
                var hash = response.senderHash; //Hash estar?? dispon??vel nesta vari??vel.
            });