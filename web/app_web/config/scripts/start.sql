CREATE TABLE users (
   id INT(6) AUTO_INCREMENT PRIMARY KEY,
   name VARCHAR(128) NOT NULL,
   email VARCHAR(128) UNIQUE NOT NULL,
   password VARCHAR(128) NOT NULL,
   roles JSON
);

INSERT INTO users (id, name, email, password) VALUES (1, "Steven", "steven@test.com", 'test123');

CREATE TABLE posts (
   id INT(6) AUTO_INCREMENT PRIMARY KEY,
   title VARCHAR(128) NOT NULL,
   date DATE NOT NULL,
   author INT(6) NOT NULL,
   description TEXT,
   FOREIGN KEY (author) REFERENCES users (id)
);

INSERT INTO posts (title, date, author, description) VALUES ('Blog test', '2021-03-16', 1, 'this is the first blog ...');

CREATE TABLE contacts (
  id INT(6) AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(128),
  email VARCHAR(128),
  message VARCHAR(1024)
);