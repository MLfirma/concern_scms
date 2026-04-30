CREATE DATABASE scms;
USE scms;
CREATE TABLE users (id INT AUTO_INCREMENT PRIMARY KEY,name VARCHAR(100),email VARCHAR(100),role ENUM('admin','staff'),department VARCHAR(50),password VARCHAR(255));
CREATE TABLE concerns (id INT AUTO_INCREMENT PRIMARY KEY,category ENUM('Academic','Financial','Welfare'),program VARCHAR(100),description TEXT,attachment VARCHAR(255),is_anonymous BOOLEAN DEFAULT 0,student_email VARCHAR(100),status ENUM('Submitted','Routed','Read','Screened','Resolved','Escalated') DEFAULT 'Submitted',assigned_department VARCHAR(50),created_at DATETIME DEFAULT CURRENT_TIMESTAMP,updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP);
CREATE TABLE audit_logs (id INT AUTO_INCREMENT PRIMARY KEY,concern_id INT,action VARCHAR(100),actor VARCHAR(100),created_at DATETIME DEFAULT CURRENT_TIMESTAMP);
