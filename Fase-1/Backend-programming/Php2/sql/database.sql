-- Database structuur voor de Portfolio-website
-- Maak eerst de database aan (indien nog niet aanwezig)

CREATE DATABASE IF NOT EXISTS portfolio_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE portfolio_db;

-- Tabel: users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'student',
    bio TEXT NULL,
    profileImage VARCHAR(255) NULL,
    website VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel: projects
CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    category VARCHAR(20) NOT NULL, -- 'school' of 'freelance'
    date DATE NOT NULL,
    image VARCHAR(255) NULL,
    -- extra kolommen voor de subklassen (FreelanceProject / SchoolProject)
    client_name VARCHAR(100) NULL,      -- alleen voor freelance projecten
    budget DECIMAL(10,2) NULL,          -- alleen voor freelance projecten
    school_name VARCHAR(100) NULL,      -- alleen voor school projecten
    grade VARCHAR(10) NULL,             -- alleen voor school projecten
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Optioneel: reacties op projecten (uitbreiding)
CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
);

-- Optioneel: likes op projecten (uitbreiding)
CREATE TABLE IF NOT EXISTS likes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    UNIQUE KEY unique_like (project_id, ip_address),
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
);
