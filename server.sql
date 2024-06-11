-- Create a new database
CREATE DATABASE IF NOT EXISTS user_accounts;

-- Use the created database
USE user_accounts;

-- Create a table to store user accounts
CREATE TABLE IF NOT EXISTS accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
