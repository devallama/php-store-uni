function getRating(rating) {
    var el = "";
    for(var i = 1; i <= 5; i++) {
        var classes = 'star'
        if(rating >= i) {
            classes += ' checked';
        }
        el += '<span class="' + classes + '"></span>';
    }
    return el;
    console.log(el);
}

function getRatingScale() {
    
}