<?php

	function connectionToDataBase(){
		$servername = "localhost";
		$username = "root";
		$password = "root";
		$dbname = "cookit";

		$conn = new mysqli($servername, $username, $password, $dbname);

		if ($conn->connect_error){
			return null;
		}
		else{
			return $conn;
		}
	}

    function verifyUser($userName){
        
    	# Open and validate the Database connection
    	$conn = connectionToDataBase();

        if ($conn != null)
        {   
        	$sql = "SELECT * FROM Users WHERE userName = '$userName'";
            
			$result = $conn->query($sql);

			if ($result->num_rows > 0)
			{
				# The current user already exists
				$conn->close();
				return array("status" => "ERROR");
			}
			else
			{
				# Username not yet in use
				$conn->close();
				return array("status" => "COMPLETE");
			}
        }
        else
        {
        	# Connection to Database was not successful
        	$conn->close();
        	return array("status" => "ERROR");
        }
    }

	function attemptLogin($userNames, $save){
		
        $conn = connectionToDataBase();
        
        if ($conn != null){
        	$sql = "SELECT * FROM Users WHERE userName = '$userNames'";
            
			$result = $conn->query($sql);
			
			# The current user exists
			if ($result->num_rows > 0)
			{
				while($row = $result->fetch_assoc()) 
		    	{
                    $firstname = $row["fName"];
                    $lastName = $row["lName"];
                    $email = $row["email"];
                    $psswrd = $row['passwrd'];
				}
                
                setcookie("save", $save, time()+2000, "/","", 0);
            
                if($save == "true"){
                    setcookie("user", $userNames, time()+2000, "/","", 0);
                }
                
                session_start();
                session_destroy();
                session_start();

                $_SESSION['username'] = $userNames;	
                $_SESSION['fn'] = $firstname;
                $_SESSION['ln'] =  $lastName;
                $_SESSION['email'] = $email;	

                $conn -> close();
				return array("status" => "COMPLETE" , "password" => $psswrd);
			}
			else
			{
				# The user doesn't exists in the Database
				$conn->close();
				return array("status" => "ERROR");
			}
        }
        else
        {
        	# Connection to Database was not successful
        	$conn->close();
        	return array("status" => "ERROR");
        }
        
	}
    
  function attemptRegister($userName, $userPassword, $email, $userFirstName, $userLastName){
        
        $conn = connectionToDataBase();
      
        if ($conn != null)
        {
        	$sql = "INSERT INTO Users (fName, lName, email,username, passwrd) VALUES ('$userFirstName', '$userLastName','$email' ,'$userName', '$userPassword')";
            
			if (mysqli_query($conn, $sql)) 
	    	{
	    		# User registered correctly
	    		$conn->close();
			    return array("status" => "COMPLETE");
			} 
			else 
			{
				# Something went wrong when inserting the user
				$conn->close();
				return array("status" => "ERROR");
			}
        }
        else
        {
        	# Connection to Database was not successful
        	$conn->close();
        	return array("status" => "ERROR");
        }
      
      
    }

 function attemptLoadCom($ResID){
     
         $conn = connectionToDataBase();
        
         if ($conn != null){
             
            $sql = "SELECT fName, lName, email, userCom
            FROM users , usercomments
            WHERE usercomments.recId = '$ResID' AND users.username = usercomments.username";

            $result = $conn->query($sql);

            if ($result->num_rows > 0){
                
                $response = array("status" => "SUCCESS");
                while ($row = $result->fetch_assoc()){
                    array_push($response,array("firstName"=>$row["fName"], "lastName"=>$row["lName"], "email"=>$row["email"], "com"=>$row["userCom"]));
                }
                
                
                return $response;
            }
            else
            {
                
                return array("status" => "could not load comments");
            }
		}else{
			$conn -> close();
			return array("status" => "CONNECTION WITH DB WENT WRONG");
		}
    }

