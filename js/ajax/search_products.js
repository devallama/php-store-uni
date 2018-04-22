document.getElementById('search_form').addEventListener('submit', searchProduct);

getProducts();

// TODO: Remove console.logs from all pages

function getProducts() {
    var path = './php/get_products.php';

    ajaxRequest_Get(path)
        .then(function(results) {
            showSearchResults(results);
        })
        .catch(function(error) {
            console.log(error);
        });
}

function searchProduct(e) {
    e.preventDefault();
    var searchterm = e.target.querySelector('input[name="searchterm"]').value;
    console.log(searchterm);
    var path = './php/search_products.php?searchterm=' + searchterm;

    ajaxRequest_Get(path)
        .then(function(results) {
            showSearchResults(results);
        })
        .catch(function(error) {
            console.log(error);
        });
}

function showSearchResults(results) {
    console.log("called");
    var resultsEl = document.getElementById('search_results');
    if(results.length == 0) {
        resultsEl.innerHTML = '<h2>No results.</h2>';
    } else {
        resultsEl.innerHTML = '';
        for(var i = 0; i < results.length; i++) {
            var result = results[i];
            var resultEl = document.createElement('div');
            resultEl.dataset.productId = result.ID;
            resultEl.innerHTML = '<div class="productname">' + result.name + '</div>' +
                                '<div class="description">' + result.description + '</div>' +
                                '<div class="manufacturer">' + result.manufacturer + '</div>' +
                                '<div class="price">£' + result.price + '</div>' +
                                '<div class="stocklevel">' + result.stocklevel + '</div>' +
                                '<div class="agelimit">' + result.agelimit + '</div>' +
                                '<div class="rating">' + getRating(result.rating) + '</div>' +
                                '<div class="rating">' + getRatingScale() + '</div>' +
                                '<div class="qty"><input type="number" name="quantity" value="1" min="1"/></div>' +
                                '<div class="cart"><a href="#" data-action="addtobasket" class="button button--buy">Add to basket</a></div>';
            resultsEl.appendChild(resultEl);
        }
    }
    buttonBasketAdd_Events();
}