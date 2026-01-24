DROP DATABASE IF EXISTS web25;
CREATE DATABASE web25;
USE web25;

-- =====================================
-- USER
-- =====================================
CREATE TABLE USER (
    email VARCHAR(100) PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    surname VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    avatar VARCHAR(255) DEFAULT 'default-avatar.png',
    role ENUM('USER', 'HOST', 'ADMINISTRATOR') NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- -- =====================================
-- -- CATEGORIY
-- -- =====================================
CREATE TABLE CATEGORY (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL UNIQUE
);

-- =====================================
-- EVENT
-- =====================================
CREATE TABLE EVENT (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    event_date DATETIME NOT NULL,
    location VARCHAR(100) NOT NULL,
    total_seats INT NOT NULL CHECK (total_seats > 0),
    available_seats INT NOT NULL CHECK (available_seats >= 0),
    status ENUM('DRAFT', 'PUBLISHED', 'APPROVED', 'CANCELLED') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    image VARCHAR(255) NULL,

    user_email VARCHAR(100) NOT NULL,
    category_id INT NOT NULL,

    CONSTRAINT fk_event_user
        FOREIGN KEY (user_email)
        REFERENCES USER(email),

    CONSTRAINT fk_event_category
        FOREIGN KEY (category_id)
        REFERENCES CATEGORY(id)
);

-- =====================================
-- SUBSCRIPTION
-- =====================================
CREATE TABLE SUBSCRIPTION (
    subscription_id INT AUTO_INCREMENT PRIMARY KEY,
    user_email VARCHAR(100) NOT NULL,
    event_id INT NOT NULL,
    subscription_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    participation_code VARCHAR(20) NOT NULL UNIQUE,
    status ENUM('REGISTERED', 'PRESENT', 'ABSENT', 'CANCELLED') NOT NULL,
    checkin_time TIMESTAMP NULL,

    CONSTRAINT fk_subscription_user
        FOREIGN KEY (user_email)
        REFERENCES USER(email),

    CONSTRAINT fk_subscription_event
        FOREIGN KEY (event_id)
        REFERENCES EVENT(id),

    CONSTRAINT unique_subscription
        UNIQUE (user_email, event_id)
);
