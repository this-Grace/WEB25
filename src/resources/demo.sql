USE web25;

-- =========================
-- INSERT UNIVERSITIES
-- =========================
INSERT INTO universities (name, city) VALUES
('Università di Bologna', 'Bologna'),
('Politecnico di Milano', 'Milano');

-- =========================
-- INSERT FACULTIES
-- =========================
INSERT INTO faculties (name, degree_level, university_id) VALUES
('Ingegneria e scienze Informatiche', 'Triennale', 1),
('Economia', 'Triennale', 2),
('Architettura', 'Magistrale', 1);

-- =========================
-- INSERT USERS
-- =========================
INSERT INTO users (username, email, password_hash, first_name, surname, bio, avatar_url, course_id) VALUES
('alice','alice@example.com','$2y$10$hash1','Alice','Rossi','Cerco partner per progetto AI','/avatars/alice.png',1),
('bob','bob@example.com','$2y$10$hash2','Bob','Verdi','Studente di ingegneria civile','/avatars/bob.png',2),
('MarioRossi','mariorossi@gmail.com','$2y$12$C2FBQoX9yGH18351KZSsbekGdLR1ek6jvHq9rMrviBGs3vbQzbTp2','Mario','Rossi','Studente di ingegneria','/avatars/mario.png',2),
('admin_luca','admin@unimatch.it','$2y$10$hash_admin','Luca','Admin','Amministratore di sistema',NULL),
('dana','dana@example.com','$2y$10$hash4','Dana','Bianchi','Appassionata di UX Design',NULL,3);

-- =========================
-- INSERT ADMINS
-- =========================
INSERT INTO admins (username) VALUES
('admin_luca');

-- =========================
-- INSERT POSTS
-- =========================
INSERT INTO posts (user_username, title, content, num_collaborators, skills_required) VALUES
('alice','Progetto App Mobile','Cerco compagni per app React Native',3,'JavaScript, React, Firebase'),
('bob','Studio Gruppo Meccanica','Preparazione esame Meccanica Razionale',2,'Fisica, Calcolo'),
('dana','Restyling Sito Web','Progetto grafico per esame di Web Design',1,'Figma, CSS, Photoshop'),
('alice','Ricerca Collaboratori AI','Algoritmi di Machine Learning',2,'Python, Scikit-learn');

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
INSERT INTO conversations () VALUES (); -- id = 1

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
('bob',3,'dana','Contenuto offensivo','Pendente');
