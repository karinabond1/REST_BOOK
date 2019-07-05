(function ($) {
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
            //$('#btn_reg').attr('type', 'submit');
            var formData = $('#reg_form').serialize();
            console.log(formData);

            request = $.ajax({
                url: "http://192.168.0.15/~user14/REST_BOOK/server/api/user/userInfo/",
                type: "post",
                data: formData
            });

            // Callback handler that will be called on success
            request.done(function (response, textStatus, jqXHR) {
                // Log a message to the console
                console.log("Hooray, it worked!");
                if(response){
                    $('#name').val("");
                    $('#surname').val("");
                    $('#email').val("");
                    $('#password').val("");
                    document.getElementById("bed_reg").innerHTML = response;
                }
                
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

    var name = "";
    var surname = "";

    $('#btn_log').click(function () {
        valid = true;
        if ($('#email_log').val() == "" || $('#password_log').val() == ""  || $('#email_log').val().includes(" ") || $('#password_log').val().includes(" ")) {

            alert("Please, fill all the fields.");
            valid = false;
        }
        if (valid) {
            //$('#btn_log').attr('type', 'submit');
            var formData = $('#log_form').serializeArray();
            console.log(formData);
            request = $.ajax({
                url: "http://192.168.0.15/~user14/REST_BOOK/server/api/user/userLog/?email_log="+$('#email_log').val()+"&password_log="+$('#password_log').val(),
                type: "put",
                data: formData
            });

            // Callback handler that will be called on success
            request.done(function (response, textStatus, jqXHR) {
                // Log a message to the console
                //sessionStorage.setItem("user", "online");

                    /*for (var i = 0; i < data.length; i++) {
                        sessionStorage.setItem("id", data[i]["id"]);
                        html += "<h2>Hello, "+data[i]["name"]+" "+data[i]["surname"]+"!</h2>";
                        sessionStorage.setItem("name", data[i]["name"]);
                        sessionStorage.setItem("surname", data[i]["surname"]);
                    }*/
                $('#email_log').val("");
                $('#password_log').val("");
                var data = JSON.parse(response);
                console.log(data);
                if(!Array.isArray(data)){                    
                    document.getElementById("bed_log").innerHTML = data;
                }else{
                    document.getElementById("bed_log").innerHTML = "Hello, "+data[0]['name']+" "+data[0]['surname']+"!";
                    sessionStorage.setItem("user", data[0]["id"]);
                    sessionStorage.setItem("status", "online");
                }
                console.log("Hooray, it worked!");
                console.log(response);
                console.log(textStatus);
                console.log(jqXHR);
            });
            request.fail(function (jqXHR, textStatus, errorThrown) {
                console.error(
                    "The following error occurred: " +
                    textStatus, errorThrown
                );
            });

            /*ajaxJson('http://192.168.0.15/~user14/REST_BOOK/client/api/user/userLog/' + $('#email_log').val() + '/' + $('#password_log').val(), function (data) {
                //document.getElementById("hello").innerHTML = data["hello"];
                var html = "";
                if (Array.isArray(data)) {
                    sessionStorage.setItem("user", "online");

                    for (var i = 0; i < data.length; i++) {
                        sessionStorage.setItem("id", data[i]["id"]);
                        html += "<h2>Hello, "+data[i]["name"]+" "+data[i]["surname"]+"!</h2>";
                        sessionStorage.setItem("name", data[i]["name"]);
                        sessionStorage.setItem("surname", data[i]["surname"]);
                    }
                } else {
                    html += "There is some problems. Please, change your data!";
                }
                document.getElementById("hello").innerHTML = html;
            });
            */
        }
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