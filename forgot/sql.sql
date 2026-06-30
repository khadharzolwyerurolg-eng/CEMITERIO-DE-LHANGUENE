CREATE DATABASE forgot_db;

USE forgot_db;

GRANT ALL PRIVILEGES ON forgot_db.* TO 'terdeu'@'localhost';

CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT users(email, password) values
('xpozias@gmail.com', 'password'),
('terdeu@gmail.com', 'password'),
('admin@gmail.com', 'password');

CREATE TABLE verification_code (
    id INT(11) NOT NULL AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL,
    code VARCHAR(5) NOT NULL,
    expire int,
    date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
