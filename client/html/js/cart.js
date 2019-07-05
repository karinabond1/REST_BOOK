(function ($) {
    if(sessionStorage.getItem("user")==0 && sessionStorage.getItem("status")=='offline'){
        document.getElementById("inf").innerHTML = "You need to log in to see all your orders!";
    }else{
        ajaxJson('http://192.168.0.15/~user14/REST_BOOK/server/api/shop/cart/'+sessionStorage.getItem("user"), function (data) {
            document.getElementById("inf").innerHTML = data["inf"];
            var html = "";
            if (Array.isArray(data)) {
                console.log(data);
                var allPrice = 0;
                html += '<table class="table table-striped">'+
                    '<tr><th>Book</th><th>Price for 1</th><th>Amount</th><th>All price</th></tr>';
                for (var i = 0; i < data.length; i++) {
                    html += '<tr><td>'+data[i]['book']+'</td><td>'+data[i]['price']+'</td><td>'+data[i]['amount']+'</td><td>'+data[i]['price']*data[i]['amount']+'</td></tr>';
                    allPrice += parseInt(data[i]['price']);
                }
                html += '<tr><th>ALL</th><th></th><th></th><th>'+allPrice+'</th></tr>';
                html += '</table>';
            } else {
                html += "There is some problems. Please, change your data!";
            }
            document.getElementById("inf").innerHTML = html;
        });
    }


    function ajaxJson(url, callback) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                console.log('responseText:' + xmlhttp.responseText);
                try {
                    var data = JSON.parse(xmlhttp.responseText);
                } catch (err) {
                    console.log(err.message + " in " + xmlhttp.responseText);
                    return;
                }
                callback(data);
            }
        };

        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    }


}(jQuery))