function buttonBasketAdd_Events() {
    var els = document.querySelectorAll('a[data-action="addtobasket"]');
    for(var i = 0; i < els.length; i++) {
        var el = els[i];
        el.addEventListener('click', addToBasket);
    }
}

function addToBasket(e) {
    e.preventDefault();
    console.log("called5");
    var parentEl = e.target.parentElement.parentElement;
    var productID = parentEl.dataset.productId;
    var quantity = parentEl.querySelector('input[name="quantity"]').value;

    var path = './php/add_to_basket.php';
    var data = 'productID=' + productID + '&quantity=' + quantity;
    console.log(data);

    ajaxRequest_Post(path, data)
        .then(function(results) {
            showResponse(results);
            console.log(parentEl);
            parentEl.querySelector('div[class="stocklevel"]').innerHTML -= quantity;
            getBasket();
        })
        .catch(function(error) {
            showResponse(error, true);
        });
}

function showResponse(response, isError = false) {
    var responseEl = document.getElementById('action-response');
    responseEl.innerHTML = response;
    responseEl.className = '';

    if(isError) {
        responseEl.classList.add('error');
    }
}