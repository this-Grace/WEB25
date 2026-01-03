USE web25;

-- =========================
-- USERS
-- =========================
INSERT INTO users (username, email, password_hash, first_name, surname, bio, avatar_url, degree_course, role) VALUES
('alice','alice@example.com','$2b$hash1','Alice','Rossi','Cerco partner per progetto AI','/avatars/alice.png', 'Informatica', 'student'),
('bob','bob@example.com','$2b$hash2','Bob','Verdi','Studente di ingegneria civile','/avatars/bob.png', 'Ingegneria', 'student'),
('admin_luca','admin@unimatch.it','$2b$hash_admin','Luca','Admin','Amministratore di sistema',NULL, NULL, 'admin'),
('dana','dana@example.com','$2b$hash4','Dana','Bianchi','Appassionata di UX Design',NULL, 'Arte', 'student');

-- =========================
-- POSTS
-- =========================
INSERT INTO posts (id, user_username, title, content, degree_course, num_collaborators, skills_required) VALUES
(1,'alice','Progetto App Mobile','Cerco compagni per app React Native','Informatica', 3, 'JavaScript, React, Firebase'),
(2,'bob','Studio Gruppo Meccanica','Preparazione esame Meccanica Razionale','Ingegneria', 2, 'Fisica, Calcolo'),
(3,'dana','Restyling Sito Web','Progetto grafico per esame di Web Design','Arte', 1, 'Figma, CSS, Photoshop'),
(4,'alice','Ricerca Collaboratori AI','Algoritmi di Machine Learning','Informatica', 2, 'Python, Scikit-learn');

-- =========================
-- REACTIONS (like / skip)
-- =========================
INSERT INTO reactions (user_username, post_id, reaction_type) VALUES
('bob', 1, 'like'),
('dana', 1, 'like'),
('bob', 4, 'skip'),
('alice', 2, 'like');

-- =========================
-- CONVERSATIONS & PARTICIPANTS
-- =========================
INSERT INTO conversations (id) VALUES (1);

INSERT INTO conversation_participants (conversation_id, user_username) VALUES
(1,'alice'), (1,'bob');

-- =========================
-- MESSAGES
-- =========================
INSERT INTO messages (conversation_id, sender_username, text, is_read) VALUES
(1,'alice','Ciao Bob, ho visto che ti interessa il mio progetto app!', TRUE),
(1,'bob','Ciao! Sì, conosco bene React, quando ci sentiamo?', FALSE);

-- =========================
-- REPORTS
-- =========================
INSERT INTO reports (reporter_username, reported_post_id, reported_username, reason, status) VALUES
('bob', 3, 'dana', 'Contenuto offensivo', 'Pendenti');
