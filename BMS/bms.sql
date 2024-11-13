CREATE DATABASE bms;

USE bms;

-- Table for user registration
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50),
    lastname VARCHAR(50),
    username VARCHAR(50) UNIQUE,
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    profile_image VARCHAR(255),
    birthdate DATE,
    sex VARCHAR(10),
    homeaddress VARCHAR(255),
    contact VARCHAR(15)
);

-- Table for document requests
CREATE TABLE requests (
    request_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    document_type VARCHAR(50),
    valid_id_type VARCHAR(50),
    valid_id_front VARCHAR(255),
    valid_id_back VARCHAR(255),
    date_of_request DATE,
    purpose TEXT,
    fee DECIMAL(10, 2),
    payment_method VARCHAR(50),
    service_method VARCHAR(50),
    status ENUM('pending', 'approved', 'completed', 'declined'),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Table for admin
CREATE TABLE admin (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    fullname VARCHAR(100)
);

-- Table for backup
CREATE TABLE backup (
    backup_id INT AUTO_INCREMENT PRIMARY KEY,
    data TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for recover
CREATE TABLE recover (
    recover_id INT AUTO_INCREMENT PRIMARY KEY,
    data TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE contact_messages (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);