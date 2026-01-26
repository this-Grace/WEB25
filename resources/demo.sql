USE web25;

-- =====================================
-- USER
-- =====================================
INSERT INTO `USER` (email, name, surname, password, role) VALUES
('mario.rossi@example.com', 'Mario', 'Rossi', '$2y$12$B4gnmTKlRqJyGy1UYSGuIug7Vj3O7FwaRs.VeLY6PN3.SK.KkGSaa', 'USER'),
('luisa.bianchi@example.com', 'Luisa', 'Bianchi', '$2y$12$B4gnmTKlRqJyGy1UYSGuIug7Vj3O7FwaRs.VeLY6PN3.SK.KkGSaa', 'USER'),
('giulia.verdi@example.com', 'Giulia', 'Verdi', '$2y$12$B4gnmTKlRqJyGy1UYSGuIug7Vj3O7FwaRs.VeLY6PN3.SK.KkGSaa', 'HOST'),
('paolo.neri@example.com', 'Paolo', 'Neri', '$2y$12$B4gnmTKlRqJyGy1UYSGuIug7Vj3O7FwaRs.VeLY6PN3.SK.KkGSaa', 'HOST'),
('admin@web25.com', 'Admin', 'System', '$2y$12$B4gnmTKlRqJyGy1UYSGuIug7Vj3O7FwaRs.VeLY6PN3.SK.KkGSaa', 'ADMIN');

-- =====================================
-- CATEGORY
-- =====================================
INSERT INTO `CATEGORY` (name) VALUES
('Conferenze'),
('Workshop'),
('Seminari'),
('Sport'),
('Social');

-- =====================================
-- EVENTS 
-- =====================================
INSERT INTO `EVENT` (title, description, event_date, event_time, location, total_seats, occupied_seats, status, created_at, image, user_id, category_id) VALUES
('AI per Tutti', 'Introduzione alle applicazioni pratiche dell''IA per non esperti.', '2026-03-15', '10:00:00', 'Aula Magna - Edificio A', 200, 15, 'APPROVED', CURRENT_TIMESTAMP, 'photo1.jpeg', 3, 1),
('Workshop pratico di Cybersecurity', 'Esercizi pratici sulla sicurezza web e le difese.', '2026-03-20', '14:00:00', 'Laboratorio 3 - Edificio B', 30, 25, 'WAITING', CURRENT_TIMESTAMP, 'photo3.jpeg', 4, 2),
('Basi di Dati: progettazione e buone pratiche', 'Seminario su normalizzazione e progettazione ER.', '2026-04-02', '09:30:00', 'Aula B1 - Edificio B', 100, 0, 'DRAFT', NULL, 'photo3.jpeg', 3, 3),
('Corsa Comunitaria', 'Corsa sociale di 5 km nel campus aperta a tutti i livelli.', '2026-01-30', '08:00:00', 'Parco del Campus - Edificio B', 150, 10, 'APPROVED', CURRENT_TIMESTAMP, 'photo2.jpeg', 4, 4),
('Passeggiata Fotografica', 'Passeggiata guidata per migliorare le abilità nella fotografia outdoor.', '2026-04-18', '16:30:00', 'Centro Storico - Edificio B', 40, 28, 'WAITING', CURRENT_TIMESTAMP, 'photo1.jpeg', 3, 5),
('Serata Pitch Startup', 'Startup locali presentano le loro idee a mentori e investitori.', '2026-05-05', '18:00:00', 'Hub dell''Innovazione - Edificio B', 120, 35, 'WAITING', CURRENT_TIMESTAMP, 'photo1.jpeg', 4, 1),
('Gruppo di Studio ML Avanzato', 'Incontri settimanali per discutere articoli recenti e implementazioni.', '2026-05-12', '17:00:00', 'Aula 210 - Edificio B', 25, 5, 'APPROVED', CURRENT_TIMESTAMP, 'photo2.jpeg', 3, 1),
('Pulizia Volontaria della Spiaggia', 'Evento di volontariato per pulire la spiaggia locale.', '2026-06-01', '09:00:00', 'Spiaggia della Marina - Edificio B', 60, 0, 'WAITING', CURRENT_TIMESTAMP, 'photo1.jpeg', 4, 5),
('Incontro di Conversazione in Francese', 'Scambio linguistico informale per partecipanti di livello intermedio.', '2025-06-08', '19:30:00', 'Sala Caffetteria - Edificio B', 30, 29, 'APPROVED', CURRENT_TIMESTAMP, 'photo1.jpeg', 3, 5),
('Fiera Maker di Primavera', 'Esposizione di progetti studenteschi e dimostrazioni dei maker.', '2026-05-20', '11:00:00', 'Padiglione Espositivo - Edificio B', 300, 299, 'APPROVED', CURRENT_TIMESTAMP, 'photo3.jpeg', 4, 2),
('Prova', 'prova', '2026-05-20', '11:00:00', 'Padiglione Espositivo - Edificio B', 300, 299, 'APPROVED', CURRENT_TIMESTAMP, 'photo3.jpeg', 3, 4);

-- =====================================
-- SUBSCRIPTION
-- =====================================
INSERT INTO `SUBSCRIPTION` (user_id, event_id, participation_code, status, checkin_time) VALUES
(1, 1, 'SUB1001', 'REGISTERED', NULL),
(2, 1, 'SUB1002', 'REGISTERED', NULL),
(3, 1, 'SUB1003', 'CANCELLED', NULL),
(4, 4, 'SUB1004', 'PRESENT', '2026-04-10 08:05:00'),
(1, 5, 'SUB1005', 'REGISTERED', NULL),
(2, 2, 'SUB1006', 'PRESENT', '2026-03-20 14:10:00'),
(3, 3, 'SUB1007', 'REGISTERED', NULL),
(4, 8, 'SUB1009', 'REGISTERED', NULL),
(1, 9, 'SUB1010', 'PRESENT', '2026-06-08 19:35:00'),
(2, 7, 'SUB1011', 'PRESENT', '2026-05-12 17:05:00'),
(3, 7, 'SUB1012', 'REGISTERED', NULL),
(5, 10, 'SUB1013', 'PRESENT', '2026-05-20 11:05:00'),
(2, 4, 'SUB1014', 'CANCELLED', NULL);
