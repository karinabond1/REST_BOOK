(function ($) {

    var str = window.location.search;
    var strArray = str.split('=');
    /*$('input[type=text]#id_hidden').val(sessionStorage.getItem("id"));
    $('input[type=text]#car_id').val(strArray[1]);
    $('#btn_buy').click(function () {
        valid = true;
        var radioValue = $("input[name='payment']:checked").val();
        if (!radioValue) {
            alert("Please, choose the way of payment!");
            valid = false;
        }else if(sessionStorage.getItem("user")=='offline'){
            alert("Please, go on HOME page and be registered or log in!");
            valid = false;
        }
        if (valid) {
            $('#myForm').attr('action', 'thank.html');
            $('#btn_buy').attr('type', 'submit');
            var formData = $('#myForm').serialize();
            console.log(formData);

            request = $.ajax({
                url: "http://192.168.0.15/~user14/REST/server/api/shop/buy/",
                type: "post",
                data: formData
            });

            // Callback handler that will be called on success
            request.done(function (response, textStatus, jqXHR) {
                // Log a message to the console
                console.log("Hooray, it worked!");
                console.log(response);

                console.log(textStatus);
                console.log(jqXHR);
            });
            request.fail(function (jqXHR, textStatus, errorThrown) {
                // Log the error to the console
                console.error(
                    "The following error occurred: " +
                    textStatus, errorThrown
                );
            });

        }
    });*/
    

    ajaxJson('http://192.168.0.15/~user14/REST_BOOK/client/api/shop/book/' + strArray[1], function (data) {
        document.getElementById("book").innerHTML = data["book"];
        var html = "";
        if (Array.isArray(data)) {
            //for (var i=0; i < data.length; i++) {
            html += '<h2>'+data[0]["book"]+'</h2>'+
                '<img class="img-thumbnail " src="img/books/'+data[0]["img"]+'">'+
                '<h4 class="lefth">'+data[0]["about"]+'</h4>'+
                '<h3>Price: '+data[0]["price"]+' $</h3>';
            //}
        } else {
            html += "There is some problems. Please, try again later!";
        }
        document.getElementById("book").innerHTML = html;
    });


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