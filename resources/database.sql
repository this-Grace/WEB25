DROP DATABASE IF EXISTS web25;
CREATE DATABASE web25;
USE web25;

-- =========================
-- USERS
-- =========================
CREATE TABLE users (
    username VARCHAR(50) PRIMARY KEY NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash TEXT NOT NULL,
    bio TEXT,
    avatar_url TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================
-- POSTS
-- =========================
CREATE TABLE posts (
    id SERIAL PRIMARY KEY,
    user_username VARCHAR(50) NOT NULL,
    caption TEXT,
    image_url TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_posts_user
        FOREIGN KEY (user_username)
        REFERENCES users(username)
        ON DELETE CASCADE
);

-- =========================
-- FOLLOWS (user -> user)
-- =========================
CREATE TABLE follows (
    follower_username VARCHAR(50) NOT NULL,
    following_username VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (follower_username, following_username),
    CONSTRAINT fk_follower
        FOREIGN KEY (follower_username)
        REFERENCES users(username)
        ON DELETE CASCADE,
    CONSTRAINT fk_following
        FOREIGN KEY (following_username)
        REFERENCES users(username)
        ON DELETE CASCADE,
    CONSTRAINT no_self_follow
        CHECK (follower_username <> following_username)
);

-- =========================
-- LIKES
-- =========================
CREATE TABLE likes (
    user_username VARCHAR(50) NOT NULL,
    post_id INTEGER NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_username, post_id),
    CONSTRAINT fk_likes_user
        FOREIGN KEY (user_username)
        REFERENCES users(username)
        ON DELETE CASCADE,
    CONSTRAINT fk_likes_post
        FOREIGN KEY (post_id)
        REFERENCES posts(id)
        ON DELETE CASCADE
);

-- =========================
-- COMMENTS
-- =========================
CREATE TABLE comments (
    id SERIAL PRIMARY KEY,
    post_id INTEGER NOT NULL,
    user_username VARCHAR(50) NOT NULL,
    text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_comments_post
        FOREIGN KEY (post_id)
        REFERENCES posts(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_comments_user
        FOREIGN KEY (user_username)
        REFERENCES users(username)
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
    conversation_id INTEGER NOT NULL,
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
    conversation_id INTEGER NOT NULL,
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
