USE web25;

-- =========================
-- USERS
-- =========================
INSERT INTO users (username, email, password_hash, first_name, surname, bio, avatar_url, degree_course) VALUES
('alice','alice@example.com','$2b$hash1','Alice','Rossi','Hi, sono Alice','/avatars/alice.png', 'Informatica'),
('bob','bob@example.com','$2b$hash2','Bob','Verdi','Ciao, Bob qui','/avatars/bob.png', 'Ingegneria'),
('carlo','carlo@example.com','$2b$hash3',NULL,NULL,NULL,NULL, 'Matematica'),
('dana','dana@example.com','$2b$hash4','Dana','Bianchi','Appassionata di fotografia',NULL, 'Arte');

-- =========================
-- POSTS
-- =========================
INSERT INTO posts (id, user_username, title, content) VALUES
(1,'alice','Buongiorno a tutti!','Buongiorno a tutti!'),
(2,'bob','Ho appena finito il progetto.','Ho appena finito il progetto.'),
(3,'dana','Racconto del mio ultimo viaggio.','Racconto del mio ultimo viaggio.'),
(4,'alice','Un piccolo aggiornamento sul lavoro.','Un piccolo aggiornamento sul lavoro.');

-- =========================
-- REACTIONS (like / skip)
-- =========================
INSERT INTO reactions (user_username, post_id, reaction_type) VALUES
('bob',1,'like'),
('carlo',1,'like'),
('alice',2,'like'),
('dana',4,'like'),
('carlo',2,'skip');

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

-- =========================
-- REPORTS
-- =========================
INSERT INTO reports (reporter_username, reported_username, reason, status, created_at) VALUES
('mrossi', 'lfermi', 'Comportamento inappropriato', 'In revisione', '2025-12-28 10:00:00'),
('cbianchi', 1, 'Contenuto offensivo', 'Bloccato', '2025-12-27 15:30:00'),
('aconti', 'dana', 'Spam', 'Risolte', '2025-12-25 09:15:00');
