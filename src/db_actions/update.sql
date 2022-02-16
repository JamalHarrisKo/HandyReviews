CREATE DATABASE IF NOT EXISTS smartphoneportal_JamalHarris;
USE smartphoneportal_JamalHarris;
CREATE TABLE IF NOT EXISTS users (
    user_id int(10) NOT NULL AUTO_INCREMENT,
    user_mail varchar(50) UNIQUE NOT NULL DEFAULT 'user@example.com',
    user_pw varchar (50) NOT NULL DEFAULT 'PW',
    user_name varchar(20) NOT NULL DEFAULT 'User',
    PRIMARY KEY (user_id)
);
CREATE TABLE IF NOT EXISTS products (
    product_id int(10) NOT NULL AUTO_INCREMENT,
    product_name varchar(50) NOT NULL DEFAULT '',
    product_price varchar (7) NOT NULL DEFAULT '$',
    product_image varchar(255) NOT NULL DEFAULT'',
    product_image_backside varchar(255) NOT NULL DEFAULT'',
    product_screensize varchar(255) NOT NULL DEFAULT'',
    product_screen_resolution varchar(255) NOT NULL DEFAULT'',
    product_weight varchar(255) NOT NULL DEFAULT'',
    product_company_info varchar(255) NOT NULL DEFAULT'',
    product_description TEXT (1000) NOT NULL,
    PRIMARY KEY (product_id)
);  
CREATE TABLE IF NOT EXISTS reviews (
    review_id int(10) NOT NULL AUTO_INCREMENT,
    review_content TEXT (1000),
    product_id int(10),
    user_id int(10),
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    PRIMARY KEY (review_id)
);
CREATE TABLE IF NOT EXISTS rating_values(
    rating_value_id int(10) AUTO_INCREMENT NOT NULL,
    rating_value_value int(1) UNIQUE,
    rating_value_name varchar (10),
    PRIMARY KEY (rating_value_id)
);
CREATE TABLE IF NOT EXISTS ratings (
    rating_id int(10) NOT NULL AUTO_INCREMENT,
    rating_value_id int (10) NOT NULL DEFAULT 0,
    review_id int(10),
    user_id int(10),
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (review_id) REFERENCES reviews(review_id),
    FOREIGN KEY (rating_value_id) REFERENCES rating_values(rating_value_id),
    PRIMARY KEY (rating_id)
);

CREATE TABLE IF NOT EXISTS comments (
    comment_id int(10) NOT NULL AUTO_INCREMENT,
    comment_content TEXT (1000),
    user_id int(10),
    review_id int(10),
    FOREIGN KEY (review_id) REFERENCES reviews(review_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    PRIMARY KEY (comment_id)
);
CREATE TABLE IF NOT EXISTS categories(
    categorie_id int (10) AUTO_INCREMENT,
    categorie_name varchar (15),
    PRIMARY KEY (categorie_id)  
);
CREATE TABLE IF NOT EXISTS price_categories(
    price_categorie_id int (10) AUTO_INCREMENT,
    price_categorie_name varchar (15),
    PRIMARY KEY (price_categorie_id)  
);
CREATE TABLE IF NOT EXISTS products_categories (
    product_id int(10),
    categorie_id int (10),
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    FOREIGN KEY (categorie_id) REFERENCES categories(categorie_id)
);
CREATE TABLE IF NOT EXISTS products_price_categories (
    product_id int(10),
    price_categorie_id int (10),
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    FOREIGN KEY (price_categorie_id) REFERENCES price_categories(price_categorie_id)
);
INSERT INTO rating_values(rating_value_id, rating_value_value, rating_value_name)
VALUES (1, 5, '5 Sterne'), (2, 4, '4 Sterne'), (3, 3, '3 Sterne'), (4, 2, '2 Sterne'), (5, 1, '1 Stern');

INSERT INTO categories(categorie_name)
VALUES ('Apple'), ('Samsung'), ('Google'), ('Mobile'), ('Tablet'), ('Andere');

INSERT INTO price_categories(price_categorie_name)
VALUES ('Einsteiger'), ('Mid-Range'), ('High-End');




--ALTER TABLE ratings 
--ADD FOREIGN KEY (review_id) REFERENCES reviews(review_id);

--ADD FOREIGN KEY (product_id) REFERENCES products(product_id);



