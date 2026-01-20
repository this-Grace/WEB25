DROP DATABASE IF EXISTS web25;
CREATE DATABASE web25;
USE web25;

-- =========================
-- UNIVERSITIES AND FACULTIES
-- =========================
CREATE TABLE universities (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    city VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE faculties (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    degree_level ENUM('Triennale','Magistrale','Dottorato') DEFAULT 'Triennale',
    university_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_faculties_university
        FOREIGN KEY (university_id)
        REFERENCES universities(id)
        ON DELETE CASCADE
);

-- =========================
-- USERS
-- =========================
CREATE TABLE users (
    username VARCHAR(50) PRIMARY KEY NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash TEXT NOT NULL,
    first_name VARCHAR(50),
    surname VARCHAR(50),
    bio TEXT,
    avatar_url TEXT,
    faculty_id BIGINT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_users_course
        FOREIGN KEY (faculty_id)
        REFERENCES faculties(id)
        ON DELETE SET NULL  
);

-- =========================
-- ADMINS
-- =========================
CREATE TABLE admins (
    username VARCHAR(50) PRIMARY KEY,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_admins_user
        FOREIGN KEY (username)
        REFERENCES users(username)
        ON DELETE CASCADE
);

-- =========================
-- POSTS
-- =========================
CREATE TABLE posts (
    id SERIAL PRIMARY KEY,
    user_username VARCHAR(50) NOT NULL,
    title VARCHAR(255),
    content TEXT NOT NULL,
    status ENUM('Pendente', 'Approvato', 'Rifiutato') DEFAULT 'Pendente',
    num_collaborators INT DEFAULT 1,
    skills_required TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_posts_user
        FOREIGN KEY (user_username)
        REFERENCES users(username)
        ON DELETE CASCADE
);

-- =========================
-- REACTIONS
-- =========================
CREATE TABLE reactions (
    user_username VARCHAR(50) NOT NULL,
    post_id BIGINT UNSIGNED NOT NULL,
    reaction_type ENUM('like', 'skip') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_username, post_id),
    CONSTRAINT fk_reactions_user
        FOREIGN KEY (user_username)
        REFERENCES users(username)
        ON DELETE CASCADE,
    CONSTRAINT fk_reactions_post
        FOREIGN KEY (post_id)
        REFERENCES posts(id)
        ON DELETE CASCADE
);

-- =========================
-- CONVERSATIONS
-- =========================
CREATE TABLE conversations (
    id SERIAL PRIMARY KEY,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================
-- CONVERSATION PARTICIPANTS
-- =========================
CREATE TABLE conversation_participants (
    conversation_id BIGINT UNSIGNED NOT NULL,
    user_username VARCHAR(50) NOT NULL,
    PRIMARY KEY (conversation_id, user_username),
    CONSTRAINT fk_cp_conversation
        FOREIGN KEY (conversation_id)
        REFERENCES conversations(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_cp_user
        FOREIGN KEY (user_username)
        REFERENCES users(username)
        ON DELETE CASCADE
);

-- =========================
-- MESSAGES
-- =========================
CREATE TABLE messages (
    id SERIAL PRIMARY KEY,
    conversation_id BIGINT UNSIGNED NOT NULL,
    sender_username VARCHAR(50) NOT NULL,
    text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_read BOOLEAN DEFAULT FALSE,
    CONSTRAINT fk_messages_conversation
        FOREIGN KEY (conversation_id)
        REFERENCES conversations(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_messages_sender
        FOREIGN KEY (sender_username)
        REFERENCES users(username)
        ON DELETE CASCADE
);

-- =========================
-- REPORTS
-- =========================
CREATE TABLE reports (
    id SERIAL PRIMARY KEY,
    reporter_username VARCHAR(50) NOT NULL,
    reported_post_id BIGINT UNSIGNED NOT NULL,
    reported_username VARCHAR(50) NOT NULL,
    reason ENUM(
        'Comportamento inappropriato',
        'Contenuto offensivo',
        'Spam',
        'Frode',
        'Altro'
    ) NOT NULL,
    description TEXT,
    status ENUM('Pendente', 'In revisione', 'Risolte', 'Rigettate', 'Bloccato') DEFAULT 'Pendente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_reports_reporter
        FOREIGN KEY (reporter_username)
        REFERENCES users(username)
        ON DELETE CASCADE,
    CONSTRAINT fk_reports_post
        FOREIGN KEY (reported_post_id)
        REFERENCES posts(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_reports_user
        FOREIGN KEY (reported_username)
        REFERENCES users(username)
        ON DELETE CASCADE
);
