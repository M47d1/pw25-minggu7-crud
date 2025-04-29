-- Create Database
CREATE DATABASE IF NOT EXISTS crud_028;
USE crud_028;

-- Create table crud_028_jamaah
CREATE TABLE crud_028_jamaah (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(255) NOT NULL,
    no_paspor_ktp VARCHAR(50) NOT NULL,
    jenis_kelamin ENUM('L', 'P') NOT NULL,
    alamat TEXT NOT NULL,
    no_hp VARCHAR(20) NOT NULL,
    paket_umrah VARCHAR(50) NOT NULL,
    nama_mitra VARCHAR(255) NOT NULL
);

-- Create table crud_028_mitra
CREATE TABLE crud_028_mitra (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(255) NOT NULL,
    no_ktp_paspor VARCHAR(50) NOT NULL,
    alamat TEXT NOT NULL,
    no_hp VARCHAR(20) NOT NULL
);

-- Insert default admin for login
INSERT INTO crud_028_mitra (nama_lengkap, no_ktp_paspor, alamat, no_hp) VALUES
('admin', 'admin123', 'admin address', '081234567890');
