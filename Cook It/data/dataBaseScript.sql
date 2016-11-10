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
    username VARCHAR(50) NOT NULL,
    userCom VARCHAR(200) NOT NULL
    
);

INSERT INTO usercomments (username, userCom)
VALUES  ('dinvis1952', 'As a food taster I can only say one thing 10/10'),
        ('MelyGrz95', 'Best burgers ever!'),
        ('osts1936', 'Excellent burgers, I want more!'),
		('saps1963', "It has quality, a good price, a great taste, and it's served as you decide. What else you want?"),
        ('thoom1961', 'The most delicious burger I have ever tasted. Great service!'),
        ('turnot1972', 'Came all the way from Notradame to taste these deicuous hamburgers. (Im now planning to live over here :) )');


CREATE TABLE userRecipe (
    RecipeId INT(100) NOT NULL PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    name VARCHAR(50) NOT NULL,
    ingredients VARCHAR(200) NOT NULL,
    steps VARCHAR(400) NOT NULL,
    image VARCHAR(50) NOT NULL
);

INSERT INTO userOrders (username, baseburger, bread, condiments, sizeburger, toppings, sauces, fries, numburges)
VALUES  ('dinvis1952', 'Hamburger', 'Wholemeal', 'Mayo, Ketchup', 'large', 'Peppers, Extra Cheese', ' BBQ Sauce, Hot Sauce', 'yes',            '10'),
        ('MelyGrz95', 'Cheese Burger', 'White', 'Mayo, Ketchup', 'large', 'Peppers, Extra Cheese', ' BBQ Sauce, Hot Sauce', 'no', '1');