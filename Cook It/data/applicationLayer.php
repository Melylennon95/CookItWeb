<?php

header('Content-type: application/json');
require_once __DIR__ . '/dataLayer.php';

$action = $_POST["action"];

switch($action){
	case "LOGIN" : loginFunction();
					break;
        
    case "REGISTRATION" : regiFunction();
                        break;
        
    case "LOAD-COMMENTS" : loadCom();
                        break;
    
    case "SAVE-COMMENTS" : saveCom();
                        break;
        
    case "CHECK-START" : checkStart();
                        break;
    
    case "CHECK-SESSION" : checkSession();
                        break;
        
    case "LOGOUT" : logout();
                    break;
        
    case "SAVE-RECIPE" : saveRecipe();
                    break;
        
    case "LOAD-RECIPE" : loadRecipe();
                    break;
        
    case "USER-INFO" : loadUserInfo();
                    break;
    
    case "RECIPE-DETAIL" : loadRecipeDetail();
                    break;
    
    case "LOADRES-MENU" : loadRecipeMenu();
                    break;
}
function checkStart(){
  
    $result = attemptCheckStart();
    
    if ($result["status"] == "SUCCESS"){
		echo json_encode(array("message" => "yay si guaraste cookie","username"=>$result["username"], "firstName"=>$result["firstName"] , "lastName"=>$result["lastName"], "email"=>$result["email"]));
	}	
	else{
		header('HTTP/1.1 500' . $result["status"]);
		die($result["status"]);
	}
}


function checkSession(){
    
    $result = attemptCheckSession();
   
    if ($result["status"] == "SUCCESS"){
		echo json_encode(array("message" => "yay si iniciaste sesion","username"=>$result["username"], "firstName"=>$result["firstName"] , "lastName"=>$result["lastName"], "email"=>$result["email"]));
	}	
	else{
		header('HTTP/1.1 500' . $result["status"]);
		die($result["status"]);
	}
}


function loginFunction(){
	$userName = $_POST["username"];
    $save = $_POST["save"];
    
    $result = attemptLogin($userName, $save);
    if ($result['status'] == 'COMPLETE'){
            
			# Decrypt the password retrieved form the database
			$decryptedPassword = decryptPassword($result['password']);
			$password = $_POST['password'];
			#echo $decryptedPassword;
        
			# Compare the decrypted password with the one provided by the user
		   	if ($decryptedPassword === $password)
		   	{	
		    	$response = array("status" => "COMPLETE");   
			    
			    # Starting the sesion
		    	# startSession($result['fName'], $result['lName'], $userName);
			    echo json_encode($response);
			}
			else
			{
				header('HTTP/1.1 306 Wrong credentials');
				die("Wrong credentials");
			}
		}
}

