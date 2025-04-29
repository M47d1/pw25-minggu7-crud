CREATE DATABASE IF NOT EXISTS travel_db;
USE travel_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(50)
);

INSERT INTO users (username, password) VALUES ('admin', 'admin123');

CREATE TABLE crud_028 (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_jamaah VARCHAR(100),
    no_paspor VARCHAR(50),
    alamat TEXT,
    no_hp VARCHAR(20),
    paket_umrah VARCHAR(100)
);