
USE web25;

INSERT INTO universities (name, code, city) VALUES
('Università di Bologna', 'unibo', 'Bologna'),
('Università di Milano', 'unimi', 'Milano'),
('Sapienza Università di Roma', 'uniroma', 'Roma'),
('Università di Padova', 'unipd', 'Padova'),
('Università di Firenze', 'unifi', 'Firenze'),
('Politecnico di Milano', 'polimi', 'Milano'),
('Politecnico di Torino', 'polito', 'Torino'),
('Università di Napoli Federico II', 'unina', 'Napoli'),
('Università di Pisa', 'unipi', 'Pisa'),
('Università Cattolica del Sacro Cuore', 'unicatt', 'Milano');

INSERT INTO users (name, surname, email, password_hash, university_id, bio, skills, interests, role, status, email_verified) VALUES
('Admin', 'UniMatch', 'admin@unimatch.it', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, 'Amministratore della piattaforma', 'Gestione, Moderazione', 'Community Management', 'admin', 'active', TRUE),
('Giulia', 'Rossi', 'giulia.rossi@unibo.it', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, 'Studentessa di Informatica appassionata di web development e UX design', 'HTML, CSS, JavaScript, React, Figma', 'Web Development, Design, Gaming', 'user', 'active', TRUE),
('Luca', 'Bianchi', 'luca.bianchi@polimi.it', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 6, 'Ingegnere Informatico con passione per l\'AI e il machine learning', 'Python, TensorFlow, PyTorch, Java', 'AI, Machine Learning, Data Science', 'user', 'active', TRUE),
('Sara', 'Verdi', 'sara.verdi@uniroma.it', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 3, 'Studentessa di Economia interessata a fintech e blockchain', 'Excel, SQL, Python, Blockchain basics', 'Fintech, Economia, Blockchain', 'user', 'active', TRUE),
('Marco', 'Neri', 'marco.neri@unipd.it', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 4, 'Sviluppatore mobile appassionato di iOS e Android', 'Swift, Kotlin, Flutter, Firebase', 'Mobile Development, Gaming, Tech', 'user', 'suspended', TRUE),
('Anna', 'Blu', 'anna.blu@unimi.it', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2, 'Designer con focus su UI/UX e product design', 'Figma, Adobe XD, Illustrator, Photoshop', 'Design, Art, Photography', 'user', 'active', TRUE),
('Federico', 'Gialli', 'federico.gialli@unifi.it', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 5, 'Studente di Ingegneria Gestionale interessato a startup e innovazione', 'Project Management, Business Analysis, Excel', 'Startup, Business, Innovation', 'user', 'active', TRUE),
('Chiara', 'Viola', 'chiara.viola@polito.it', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 7, 'Backend developer con esperienza in microservizi', 'Java, Spring Boot, Docker, Kubernetes', 'Backend, DevOps, Cloud', 'user', 'active', TRUE),
('Paolo', 'Marroni', 'paolo.marroni@unina.it', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 8, 'Data scientist appassionato di analytics e visualizzazione dati', 'Python, R, Tableau, Power BI', 'Data Science, Analytics, Statistics', 'user', 'active', TRUE),
('Laura', 'Arancio', 'laura.arancio@unipi.it', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 9, 'Full-stack developer con passione per le progressive web app', 'JavaScript, Node.js, Vue.js, MongoDB', 'Full-stack, PWA, Open Source', 'user', 'active', TRUE),
('Roberto', 'Grigio', 'roberto.grigio@unicatt.it', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 10, 'Studente di Comunicazione interessato a social media marketing', 'Social Media, Content Creation, SEO', 'Marketing, Communication, Social Media', 'user', 'active', TRUE);

INSERT INTO posts (user_id, title, description, project_type, skills_needed, deadline, team_size, status) VALUES
(2, 'Sviluppo Piattaforma E-learning', 'Cerco collaboratori per sviluppare una piattaforma e-learning innovativa con focus su gamification. Il progetto prevede sviluppo frontend, backend e integrazione AI.', 'Web Application', 'React, Node.js, AI/ML', '2026-06-30', 4, 'published'),
(3, 'App Mobile per il Fitness', 'Progetto di app mobile per tracking allenamenti con social features. Serve designer UX/UI e sviluppatore mobile.', 'Mobile App', 'Flutter, UI/UX Design, Firebase', '2026-05-15', 3, 'published'),
(4, 'Analisi Blockchain per Fintech', 'Ricerca e sviluppo di soluzioni blockchain per il settore finanziario. Cerco programmatori e analisti.', 'Research Project', 'Blockchain, Solidity, Python', '2026-07-20', 2, 'published'),
(6, 'Startup Tech - Marketplace Studenti', 'Sviluppo marketplace per studenti universitari. Team multidisciplinare cercasi!', 'Startup', 'Full-stack, Business, Marketing', '2026-08-31', 5, 'published'),
(7, 'Sistema di Gestione Eventi Universitari', 'Piattaforma web per organizzazione e gestione eventi universitari con sistema di ticketing.', 'Web Application', 'Vue.js, Spring Boot, MySQL', '2026-06-15', 3, 'published'),
(8, 'Dashboard Analytics Real-time', 'Sviluppo dashboard per visualizzazione dati in tempo reale con microservizi.', 'Web Application', 'React, Microservices, Docker', '2026-05-30', 4, 'published'),
(9, 'AI Chatbot per Supporto Studenti', 'Chatbot intelligente per assistenza studenti con integrazione NLP.', 'AI Project', 'Python, TensorFlow, NLP', '2026-07-10', 2, 'published'),
(10, 'Progressive Web App per Food Delivery', 'PWA per delivery cibo con focus su performance e offline capability.', 'Mobile/Web', 'JavaScript, PWA, Service Workers', '2026-06-20', 3, 'published'),
(2, 'Piattaforma Crowdfunding Universitario', 'Sistema di crowdfunding dedicato a progetti universitari e ricerca.', 'Web Application', 'Full-stack, Payment Integration', '2026-09-01', 4, 'published'),
(5, 'Post con contenuto inappropriato', 'Questo è un post di test che contiene contenuto inappropriato da segnalare.', 'Test', 'None', '2026-12-31', 1, 'hidden');

