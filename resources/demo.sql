USE web25;

-- =====================================
-- DEMO DATA FOR USERS
-- =====================================
INSERT INTO USERS (email, name, surname, password, role) VALUES
('mario.rossi@example.com', 'Mario', 'Rossi', '$2y$10$hashedpassword1', 'USER'),
('luisa.bianchi@example.com', 'Luisa', 'Bianchi', '$2y$10$hashedpassword2', 'USER'),
('giulia.verdi@example.com', 'Giulia', 'Verdi', '$2y$10$hashedpassword3', 'HOST'),
('paolo.neri@example.com', 'Paolo', 'Neri', '$2y$10$hashedpassword4', 'HOST'),
('admin@web25.com', 'Admin', 'System', '$2y$10$hashedpassword5', 'ADMINISTRATOR');

-- =====================================
-- CATEGORIE
-- =====================================
INSERT INTO CATEGORIES (name) VALUES
('Conferenze'),
('Workshop'),
('Seminari'),
('Sport'),
('Social');

-- =====================================
-- EVENTS 
-- =====================================
INSERT INTO EVENT (title, description, event_date, event_time, location, total_seats, available_seats, status, created_at, image, user_email, category_id) VALUES
('AI per Tutti', 'Introduzione alle applicazioni pratiche dell''IA per non esperti.', '2026-03-15', '10:00:00', 'Aula Magna', 200, 185, 'PUBLISHED', CURRENT_TIMESTAMP, 'img/ai_for_everyone.jpg', 'mario.rossi@example.com', 1),
('Workshop pratico di Cybersecurity', 'Esercizi pratici sulla sicurezza web e le difese.', '2026-03-20', '14:00:00', 'Laboratorio 3', 30, 5, 'PUBLISHED', CURRENT_TIMESTAMP, 'img/cybersec_workshop.png', 'luisa.bianchi@example.com', 2),
('Basi di Dati: progettazione e buone pratiche', 'Seminario su normalizzazione e progettazione ER.', '2026-04-02', '09:30:00', 'Aula B1', 100, 100, 'DRAFT', NULL, 'img/db_seminar.jpg', 'giulia.verdi@example.com', 3),
('Corsa Comunitaria', 'Corsa sociale di 5 km nel campus aperta a tutti i livelli.', '2026-04-10', '08:00:00', 'Parco del Campus', 150, 140, 'PUBLISHED', CURRENT_TIMESTAMP, 'img/community_run.jpg', 'paolo.neri@example.com', 4),
('Passeggiata Fotografica', 'Passeggiata guidata per migliorare le abilità nella fotografia outdoor.', '2026-04-18', '16:30:00', 'Centro Storico', 40, 12, 'PUBLISHED', CURRENT_TIMESTAMP, 'img/photo_walk.jpg', 'mario.rossi@example.com', 5),
('Serata Pitch Startup', 'Startup locali presentano le loro idee a mentori e investitori.', '2026-05-05', '18:00:00', 'Hub dell''Innovazione', 120, 85, 'PUBLISHED', CURRENT_TIMESTAMP, 'img/pitch_night.jpg', 'luisa.bianchi@example.com', 1),
('Gruppo di Studio ML Avanzato', 'Incontri settimanali per discutere articoli recenti e implementazioni.', '2026-05-12', '17:00:00', 'Aula 210', 25, 20, 'APPROVED', CURRENT_TIMESTAMP, 'img/ml_study.jpg', 'giulia.verdi@example.com', 1),
('Pulizia Volontaria della Spiaggia', 'Evento di volontariato per pulire la spiaggia locale.', '2026-06-01', '09:00:00', 'Spiaggia della Marina', 60, 60, 'PUBLISHED', CURRENT_TIMESTAMP, 'img/beach_cleanup.jpg', 'paolo.neri@example.com', 5),
('Incontro di Conversazione in Francese', 'Scambio linguistico informale per partecipanti di livello intermedio.', '2026-06-08', '19:30:00', 'Sala Caffetteria', 30, 18, 'PUBLISHED', CURRENT_TIMESTAMP, 'img/lang_meetup.jpg', 'mario.rossi@example.com', 5),
('Fiera Maker di Primavera', 'Esposizione di progetti studenteschi e dimostrazioni dei maker.', '2026-05-20', '11:00:00', 'Padiglione Espositivo', 300, 250, 'PUBLISHED', CURRENT_TIMESTAMP, 'img/maker_fair.jpg', 'admin@web25.com', 2);

-- -- =====================================
-- -- ISCRIZIONI
-- -- =====================================
-- INSERT INTO ISCRIZIONE (
--     id_utente, id_evento, codice_partecipazione, stato
-- ) VALUES
-- (3, 1, 'AI2026LUC', 'ISCRITTO'),
-- (4, 1, 'AI2026GIU', 'PRESENTE'),
-- (5, 1, 'AI2026PAO', 'ASSENTE'),
-- (3, 2, 'CYB2026LUC', 'PRESENTE'),
-- (4, 2, 'CYB2026GIU', 'ISCRITTO');

-- -- =====================================
-- -- ATTIVITÀ UTENTE
-- -- =====================================
-- INSERT INTO ATTIVITA_UTENTE (
--     id_utente, tipo_attivita, id_evento, descrizione
-- ) VALUES
-- (1, 'CREA_EVENTO', 1, 'Creazione evento AI'),
-- (1, 'PUBBLICA_EVENTO', 1, 'Pubblicazione evento AI'),
-- (2, 'CREA_EVENTO', 2, 'Creazione workshop cybersecurity'),
-- (3, 'ISCRIZIONE_EVENTO', 1, 'Iscrizione alla conferenza AI'),
-- (4, 'PARTECIPAZIONE_EVENTO', 1, 'Partecipazione conferenza AI'),
-- (3, 'PARTECIPAZIONE_EVENTO', 2, 'Partecipazione workshop cybersecurity');
