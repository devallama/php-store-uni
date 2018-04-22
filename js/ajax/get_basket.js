getBasket();

function getBasket() {
    var path = './php/get_basket.php';

    ajaxRequest_Post(path)
        .then(function(results) {
            showBasketResults(results);
        })
        .catch(function(error) {
            console.log(error);
            showBasketError(error);
        });
}

function showBasketResults(results) {
    var resultsEl = document.getElementById('basket__results');
    resultsEl.innerHTML = '';
    for(var i = 0; i < results.length; i++) {
        var result = results[i];
        var resultEl = document.createElement('div');
        resultEl.dataset.basketId = result.ID;
        resultEl.innerHTML = '<div class="name">' + result.name + '</div>' +
                            '<div class="manufacturer">' + result.manufacturer + '</div>' +
                            '<div class="description">' + result.description + '</div>' +
                            '<div class="qty">' + result.qty + '</div>' +
                            '<div class="price">£' + (result.price * result.qty)  + '</div>' +
                            '<div class="delete"><a href="#" data-action="removefrombasket" class="button button--remove">Remove From Basket</a></div>';
        resultsEl.appendChild(resultEl);

        buttonBasketRemove_Events();
    }
}

function showBasketError(error) {
    var resultsEl = document.getElementById('basket__results');
    resultsEl.innerHTML = error;
}