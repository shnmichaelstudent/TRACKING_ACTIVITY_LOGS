SELECT * FROM activity_logs;

SELECT * FROM users WHERE id = 4545;

ALTER TABLE activity_logs MODIFY user_id INT NULL;

SELECT * FROM users WHERE id = '4545';

ALTER TABLE activity_logs ADD username VARCHAR(255) NOT NULL;

ALTER TABLE applicants ADD applied_position VARCHAR(255);

ALTER TABLE applicants ADD address VARCHAR(255);

ALTER TABLE users ADD reset_token VARCHAR(255), ADD token_expiry TIMESTAMP;

SELECT * FROM applicants LIMIT 10 OFFSET 0;

SELECT * FROM applicants 
WHERE name LIKE :search OR email LIKE :search;

ALTER TABLE users ADD role ENUM('admin', 'user') DEFAULT 'user';

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE applicants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    position VARCHAR(50) NOT NULL,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE activity_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    activity VARCHAR(255) NOT NULL,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE DATABASE job_application_system;

USE job_application_system;

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Applicants table
CREATE TABLE applicants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20),
    address TEXT,
    applied_position VARCHAR(100),
    created_by VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Activity logs table
CREATE TABLE activity_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    action VARCHAR(50),
    details TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