function decryptPassword($password){
		$key = pack('H*', "bcb04b7e103a05afe34763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
	    
	    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
    	
	    $ciphertext_dec = base64_decode($password);
	    $iv_dec = substr($ciphertext_dec, 0, $iv_size);
	    $ciphertext_dec = substr($ciphertext_dec, $iv_size);

	    $password = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
	   	
	   	
	   	$count = 0;
	   	$length = strlen($password);

	    for ($i = $length - 1; $i >= 0; $i --)
	    {
	    	if (ord($password{$i}) === 0)
	    	{
	    		$count ++;
	    	}
	    }

	    $password = substr($password, 0,  $length - $count); 

	    return $password;
	}

function encryptPassword(){
		$userPassword = $_POST['userPassword'];

	    $key = pack('H*', "bcb04b7e103a05afe34763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
	    $key_size =  strlen($key);
	    
	    $plaintext = $userPassword;

	    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
	    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	    
	    $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $plaintext, MCRYPT_MODE_CBC, $iv);
	    $ciphertext = $iv . $ciphertext;
	    
	    $userPassword = base64_encode($ciphertext);

	    return $userPassword;
}

 function regiFunction(){
    $userName = $_POST['username'];
     
    $result = verifyUser($userName);
     
    if ($result['status'] == 'COMPLETE'){ 

            $email = $_POST['email'];
            $userFirstName = $_POST['userFirstName'];
            $userLastName = $_POST['userLastName'];

			$userPassword = encryptPassword();

			# Make the insertion of the new user to the Database
			$result = attemptRegister($userName, $userPassword, $email, $userFirstName, $userLastName);
        
			# Verify that the insertion was successful
			if ($result['status'] == 'COMPLETE')
			{
				# Starting the session
				startSession($userName, $userFirstName, $userLastName, $email);
				echo json_encode($result);
			}
			else
			{
				# Something went wrong while inserting the new user
				die(json_encode($result));
				header('HTTP/1.1 409 Your action was not completed correctly, please try again later');
				die("Username in use");
			}  
		}
		else
		{
			# Username already exists
			header('HTTP/1.1 412 That username already exists');
			die("Username in use");
        }
}

function startSession($username, $fName, $lName, $email){
		// Starting the session
        session_start();
        session_destroy();
        session_start();

        $_SESSION['username'] = $username;	
        $_SESSION['fn'] = $fName;
        $_SESSION['ln'] =  $lName;
        $_SESSION['email'] = $email;	
}

function loadCom(){
    
    $ResID = $_POST['resId'];
    $result = attemptLoadCom($ResID);
    
    if ($result["status"] == "SUCCESS"){
		echo json_encode($result);
	}	
	else{
		header('HTTP/1.1 500' . $result["status"]);
		die($result["status"]);
	}
    
}


function saveCom(){
    
    $recId = $_POST['recId'];
    $userCom = $_POST['userCom'];
    
    $result = attemptSaveCom($recId , $userCom);
    
    if ($result["status"] == "SUCCESS"){
		echo json_encode(array("message" => "New record comment created successfully"));
	}	
	else{
		header('HTTP/1.1 500' . $result["status"]);
		die($result["status"]);
	}	
}



function logout(){
    
    $result = attemptLogout();
    
    if ($result["status"] == "SUCCESS"){
		echo json_encode(array("message" => "aawww diste logout~"));
	}	
	else{
		header('HTTP/1.1 500' . $result["status"]);
		die($result["status"]);
	}
}

function saveRecipe(){
    
    $name = $_POST['name'];
    $ingredients = $_POST['ingre'];
    $steps = $_POST['steps'];
    $timeH = $_POST['timeH'];
    $imageName = "VACIO";
    
    $result = attemptSaveRecipe($name, $ingredients, $steps, $timeH, $imageName);
    
    if ($result["status"] == "SUCCESS"){
		echo json_encode(array("message" => "New record comment created successfully"));
	}	
	else{
		header('HTTP/1.1 500' . $result["status"]);
		die($result["status"]);
	}	
}

function loadRecipe(){
    
    
    $result = attemptLoadRecipe();
    
    if ($result["status"] == "SUCCESS"){
		echo json_encode($result);
	}	
	else{
		header('HTTP/1.1 500' . $result["status"]);
		die($result["status"]);
	}
    
}

function loadUserInfo(){
    
    $result = attemptLoadUser();
    
    if ($result["status"] == "SUCCESS"){
		echo json_encode($result);
	}	
	else{
		header('HTTP/1.1 500' . $result["status"]);
		die($result["status"]);
	}
    
}

function loadRecipeDetail(){
    
    $ResID = $_POST['resId'];
    $result = attemptRecipeDetail($ResID);
    
    if ($result["status"] == "SUCCESS"){
		echo json_encode($result);
	}	
	else{
		header('HTTP/1.1 500' . $result["status"]);
		die($result["status"]);
	}
    
}

function loadRecipeMenu(){
    
    $result = attemptLoadRecipeMenu();
    
    if ($result["status"] == "SUCCESS"){
		echo json_encode($result);
	}	
	else{
		header('HTTP/1.1 500' . $result["status"]);
		die($result["status"]);
	}
    
}

?>