function attemptLoadOrder(){
     
         session_start();
        
         $userName = $_SESSION['username'];
    
         $conn = connectionToDataBase();
        
         if ($conn != null){
             
            $sql = "SELECT userorders.username, baseburger, bread, condiments , sizeburger, toppings, sauces, fries, numburges
            FROM userorders
            WHERE userorders.username = '$userName' ";

            $result = $conn->query($sql);

            if ($result->num_rows > 0){
                
                $response = array("status" => "SUCCESS");
                while ($row = $result->fetch_assoc()){
                    array_push($response,array("baseb"=>$row["baseburger"], "breadb"=>$row["bread"], "condib"=>$row["condiments"], "sizeb"=>$row["sizeburger"], "toppib"=>$row["toppings"], "sauceb"=>$row["sauces"], "friesb"=>$row["fries"], "numb"=>$row["numburges"]));
                }
                
                return $response;
            }
            else
            {
                
                return array("status" => "could not load comments");
            }
		}else{
			$conn -> close();
			return array("status" => "CONNECTION WITH DB WENT WRONG");
		}
    }


    function attemptSaveCom($recId , $userCom){
        
         $conn = connectionToDataBase();
        
        session_start();
        
         $userName = $_SESSION['username'];
        
         if ($conn != null){
             
             $sql = "INSERT INTO usercomments(recId , username, userCom) VALUES ('$recId', '$userName' , '$userCom')";
             
                 if (mysqli_query($conn, $sql)) 
                {
                    $conn -> close();
			         return array("status" => "SUCCESS");
                     
                } 
                else 
                {
                    $conn -> close();
			         return array("status" => "could not save comment");
                }
		}else{
			$conn -> close();
			return array("status" => "CONNECTION WITH DB WENT WRONG");
		}
    }

function attemptSaveFav($recId){
        
         $conn = connectionToDataBase();
        
        session_start();
        
         $userName = $_SESSION['username'];
        
         if ($conn != null){
             
             $sql = "INSERT INTO userfavorite(username, recipeId) VALUES ('$userName' , '$recId')";
             
                 if (mysqli_query($conn, $sql)) 
                {
                    $conn -> close();
			         return array("status" => "SUCCESS");
                     
                } 
                else 
                {
                    $conn -> close();
			         return array("status" => "could not save favorite");
                }
		}else{
			$conn -> close();
			return array("status" => "CONNECTION WITH DB WENT WRONG");
		}
 }

function attemptLoadfav(){
     
         $conn = connectionToDataBase();
    
         session_start();
        
         $userName = $_SESSION['username'];
        
         if ($conn != null){
             
            $sql = "SELECT userrecipe.recipeId, name, ingredients, steps, timeH, imageName
            FROM userfavorite, userrecipe
            WHERE userfavorite.username = '$userName' AND userfavorite.recipeId = userrecipe.RecipeId";

            $result = $conn->query($sql);
            if ($result->num_rows > 0){
                
                $response = array("status" => "SUCCESS");
                
                while ($row = $result->fetch_assoc()){
                    array_push($response,array( "name"=>$row["name"], "ingredients"=>$row["ingredients"], "steps"=>$row["steps"], "timeH"=>$row["timeH"], "imageName"=>$row["imageName"]));
                }
                
                
                return $response;
            }
            else
            {
                
                return array("status" => "could not load recipes");
            }
		}else{
			$conn -> close();
			return array("status" => "CONNECTION WITH DB WENT WRONG");
		}
}



function attemptSaveOrder($burger, $bread, $condiments, $burgerSize, $toppings, $sauces, $fries, $numBurgers ){
        
        session_start();
        
         $userName = $_SESSION['username'];
         $conn = connectionToDataBase();
        
         if ($conn != null){
             
			$sql = "INSERT INTO userorders(username, baseburger, bread, condiments, sizeburger, toppings, sauces, fries, numburges) VALUES ('$userName', '$burger', '$bread', '$condiments', '$burgerSize', '$toppings', '$sauces', '$fries', '$numBurgers')";
             
                 if (mysqli_query($conn, $sql)) 
                {
                    $conn -> close();
			         return array("status" => "SUCCESS");
                     
                } 
                else 
                {
                    $conn -> close();
			         return array("status" => "could not save");
                }
		}else{
			$conn -> close();
			return array("status" => "CONNECTION WITH DB WENT WRONG");
		}
    }

    function attemptCheckStart(){     
        
        session_start();
        
        if($_COOKIE["save"]=="false"){
            setcookie("user", "", time() - 3600);
            session_destroy();
            echo "error";
        }
        
        if (isset($_COOKIE["user"])){
            
            if (isset($_SESSION['username'])){

            return array("status" => "SUCCESS", "username"=>$_SESSION['username'],"firstName"=>$_SESSION['fn'],"lastName"=>$_SESSION['ln'],"email"=>$_SESSION['email']);

            }
            else{
                return array("status" => "no esta la session iniciada :c");
            }
        }
        else{
            return array("status" => "no guardo cookie:c");
        }
    }

    function attemptCheckSession(){
        
        session_start();
        
        if (isset($_SESSION['username'])){

            return array("status" => "SUCCESS", "username"=>$_SESSION['username'],"firstName"=>$_SESSION['fn'],"lastName"=>$_SESSION['ln'],"email"=>$_SESSION['email']);

        }
        else{
            return array("status" => "no esta la session iniciada :c");
        }

    }


