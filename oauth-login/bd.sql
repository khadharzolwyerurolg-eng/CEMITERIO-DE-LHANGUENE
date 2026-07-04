CREATE DATABASE oauth_demo;
USE oauth_demo;

CREATE TABLE users(
    id INT AUTO_INCREMENT PRIMARY KEY,
    oauth_provider VARCHAR(50),
    oauth_uid VARCHAR(100),
    name VARCHAR(100),
    email VARCHAR(100),
    picture VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



GRANT ALL PRIVILEGES ON oauth_demo.* TO 'terdeu'@'localhost';
