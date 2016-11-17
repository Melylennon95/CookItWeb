CREATE DATABASE cookit;

CREATE TABLE users (
	fName VARCHAR(30) NOT NULL,
    lName VARCHAR(30) NOT NULL,
    email VARCHAR(30) NOT NULL,
    username VARCHAR(50) NOT NULL PRIMARY KEY,
    passwrd VARCHAR(200) NOT NULL
    
);

INSERT INTO Users(fName, lName, email, username, passwrd)
VALUES  ('Ale', 'Elizondo','AleElisondo@gmail.com', 'AleElizondo', 'AleElizondo'),
        ('Melissa', 'Figueroa','melylennon@gmail.com', 'MelyGrz95', 'MelyGrz95');
        
CREATE TABLE usercomments (
    comId INT(200) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    recId INT(200) NOT NULL,
    username VARCHAR(50) NOT NULL,
    userCom VARCHAR(200) NOT NULL
);

INSERT INTO usercomments (username, userCom)
VALUES ('1' ,'MelyGrz95', 'Best burgers ever!');


CREATE TABLE userrecipe (
    RecipeId INT(200) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    name VARCHAR(50) NOT NULL,
    ingredients VARCHAR(200) NOT NULL,
    steps VARCHAR(400) NOT NULL,
    timeH VARCHAR(10) NOT NULL,
    imageName VARCHAR(50) NOT NULL
);

CREATE TABLE userfavorite (
    favId INT(200) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    recipeId INT(200) NOT NULL
);





        

