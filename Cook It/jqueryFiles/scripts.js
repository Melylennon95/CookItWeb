$(document).ready(function() {
    
    $("#homeTab").on('click', function(){
        //$("#featuredContainer").hide();
        $("#aboutContainer").hide();
        $("#homeContainer").show();
    });
//    $("#featuredTab").on('click', function(){
//        $("#homeContainer").hide();
//        $("#aboutContainer").hide();
//        $("#featuredContainer").show();
//    });
    $("#aboutTab").on('click', function(){
        $("#homeContainer").hide();
        //$("#featuredContainer").hide();
        $("#aboutContainer").show();
    });
    
    var checked = false;
    
     //chek start session 
     var jsonStartSession = {
                "action" : "CHECK-START"
        };
        
        $.ajax({
                url: "data/applicationLayer.php",
                type: "POST",
                data: jsonStartSession,
                dataType: "json",
                contentType: "application/x-www-form-urlencoded",
                success: function(jsonResponse){
                    
                   // alert("entre");
                   //alert(jsonResponse.message);
                    $("#Loginbtn").css('display', 'none');
                    $("#Register").css('display', 'none');
                    $("#Logoutbtn").css('display', 'inline-block');
                    $("#UserName").css('display', 'inline-block');
                    $('#UserName').html(jsonResponse.username);
                    
                    
                },
                error: function(errorMessage) {
                    $("#Loginbtn").css('display', 'inline-block');
                    $("#Register").css('display', 'inline-block');
                    $("#Logoutbtn").css('display', 'none');
                    $("#UserName").css('display', 'none');
                    $('#UserName').html("");
                 // alert(errorMessage.responseText);
                }
            })
    
    //register new user
    $("#registerButton").on("click", function(){
                var jsonObject = {
                    "action" : "REGISTRATION",
                    "username" : $("#username").val(),
                    "userPassword" : $("#userPassword").val(),
                    "email" : $("#email").val(),
                    "userFirstName" : $("#firstName").val(),
                    "userLastName" : $("#lastName").val()
                };

                $.ajax({
                    type: "POST",
                    url: "data/applicationLayer.php",
                    data : jsonObject,
                    dataType : "json",
                    contentType : "application/x-www-form-urlencoded",
                    success: function(jsonData) {
                        alert(jsonData.message); 
                        window.location.replace("Home.html");
                       
                    },
                    error: function(errorMsg){
                        alert(errorMsg.responseText);
                    }
                });
           });
            
           $("#cancelButton").on("click", function(){
                window.location.replace("Home.html");
           });
    
    //login
        $("#Loginbtn").click(function(){
            $("#myModal").css('display', 'block');
        });
    
     //close modal
        $(".close").click(function(){
            $("#myModal").css('display', 'none');
        });

     //login button in modal
         $("#LoginbtnModal").click(function() { 
            if($("#RememberMe").is(":checked")){
                checked = true;
            }
            
            var jsonData = {
                "action" : "LOGIN",
                "username" : $('#UserNameCom').val(),
                "password" : $("#PasswordCom").val(),
                "save"     : checked
            };
             
            $.ajax({
                url: "data/applicationLayer.php",
                type: "POST",
                data: jsonData,
                dataType: "json",
                contentType: "application/x-www-form-urlencoded",
                success: function(jsonResponse){
                    $("#myModal").css('display', 'none');
                    
                    $("#Loginbtn").css('display', 'none');
                    $("#Register").css('display', 'none');
                    $("#Logoutbtn").css('display', 'inline-block');
                    $("#UserName").css('display', 'inline-block');
                    $('#UserName').html(jsonData.username);
                    
                },
                error: function(errorMessage) {
                    alert(errorMessage.responseText);
                    $("#msgError").css('display', 'block');
                }
            })
         });
    
    //logout
     var jsonLogout = {
                "action" : "LOGOUT"
        };
        $("#Logoutbtn").click(function(){
            $.ajax({
                url: "data/applicationLayer.php",
                type: "POST",
                data : jsonLogout,
                dataType: "json",
                contentType: "application/x-www-form-urlencoded",
                success: function(jsonResponse){
                    //alert(jsonResponse.message);
                    $("#Loginbtn").css('display', 'inline-block');
                    $("#Register").css('display', 'inline-block');
                    $("#Logoutbtn").css('display', 'none');
                    $("#UserName").css('display', 'none');
                    $('#UserName').html("");
                },
                error: function(errorMessage) {
                }
            })
        });
   
    
});