INSERT INTO likes (user_id, post_id) VALUES
(2, 3), (2, 4), (2, 6),
(3, 1), (3, 5), (3, 7),
(4, 2), (4, 6), (4, 8),
(5, 1), (5, 3), (5, 9),
(6, 2), (6, 4), (6, 7),
(7, 1), (7, 5), (7, 8),
(8, 3), (8, 6), (8, 9),
(9, 1), (9, 4), (9, 7),
(10, 2), (10, 5), (10, 8);

INSERT INTO skips (user_id, post_id) VALUES
(2, 2), (2, 5), (2, 7),
(3, 2), (3, 6), (3, 8),
(4, 1), (4, 3), (4, 5),
(5, 2), (5, 4), (5, 6),
(6, 1), (6, 3), (6, 5),
(7, 2), (7, 4), (7, 6),
(8, 1), (8, 2), (8, 5),
(9, 2), (9, 3), (9, 6),
(10, 1), (10, 4), (10, 7);

INSERT INTO matches (post_id, post_owner_id, matched_user_id) VALUES
(1, 2, 3),
(1, 2, 5),
(2, 3, 4),
(3, 4, 2),
(4, 6, 2),
(5, 7, 3),
(6, 8, 2),
(7, 9, 3);

INSERT INTO conversations (match_id, last_message_at) VALUES
(1, '2026-01-06 15:30:00'),
(2, '2026-01-06 14:20:00'),
(3, '2026-01-05 18:45:00'),
(4, '2026-01-05 12:10:00'),
(5, '2026-01-04 09:30:00');

INSERT INTO messages (conversation_id, sender_id, message, is_read) VALUES
(1, 3, 'Ciao! Sono molto interessata al progetto e-learning. Ho esperienza con React.', TRUE),
(1, 2, 'Ottimo! Quando possiamo fare una call per discuterne?', TRUE),
(1, 3, 'Che ne dici di domani pomeriggio?', FALSE),
(2, 5, 'Salve, ho visto il tuo progetto e mi piacerebbe contribuire!', TRUE),
(2, 2, 'Benvenuto! Che competenze hai?', TRUE),
(2, 5, 'Sono specializzato in Node.js e database.', FALSE),
(3, 4, 'Interessato all\'app fitness. Ho esperienza con Flutter.', TRUE),
(3, 3, 'Perfetto! Cerchiamo proprio qualcuno con le tue skill.', TRUE),
(4, 2, 'Il tuo progetto blockchain sembra molto interessante!', TRUE),
(4, 4, 'Grazie! Hai esperienza con Solidity?', FALSE),
(5, 2, 'Ciao! Vorrei saperne di più sul marketplace studenti.', TRUE),
(5, 6, 'Ciao! È un progetto ambizioso. Ti va di unirti?', TRUE),
(5, 2, 'Assolutamente sì! Quando ci vediamo?', FALSE);

INSERT INTO reports (reporter_id, reported_user_id, post_id, reason, description, status) VALUES
(2, 5, 10, 'inappropriate_content', 'Il post contiene linguaggio offensivo e contenuti non adatti alla piattaforma.', 'open'),
(3, 5, 10, 'spam', 'Post ripetitivo e non pertinente.', 'open'),
(6, 11, NULL, 'harassment', 'L\'utente ha inviato messaggi inappropriati in chat.', 'in_review'),
(7, 5, 10, 'inappropriate_content', 'Contenuto non appropriato per una piattaforma universitaria.', 'resolved'),
(8, 11, NULL, 'other', 'Comportamento sospetto dell\'utente.', 'dismissed');

INSERT INTO password_reset_tokens (user_id, token, expires_at) VALUES
(3, 'abc123def456ghi789jkl012mno345pqr678stu901vwx234', '2026-01-21 23:59:59'),
(5, 'xyz987wvu654tsr321qpo098nml765kji432hgf109edc876', '2025-12-31 23:59:59'),
(7, 'token123valid456reset789password012unique345string678', '2026-02-01 23:59:59');
