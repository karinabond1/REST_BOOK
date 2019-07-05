(function ($) {
    $('#btn_yes_logout').click(function () {
        
            //$('#btn_reg').attr('type', 'submit');
            //var formData = sessionStorage.getItem("user").serializeArray();
            //console.log(formData);
            request = $.ajax({
                url: "http://192.168.0.15/~user14/REST_BOOK/server/api/user/userLogOff/?id="+sessionStorage.getItem("user"),
                type: "put",
                data: {'id': sessionStorage.getItem("user")}
            });

            // Callback handler that will be called on success
            request.done(function (response, textStatus, jqXHR) {
                // Log a message to the console
                console.log("Hooray, it worked!");
                if(response){                    
                    document.getElementById("goodbey").innerHTML = response;
                    sessionStorage.setItem("status", "offline");
                    sessionStorage.setItem("user", "0");
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
        

    });

    $('#btn_no_logout').click(function () {
        //$('#btn_log').attr('type', 'submit');
        window.location.href = 'http://192.168.0.15/~user14/REST_BOOK/client';
    });
   

    

}(jQuery))