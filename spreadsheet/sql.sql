CREATE DATABASE spreadsheet_db;

USE spreadsheet_db;

GRANT ALL PRIVILEGES ON spreadsheet_db.* TO 'terdeu'@'localhost';
CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    image VARCHAR(1024) NOT NULL,
    age INT(3) DEFAULT(1),
    date_created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    date_updated DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    city VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO TABLE users(name, age, city, email) VALUE('Mathew', 21, 'Mateque', 'terdeu@gmail.com');