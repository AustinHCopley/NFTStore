DROP TABLE IF EXISTS customer;

CREATE TABLE customer (
  id int AUTO_INCREMENT,
  first_name varchar(255),
  last_name varchar(255),
  email varchar(255) UNIQUE NOT NULL,
  PRIMARY KEY(id)
);

DROP TABLE IF EXISTS product;

CREATE TABLE product (
  id int AUTO_INCREMENT,
  product_name varchar(255),
  image_name varchar(255),
  price decimal(6,2),
  in_stock int,
  inactive TINYINT,
  PRIMARY KEY(id)
);

DROP TABLE IF EXISTS orders;

CREATE TABLE orders (
  id int AUTO_INCREMENT,
  product_id int NOT NULL,
  customer_id int NOT NULL,
  quantity int,
  price decimal(6,2),
  tax decimal(6,2),
  donation decimal(4,2),
  timestamp bigint,
  PRIMARY KEY (id),
  FOREIGN KEY (product_id) REFERENCES product (id),
  FOREIGN KEY (customer_id) REFERENCES customer (id)
);

DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id int AUTO_INCREMENT,
  first_name varchar(255),
  last_name varchar(255),
  password varchar(255),
  email varchar(255),
  role TINYINT,
  PRIMARY KEY (id)
)

INSERT INTO customer (first_name, last_name, email)
VALUES ('Mickey', 'Mouse', 'mmouse@disney.com');
INSERT INTO customer (first_name, last_name, email)
VALUES ('John', 'Smith', 'johnsmith@gmail.com');

INSERT INTO product (product_name, image_name, price, in_stock, inactive)
VALUES ('broccoli', 'broccoli.jpeg', 299.50, 4, 0);
INSERT INTO product (product_name, image_name, price, in_stock, inactive)
VALUES ('leek', 'leek.jpeg', 274.75, 0, 0);
INSERT INTO product (product_name, image_name, price, in_stock, inactive)
VALUES ('corn', 'corn.jpeg', 249.99, 35, 0);

INSERT INTO users (first_name, last_name, password, email, role)
VALUES ('Frodo', 'Baggins', 'fb', 'fb@lotr.com', 1);
INSERT INTO users (first_name, last_name, password, email, role)
VALUES ('Harry', 'Potter', 'hp', 'hp@hogwarts.com', 2);
