USE web25;

-- =========================
-- INSERT USERS
-- =========================
INSERT INTO users (username, email, password_hash, first_name, surname, bio, avatar_url, degree_course, role) VALUES
('alice','alice@example.com','$2y$10$hash1','Alice','Rossi','Cerco partner per progetto AI','/avatars/alice.png','Informatica','student'),
('bob','bob@example.com','$2y$10$hash2','Bob','Verdi','Studente di ingegneria civile','/avatars/bob.png','Ingegneria','student'),
('admin_luca','admin@unimatch.it','$2y$10$hash_admin','Luca','Admin','Amministratore di sistema',NULL,NULL,'admin'),
('dana','dana@example.com','$2y$10$hash4','Dana','Bianchi','Appassionata di UX Design',NULL,'Arte','student');

-- =========================
-- INSERT POSTS
-- =========================
INSERT INTO posts (user_username, title, content, degree_course, num_collaborators, skills_required) VALUES
('alice','Progetto App Mobile','Cerco compagni per app React Native','Informatica',3,'JavaScript, React, Firebase'),
('bob','Studio Gruppo Meccanica','Preparazione esame Meccanica Razionale','Ingegneria',2,'Fisica, Calcolo'),
('dana','Restyling Sito Web','Progetto grafico per esame di Web Design','Arte',1,'Figma, CSS, Photoshop'),
('alice','Ricerca Collaboratori AI','Algoritmi di Machine Learning','Informatica',2,'Python, Scikit-learn');

-- =========================
-- INSERT REACTIONS
-- =========================
INSERT INTO reactions (user_username, post_id, reaction_type) VALUES
('bob',1,'like'),
('dana',1,'like'),
('bob',4,'skip'),
('alice',2,'like');

-- =========================
-- INSERT CONVERSATIONS & PARTICIPANTS
-- =========================
INSERT INTO conversations () VALUES ();

INSERT INTO conversation_participants (conversation_id, user_username) VALUES
(1,'alice'),(1,'bob');

-- =========================
-- INSERT MESSAGES
-- =========================
INSERT INTO messages (conversation_id, sender_username, text, is_read) VALUES
(1,'alice','Ciao Bob, ho visto che ti interessa il mio progetto app!',TRUE),
(1,'bob','Ciao! Sì, conosco bene React, quando ci sentiamo?',FALSE);

-- =========================
-- INSERT REPORTS
-- =========================
INSERT INTO reports (reporter_username, reported_post_id, reported_username, reason, status) VALUES
('bob',3,'dana','Contenuto offensivo','Pendenti');
