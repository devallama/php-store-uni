function buttonBasketRemove_Events() {
    var els = document.querySelectorAll('a[data-action="removefrombasket"]');
    for(var i = 0; i < els.length; i++) {
        var el = els[i];
        el.addEventListener('click', removeFromBasket);
    }
}

function removeFromBasket(e) {
    e.preventDefault();
    console.log("called5");
    var parentEl = e.target.parentElement.parentElement;
    var basketID = parentEl.dataset.basketId;

    var path = './php/remove_from_basket.php';
    var data = 'basketID=' + basketID;
    console.log(data);

    ajaxRequest_Post(path, data)
        .then(function(results) {
            showResponse(results);
            getBasket();
        })
        .catch(function(error) {
            showResponse(error, true);
            console.log(error);
        });
}

function showResponse(response, isError = false) {
    var responseEl = document.getElementById('action-response');
    responseEl.innerHTML = response;
    responseEl.className = '';
    
    if(isError) {
        responseEL.classList.add('error');
    } 
}