CREATE TABLE user (
id INT(6) AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(128) NOT NULL,
email VARCHAR(128) NOT NULL
); 

INSERT INTO user (name, email) VALUES ("Steven", "steven@test.com");