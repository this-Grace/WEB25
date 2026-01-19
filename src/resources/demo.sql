USE web25;

-- =========================
-- INSERT UNIVERSITIES
-- =========================
INSERT INTO universities (name, city) VALUES
('Università di Bologna', 'Bologna'),
('Politecnico di Milano', 'Milano'),
('Università di Padova', 'Padova');

-- =========================
-- INSERT FACULTIES
-- =========================
INSERT INTO faculties (name, degree_level, university_id) VALUES
('Ingegneria e scienze Informatiche', 'Triennale', 1),
('Economia', 'Triennale', 2),
('Architettura', 'Magistrale', 1),
('Matematica', 'Triennale', 3),
('Fisica', 'Magistrale', 2);

-- =========================
-- INSERT USERS
-- Password: 12345678 per tutti gli utenti normali
-- Password: administrator per admin
-- =========================
INSERT INTO users (username, email, password_hash, first_name, surname, bio, avatar_url, faculty_id) VALUES
('user1','user1@example.com','$2y$10$tZL9VfXNZqGfXqNPyXZ3jO9kK5fN5ZJ5J5J5J5J5J5J5J5J5J5J5a','Marco','Bianchi','Studente appassionato di programmazione','/avatars/user1.png',1),
('user2','user2@example.com','$2y$10$tZL9VfXNZqGfXqNPyXZ3jO9kK5fN5ZJ5J5J5J5J5J5J5J5J5J5J5a','Laura','Verdi','Amante della matematica e fisica','/avatars/user2.png',4),
('user3','user3@example.com','$2y$10$tZL9VfXNZqGfXqNPyXZ3jO9kK5fN5ZJ5J5J5J5J5J5J5J5J5J5J5a','Andrea','Rossi','Designer e sviluppatore','/avatars/user3.png',3),
('user','user@example.com','$2y$10$tZL9VfXNZqGfXqNPyXZ3jO9kK5fN5ZJ5J5J5J5J5J5J5J5J5J5J5a','Utente','Test','Account di test','/avatars/user.png',2),
('admin','admin@unimatch.it','$2y$10$rZL9VfXNZqGfXqNPyXZ3jO9kK5fN5ZJ5J5J5J5J5J5J5J5J5J5adm','Admin','Sistema','Amministratore della piattaforma','/avatars/admin.png',NULL);

-- =========================
-- INSERT ADMINS
-- =========================
INSERT INTO admins (username) VALUES
('admin');

-- =========================
-- INSERT POSTS
-- 3 post approvati per user1, user2, user3
-- =========================
INSERT INTO posts (user_username, title, content, status, num_collaborators, skills_required) VALUES
-- Post di user1
('user1','Sviluppo App Mobile per Tesi','Cerco collaboratori per sviluppare un\'app mobile in React Native per il progetto di tesi','Approvato',2,'React Native, JavaScript, Firebase'),
('user1','Progetto Machine Learning','Implementazione algoritmi ML per analisi dati','Approvato',1,'Python, TensorFlow, Pandas'),
('user1','Sito Web E-commerce','Creazione piattaforma e-commerce completa','Approvato',3,'PHP, MySQL, Bootstrap'),

-- Post di user2
('user2','Studio Gruppo Analisi Matematica','Preparazione esame con esercizi e teoria','Approvato',2,'Matematica, Calcolo'),
('user2','Ricerca Tesina Fisica Quantistica','Collaborazione per ricerca e stesura tesina','Approvato',1,'Fisica, LaTeX'),
('user2','Tutoraggio Matematica','Aiuto compagni in difficoltà con la matematica','Approvato',4,'Matematica, Statistica'),

-- Post di user3
('user3','Design Sistema UI/UX','Progetto completo di interfaccia utente moderna','Approvato',2,'Figma, Adobe XD, CSS'),
('user3','Ristrutturazione Portfolio','Rifacimento portfolio personale con animazioni','Approvato',1,'HTML, CSS, JavaScript, GSAP'),
('user3','Branding Startup','Creazione identità visiva per startup innovativa','Approvato',2,'Illustrator, Photoshop, Branding');

-- =========================
-- INSERT REACTIONS
-- =========================
INSERT INTO reactions (user_username, post_id, reaction_type) VALUES
('user2',1,'like'),
('user3',1,'like'),
('user','1','like'),
('user1',4,'like'),
('user3',4,'like'),
('user1',7,'like'),
('user2',7,'like');

-- =========================
-- INSERT CONVERSATIONS & PARTICIPANTS
-- =========================
INSERT INTO conversations () VALUES (),();

INSERT INTO conversation_participants (conversation_id, user_username) VALUES
(1,'user1'),(1,'user2'),
(2,'user2'),(2,'user3');

-- =========================
-- INSERT MESSAGES
-- =========================
INSERT INTO messages (conversation_id, sender_username, text, is_read) VALUES
(1,'user1','Ciao Laura! Visto che ti interessa il mio progetto ML, vuoi collaborare?',TRUE),
(1,'user2','Ciao Marco! Sì, mi piacerebbe molto. Quando possiamo sentirci?',FALSE),
(2,'user2','Andrea, ho visto il tuo progetto di design, è fantastico!',TRUE),
(2,'user3','Grazie Laura! Se vuoi possiamo lavorare insieme sul prossimo progetto',TRUE);

-- =========================
-- INSERT REPORTS
-- =========================
INSERT INTO reports (reporter_username, reported_post_id, reported_username, reason, status) VALUES
('user','2','user1','Spam','Pendente');
