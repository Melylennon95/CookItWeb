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
    username VARCHAR(50) NOT NULL,
    name VARCHAR(50) NOT NULL,
    ingredients VARCHAR(200) NOT NULL,
    steps VARCHAR(400) NOT NULL,
    timeH VARCHAR(10) NOT NULL,
    imageName VARCHAR(50) NOT NULL
);

INSERT INTO userOrders (username, baseburger, bread, condiments, sizeburger, toppings, sauces, fries, numburges)
VALUES  ('dinvis1952', 'Hamburger', 'Wholemeal', 'Mayo, Ketchup', 'large', 'Peppers, Extra Cheese', ' BBQ Sauce, Hot Sauce', 'yes',            '10'),
        ('MelyGrz95', 'Cheese Burger', 'White', 'Mayo, Ketchup', 'large', 'Peppers, Extra Cheese', ' BBQ Sauce, Hot Sauce', 'no', '1');
        
Waffles 

00:20

2 eggs
2 cups all-purpose flour
1 3/4 cups milk
1/2 cup vegetable oil
1 tablespoon white sugar
4 teaspoons baking powder
1/4 teaspoon salt
1/2 teaspoon vanilla extract
        
1 - Preheat waffle iron. Beat eggs in large bowl with hand beater until fluffy. Beat in flour, milk, vegetable oil, sugar, baking powder, salt and vanilla, just until smooth.

2- Spray preheated waffle iron with non-stick cooking spray. Pour mix onto hot waffle iron. Cook until golden brown. Serve hot.