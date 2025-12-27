USE web25;

-- =========================
-- USERS
-- =========================
INSERT INTO users (username, email, password_hash, bio, avatar_url) VALUES
('alice','alice@example.com','$2b$hash1','Hi, sono Alice','/avatars/alice.png'),
('bob','bob@example.com','$2b$hash2','Ciao, Bob qui','/avatars/bob.png'),
('carlo','carlo@example.com','$2b$hash3',NULL,NULL),
('dana','dana@example.com','$2b$hash4','Appassionata di fotografia',NULL);

-- =========================
-- POSTS
-- =========================
INSERT INTO posts (id, user_username, content) VALUES
(1,'alice','Buongiorno a tutti!'),
(2,'bob','Ho appena finito il progetto.'),
(3,'dana','Racconto del mio ultimo viaggio.'),
(4,'alice','Un piccolo aggiornamento sul lavoro.');

-- =========================
-- FOLLOWS
-- =========================
INSERT INTO follows (follower_username, following_username) VALUES
('bob','alice'),
('carlo','alice'),
('alice','dana');

-- =========================
-- LIKES
-- =========================
INSERT INTO likes (user_username, post_id) VALUES
('bob',1),
('carlo',1),
('alice',2),
('dana',4);

-- =========================
-- COMMENTS
-- =========================
INSERT INTO comments (post_id, user_username, text) VALUES
(1,'bob','Bellissimo!'),
(1,'carlo','Complimenti!'),
(2,'alice','Ottimo lavoro'),
(3,'alice','Che belle foto!');

-- =========================
-- CONVERSATIONS & PARTICIPANTS
-- =========================
INSERT INTO conversations (id) VALUES (1),(2);

INSERT INTO conversation_participants (conversation_id, user_username) VALUES
(1,'alice'),(1,'bob'),
(2,'dana'),(2,'carlo');

-- =========================
-- MESSAGES
-- =========================
INSERT INTO messages (id, conversation_id, sender_username, text, is_read) VALUES
(1,1,'alice','Ciao Bob, come va?',TRUE),
(2,1,'bob','Tutto bene, grazie! E tu?',FALSE),
(3,2,'dana','Sei pronto per domani?',FALSE),
(4,2,'carlo','Sì, tutto confermato.',FALSE);
