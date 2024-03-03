-- Create a database if it doesn't exist
CREATE DATABASE IF NOT EXISTS shareme;

-- Create a user and grant privileges
CREATE USER '${MYSQL_USER}'@'localhost' IDENTIFIED BY '${MYSQL_PASSWORD}';
GRANT ALL PRIVILEGES ON shareme.* TO '${MYSQL_USER}'@'localhost';

-- Flush privileges to apply the changes immediately
FLUSH PRIVILEGES;

-- Use the created database
USE shareme;

CREATE TABLE IF NOT EXISTS Items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    link VARCHAR(15),
    item TEXT,
    checked VARCHAR(10) NULL
);

CREATE TABLE IF NOT EXISTS Titles (
    link VARCHAR(15) PRIMARY KEY,
    title VARCHAR(100) NULL
);