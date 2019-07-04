(function ($) {
    /*sessionStorage.setItem('user', 'offline');
    var url = window.location.href;

    $('#btn_reg').click(function () {
        valid = true;
        if ($('#name').val() == "" || $('#surname').val() == "" || $('#email').val() == "" || $('#password').val() == "" ) {

            alert("Please, fill all the fields.");
            valid = false;
        }else if($('#name').val().includes(" ") || $('#surname').val().includes(" ") || $('#email').val().includes(" ") || $('#password').val().includes(" ")){
            alert("Please, fill all the fields without spaces.");
            valid = false;
        }
        if (valid) {
            $('#btn_reg').attr('type', 'submit');
            var formData = $('#reg_form').serialize();
            console.log(formData);

            request = $.ajax({
                url: "http://192.168.0.15/~user14/REST/server/api/user/userInfo/",
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

    });

    $('#btn_log').click(function () {
        valid = true;
        if ($('#email_log').val() == "" || $('#password_log').val() == ""  || $('#email_log').val().includes(" ") || $('#password_log').val().includes(" ")) {

            alert("Please, fill all the fields.");
            valid = false;
        }
        if (valid) {
            var formData = $('#log_form').serialize();
            console.log(formData);
            ajaxJson('http://192.168.0.15/~user14/REST/client/api/user/userLog/' + $('#email_log').val() + '/' + $('#password_log').val(), function (data) {
                document.getElementById("hello").innerHTML = data["hello"];
                var html = "";
                if (Array.isArray(data)) {
                    sessionStorage.setItem("user", "online");

                    for (var i = 0; i < data.length; i++) {
                        sessionStorage.setItem("id", data[i]["id"]);
                        html += "<h2>Hello, "+data[i]["name"]+" "+data[i]["surname"]+"!</h2>";
                    }
                } else {
                    html += "There is some problems. Please, change your data!";
                }
                document.getElementById("hello").innerHTML = html;
            });
            
        }
    });*/

    ajaxJson('http://192.168.0.15/~user14/REST_BOOK/client/api/shop/genres', function (data) {
        document.getElementById("list_genre").innerHTML = data["list_genre"];
        var html = "";
        if (Array.isArray(data)) {
            for (var i = 0; i < data.length; i++) {
                html += '<a href=?genre_id=' + data[i]["id"] + '> <button type="button" name="btn_car" class="btn btn-secondary"><h5>' + data[i]["genre"] + "</h5></button></a>";
            }
        } else {
            html += "There is some problems. Please, try again later!";
        }
        document.getElementById("list_genre").innerHTML = html;
    });

    ajaxJson('http://192.168.0.15/~user14/REST_BOOK/client/api/shop/authors', function (data) {
        document.getElementById("list_author").innerHTML = data["list_author"];
        var html = "";
        if (Array.isArray(data)) {
            for (var i = 0; i < data.length; i++) {
                html += '<a href=?author_id=' + data[i]["id"] + '> <button type="button" name="btn_car" class="btn btn-secondary"><h5>' + data[i]["author"] + "</h5></button></a>";
            }
        } else {
            html += "There is some problems. Please, try again later!";
        }
        document.getElementById("list_author").innerHTML = html;
    });

    if(window.location.search.includes("genre_id")){
        var str = window.location.search;
        var strArray = str.split('=');
        ajaxJson('http://192.168.0.15/~user14/REST_BOOK/client/api/shop/searchResultGenre/'+strArray[1], function (data) {
                document.getElementById("searchBooksByGenre").innerHTML = data["searchBooksByGenre"];
                var html = "";
                if (Array.isArray(data)) {
                    console.log(data);
                    for (var i = 0; i < data.length; i++) {
                        html += '<a href=html/book.html?book_id=' + data[i]["id"] + '>'
                            +'<img class="img-thumbnail books" src="html/img/books/'+data[i]["img"]+'" alt="img">'
                            +'<p> '+data[i]["book"]+'</p> '
                            +'</a>';
                    }
                } else {
                    html += "There is some problems. Please, change your data!";
                }
                document.getElementById("searchBooksByGenre").innerHTML = html;
            });
    }
    if(window.location.search.includes("author_id")){
        var str = window.location.search;
        var strArray = str.split('=');
        ajaxJson('http://192.168.0.15/~user14/REST_BOOK/client/api/shop/searchResultAuthors/'+strArray[1], function (data) {
                document.getElementById("searchBooksByAuthors").innerHTML = data["searchBooksByAuthors"];
                var html = "";
                if (Array.isArray(data)) {
                    console.log(data);
                    for (var i = 0; i < data.length; i++) {
                        html += '<a href=html/book.html?book_id=' + data[i]["id"] + '>'
                            +'<img class="img-thumbnail books" src="html/img/books/'+data[i]["img"]+'" alt="img">'
                            +'<p> '+data[i]["book"]+'</p> '
                            +'</a>';
                    }
                } else {
                    html += "There is some problems. Please, change your data!";
                }
                document.getElementById("searchBooksByAuthors").innerHTML = html;
            });
    }

    /*$('#btn_search').click(function () {
        valid = true;
        if (document.contact_form.name.year_issue == "") {

            alert("Please, fill the field Year issue.");
            valid = false;
        }
        if (valid) {
            //$("div#carsSearch").toggle(); 
            var brand = document.getElementById('brand').value;
            var model = document.getElementById('model').value;
            var color = document.getElementById('color').value;
            if (brand == "") {
                brand = "1";
            }
            if (model == "") {
                model = "1";
            }
            if (color == "") {
                color = "1";
            }

            var year_issue = document.getElementById('year_issue').value;
            var engin_capacity = document.getElementById('engin_capacity').value;
            var max_speed = document.getElementById('max_speed').value;
            var price_from = document.getElementById('price_from').value;
            var price_to = document.getElementById('price_to').value;

            ajaxJson('http://192.168.0.15/~user14/REST/client/api/shop/searchResult/' + brand + '/' + model + '/' + year_issue + '/' + engin_capacity + '/' + max_speed + '/' + color + '/' + price_from + '/' + price_to, function (data) {
                document.getElementById("carsSearch").innerHTML = data["carsSearch"];
                var html = "";
                if (Array.isArray(data)) {
                    for (var i = 0; i < data.length; i++) {
                        html += '<a href=html/auto.html?auto_id=' + data[i]["id"] + '> <button name="btn_car" class="btn btn-secondary"><h5>' + data[i]["brand"] + " " + data[i]["model"] + "</h5></button></a>";
                    }
                } else {
                    html += "There is some problems. Please, change your data!";
                }
                document.getElementById("carsSearch").innerHTML = html;
            });
        }
    });
*/
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