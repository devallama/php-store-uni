function ajaxRequest_Get(path) {
    return new Promise(function(resolve, reject) {
        var xhr2 = new XMLHttpRequest();

        xhr2.addEventListener('load', function(e) {
            var response = JSON.parse(e.target.responseText);
            if(response.success) {
                resolve(response.results);
            } else {
                reject(response.message);
            }
        });

        xhr2.open('GET', path);
        xhr2.send();
    });
}

function ajaxRequest_Post(path, data = null) {
    return new Promise(function(resolve, reject) {
        var xhr2 = new XMLHttpRequest();

        xhr2.addEventListener('load', function(e) {
            var response = JSON.parse(e.target.responseText);
            if(response.success) {
                resolve(response.results);
            } else {
                reject(response.message);
            }
        });

        xhr2.open('POST', path, true);
        xhr2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr2.send(data);
    });
}