function attemptLogout(){
        
    session_start();

    if (isset($_SESSION['username'])) {
        unset($_SESSION["username"]);

    }

    if (isset($_COOKIE["user"])){

        setcookie("user", "", time() - 3600);

    }

    session_destroy();
    return array("status" => "SUCCESS");

    }

function attemptSaveRecipe($name, $ingredients, $steps, $timeH, $imageName){
        
         session_start();
        
         $userName = $_SESSION['username'];
         $conn = connectionToDataBase();
        
         if ($conn != null){
             
			$sql = "INSERT INTO userRecipe(username, name, ingredients, steps, timeH, imageName) VALUES ('$userName', '$name' , '$ingredients' , '$steps' , '$timeH' , '$imageName')";
             
                 if (mysqli_query($conn, $sql)) 
                {
                    $conn -> close();
			         return array("status" => "SUCCESS");
                     
                } 
                else 
                {
                    $conn -> close();
			         return array("status" => "could not save");
                }
		}else{
			$conn -> close();
			return array("status" => "CONNECTION WITH DB WENT WRONG");
		}
    }

function attemptLoadRecipe(){
     
         $conn = connectionToDataBase();
    
         session_start();
        
         $userName = $_SESSION['username'];
        
         if ($conn != null){
             
            $sql = "SELECT RecipeId, name, ingredients, steps, timeH, imageName
            FROM userRecipe
            WHERE username = '$userName' ";

            $result = $conn->query($sql);
            if ($result->num_rows > 0){
                
                $response = array("status" => "SUCCESS");
                
                while ($row = $result->fetch_assoc()){
                    array_push($response,array( "RecipeId"=>$row["RecipeId"] ,"name"=>$row["name"], "ingredients"=>$row["ingredients"], "steps"=>$row["steps"], "timeH"=>$row["timeH"], "imageName"=>$row["imageName"]));
                }
                
                
                return $response;
            }
            else
            {
                
                return array("status" => "could not load recipes");
            }
		}else{
			$conn -> close();
			return array("status" => "CONNECTION WITH DB WENT WRONG");
		}
    }

function attemptLoadUser(){
     
         $conn = connectionToDataBase();
    
         session_start();
        
         $userName = $_SESSION['username'];
        
         if ($conn != null){
             
            $sql = "SELECT fName, lName, email, username
            FROM users
            WHERE username = '$userName' ";

            $result = $conn->query($sql);
            if ($result->num_rows > 0){
                
                while ($row = $result->fetch_assoc()){
                    return array("status" => "SUCCESS","fname"=>$row["fName"],"lname"=>$row["lName"],"email"=>$row["email"],"userName"=>$row["username"]);
                }
                
            }
            else
            {
                
                return array("status" => "could not load recipes");
            }
		}else{
			$conn -> close();
			return array("status" => "CONNECTION WITH DB WENT WRONG");
		}
    }

function attemptRecipeDetail($ResID){
         $conn = connectionToDataBase();
        
         if ($conn != null){
            $sql = "SELECT RecipeId, name, ingredients, steps, timeH, imageName
            FROM userRecipe
            WHERE RecipeId = '$ResID' ";

            $result = $conn->query($sql);
            if ($result->num_rows > 0){
                
                while ($row = $result->fetch_assoc()){
                    return array("status" => "SUCCESS","RecipeId"=>$row["RecipeId"] ,"name"=>$row["name"], "ingredients"=>$row["ingredients"], "steps"=>$row["steps"], "timeH"=>$row["timeH"], "imageName"=>$row["imageName"]);
                }
                
            }
            else
            {
                
                return array("status" => "could not load recipe detail");
            }
		}else{
			$conn -> close();
			return array("status" => "CONNECTION WITH DB WENT WRONG");
		}
    }

function attemptLoadRecipeMenu(){
     
         $conn = connectionToDataBase();
    
         session_start();
        
         $userName = $_SESSION['username'];
        
         if ($conn != null){
             
            $sql = "SELECT * FROM userRecipe ";

            $result = $conn->query($sql);
            if ($result->num_rows > 0){
                
                $response = array("status" => "SUCCESS");
                
                while ($row = $result->fetch_assoc()){
                    array_push($response,array( "RecipeId"=>$row["RecipeId"] ,"name"=>$row["name"], "ingredients"=>$row["ingredients"], "steps"=>$row["steps"], "timeH"=>$row["timeH"], "imageName"=>$row["imageName"]));
                }
                
                
                return $response;
            }
            else
            {
                
                return array("status" => "could not load recipes");
            }
		}else{
			$conn -> close();
			return array("status" => "CONNECTION WITH DB WENT WRONG");
		}
    }
?>