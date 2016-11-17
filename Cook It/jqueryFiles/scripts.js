$(document).ready(function() {
    
    /*$("#homeTab").on('click', function(){
        $("#featuredContainer").hide();
        $("#aboutContainer").hide();
        $("#homeContainer").show();
    });*/
    
    
    $("#featuredTab").on('click', function(){
        $("#homeContainer").hide();
        $("#aboutContainer").hide();
        $("#featuredContainer").show();
    });
    $("#aboutTab").on('click', function(){
        $("#homeContainer").hide();
        $("#rec_word").hide();
        $("#featuredContainer").hide();
        $("#aboutContainer").show();
    });
    
    
    
    //-------------------------------------------------------------------
    //--------------User Recipes-----------------------------------------
    //-------------------------------------------------------------------
    
    $("#Contenido").on("click",".btn.btn-primary" , function(){
            var RecipeIdBtn = $(this).attr("id");
            window.location.replace("RecipeDetail.html?RecipeIdBtn=" + RecipeIdBtn);
                    
    });
    
        
    //-------------------------------------------------------------------
    //--------------Home page-----------------------------------------
    //-------------------------------------------------------------------
    var checked = true;
    
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
        $("#fillname").css('display', 'none');
        $("#fillLaname").css('display', 'none');
        $("#fillemail").css('display', 'none');
        $("#fillusername").css('display', 'none');
        $("#fillpassword").css('display', 'none');
        
        if($.trim($("#firstName").val()) == ""){
            $("#fillname").css('display', 'inline-block');
            $("#fillname").css('color', 'crimson');
        }
        if($.trim($("#lastName").val()) == ""){
            $("#fillLaname").css('display', 'inline-block');
            $("#fillLaname").css('color', 'crimson');
        }
        if($.trim($("#email").val()) == ""){
            $("#fillemail").css('display', 'inline-block');
            $("#fillemail").css('color', 'crimson');
        }
        if($.trim($("#username").val()) == ""){
            $("#fillusername").css('display', 'inline-block');
            $("#fillusername").css('color', 'crimson');
        }
        if($.trim($("#userPassword").val()) == ""){
            $("#fillpassword").css('display', 'inline-block');
            $("#fillpassword").css('color', 'crimson');
        }
        
        if(($.trim($("#firstName").val()) != "") && ($.trim($("#lastName").val()) != "") && ($.trim($("#email").val()) != "")&& ($.trim($("#username").val()) != "") && ($.trim($("#userPassword").val()) != "")){
            
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
                    //alert(jsonData.message); 
                    window.location.replace("Home.html");

                },
                error: function(errorMsg){
                    alert(errorMsg.responseText);
                }
            }); 
        }
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
    
        var jsonLoadRes = {
            "action" : "LOADRES-MENU"
        };
        
        $.ajax({
                url: "data/applicationLayer.php",
                type: "POST",
                data : jsonLoadRes,
                dataType: "json",
                contentType: "application/x-www-form-urlencoded",
                success: function(jsonResponse){
                   
                    var countArr = 0;
                   
                    $.each( jsonResponse, function( i, l ){
                        countArr ++;
                    }); 
                    
                    for (var i = 0; i < countArr-1; i++){
                        newHTMLContent = "";
                        
                        $("#Container").append('<div style="margin-left: 3em; id="listUp" ><br>' + jsonResponse[i].name + '<br>' + jsonResponse[i].timeH +' ' +'<label>hours </label>' + '<br><input style="display:inline-block" type=button class="btn btn-primary" id = '+ jsonResponse[i].RecipeId +' align="right" value="Details"></input></div><hr>');
                        
                        
                        $('#Contenido').css({'margin':'auto'});

                    }
                    
                },
                error: function(errorMessage) {
                    //alert(errorMessage.responseText);
                    $("#Contenido").append("No content uploaded");
                }
        })
        
         $("#Container").on("click",".btn.btn-primary" , function(){
            var RecipeIdBtn = $(this).attr("id");
            window.location.replace("RecipeDetail.html?RecipeIdBtn=" + RecipeIdBtn);
                    
        });
    
    //-------------------------------------------------------------------
    //--------------Upload Form-----------------------------------------
    //-------------------------------------------------------------------
    
    //upload new recipe
    $("#UploadBtn").on("click", function(){
        $("#Uploadfillname").css('display', 'none');
        $("#UploadfillIngredients").css('display', 'none');
        $("#UploadfillSteps").css('display', 'none');
        $("#Uploadfilltime").css('display', 'none');
        
        if($.trim($("#recipeName").val()) == ""){
            $("#Uploadfillname").css('display', 'inline-block');
            $("#Uploadfillname").css('color', 'crimson');
        }
        if($.trim($("#ingredientesArea").val()) == ""){
            $("#UploadfillIngredients").css('display', 'inline-block');
            $("#UploadfillIngredients").css('color', 'crimson');
        }
        if($.trim($("#stepsArea").val()) == ""){
            $("#UploadfillSteps").css('display', 'inline-block');
            $("#UploadfillSteps").css('color', 'crimson');
        }
        if($.trim($("#tiempo").val()) == ""){
            $("#Uploadfilltime").css('display', 'inline-block');
            $("#Uploadfilltime").css('color', 'crimson');
        }
        
        if(($.trim($("#recipeName").val()) != "") && ($.trim($("#ingredientesArea").val()) != "") && ($.trim($("#stepsArea").val()) != "")&& ($.trim($("#tiempo").val()) != "")){
            
            var jsonRecipe = {
                "action" : "SAVE-RECIPE",
                "name" : $("#recipeName").val(),
                "ingre" : $("#ingredientesArea").val(),
                "steps" : $("#stepsArea").val(),
                "timeH" : $("#tiempo").val()
            };

            $.ajax({
                type: "POST",
                url: "data/applicationLayer.php",
                data : jsonRecipe,
                dataType : "json",
                contentType : "application/x-www-form-urlencoded",
                success: function(jsonData) {
                   // alert(jsonData.message); 
                    window.location.replace("UserRecipe.html");

                },
                error: function(errorMsg){
                    alert(errorMsg.responseText);
                }
            }); 
        }
    });
          
    
    
     //cancel
         $("#loadCancelBtn").on("click", function(){
            window.location.replace("Userprofile.html");
      });
    
    
     //-------------------------------------------------------------------
    //--------------Upload Form-----------------------------------------
    //-------------------------------------------------------------------
    
   
     $("#loadCancelBtn").on("click", function(){
       
        
      });
    
    
});