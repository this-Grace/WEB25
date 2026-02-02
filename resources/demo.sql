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
('AI per Tutti', 'Introduzione alle applicazioni pratiche dell''IA per non esperti.', '2026-03-15', '10:00:00', 'Aula Magna - Edificio A', 200, 0, 'APPROVED', CURRENT_TIMESTAMP, 'photo1.jpeg', 3, 1),
('Workshop pratico di Cybersecurity', 'Esercizi pratici sulla sicurezza web e le difese.', '2026-03-20', '14:00:00', 'Laboratorio 3 - Edificio B', 30, 0, 'WAITING', CURRENT_TIMESTAMP, 'photo3.jpeg', 4, 2),
('Basi di Dati: progettazione e buone pratiche', 'Seminario su normalizzazione e progettazione ER.', '2026-04-02', '09:30:00', 'Aula B1 - Edificio B', 100, 0, 'DRAFT', NULL, 'photo3.jpeg', 3, 3),
('Corsa Comunitaria', 'Corsa sociale di 5 km nel campus aperta a tutti i livelli.', '2026-01-30', '08:00:00', 'Parco del Campus - Edificio B', 150, 0, 'APPROVED', CURRENT_TIMESTAMP, 'photo2.jpeg', 4, 4),
('Passeggiata Fotografica', 'Passeggiata guidata per migliorare le abilità nella fotografia outdoor.', '2026-04-18', '16:30:00', 'Centro Storico - Edificio B', 40, 0, 'WAITING', CURRENT_TIMESTAMP, 'photo1.jpeg', 3, 5),
('Serata Pitch Startup', 'Startup locali presentano le loro idee a mentori e investitori.', '2026-05-05', '18:00:00', 'Hub dell''Innovazione - Edificio B', 120, 0, 'WAITING', CURRENT_TIMESTAMP, 'photo1.jpeg', 4, 1),
('Gruppo di Studio ML Avanzato', 'Incontri settimanali per discutere articoli recenti e implementazioni.', '2026-05-12', '17:00:00', 'Aula 210 - Edificio B', 25, 0, 'APPROVED', CURRENT_TIMESTAMP, 'photo2.jpeg', 3, 1),
('Pulizia Volontaria della Spiaggia', 'Evento di volontariato per pulire la spiaggia locale.', '2026-06-01', '09:00:00', 'Spiaggia della Marina - Edificio B', 60, 0, 'WAITING', CURRENT_TIMESTAMP, 'photo1.jpeg', 4, 5),
('Incontro di Conversazione in Francese', 'Scambio linguistico informale per partecipanti di livello intermedio.', '2025-06-08', '19:30:00', 'Sala Caffetteria - Edificio B', 30, 0, 'APPROVED', CURRENT_TIMESTAMP, 'photo1.jpeg', 3, 5),
('Fiera Maker di Primavera', 'Esposizione di progetti studenteschi e dimostrazioni dei maker.', '2026-05-20', '11:00:00', 'Padiglione Espositivo - Edificio B', 300, 0, 'APPROVED', CURRENT_TIMESTAMP, 'photo3.jpeg', 4, 2),
('Hackathon GreenTech', 'Evento intensivo di sviluppo di soluzioni ecologiche e prototipi funzionanti.', '2026-07-10', '09:00:00', 'Laboratorio Innovazione - Edificio C', 120, 0, 'WAITING', CURRENT_TIMESTAMP, 'photo2.jpeg', 3, 2),
('Seminario UX Design', 'Best practices per progettare interfacce utente intuitive e accessibili.', '2026-06-25', '14:30:00', 'Aula C2 - Edificio A', 60, 0, 'APPROVED', CURRENT_TIMESTAMP, 'photo1.jpeg', 4, 3),
('Torneo di Calcio a 5', 'Torneo amatoriale aperto a squadre miste. Iscrizione a squadre di massimo 8 giocatori.', '2026-07-03', '18:00:00', 'Campo Sportivo - Edificio D', 80, 0, 'APPROVED', CURRENT_TIMESTAMP, 'photo2.jpeg', 4, 4),
('Cena Sociale Internazionale', 'Serata conviviale con piatti tipici e scambio culturale.', '2026-06-14', '20:00:00', 'Sala Eventi - Edificio A', 100, 0, 'WAITING', CURRENT_TIMESTAMP, 'photo1.jpeg', 3, 5),
('Laboratorio di Fotografia Notturna', 'Tecniche pratiche per fotografare in condizioni di scarsa luce e post-produzione.', '2026-08-19', '21:00:00', 'Piazza Centrale - Edificio B', 30, 0, 'DRAFT', NULL, 'photo3.jpeg', 3, 5),
('Conferenza Blockchain e Privacy', 'Impatto delle tecnologie distribuite sulla privacy e casi d''uso reali.', '2026-09-01', '10:00:00', 'Auditorium - Edificio A', 200, 0, 'APPROVED', CURRENT_TIMESTAMP, 'photo3.jpeg', 4, 1),
('Laboratorio Python per Data Science', 'Esercitazioni pratiche su pandas, numpy e visualizzazione.', '2026-03-22', '09:00:00', 'Lab Data - Edificio C', 40, 0, 'APPROVED', CURRENT_TIMESTAMP, 'photo2.jpeg', 3, 3),
('Seminario Energie Rinnovabili', 'Panoramica sulle tecnologie fotovoltaiche e eoliche.', '2026-04-10', '11:00:00', 'Aula Magna - Edificio A', 150, 0, 'WAITING', CURRENT_TIMESTAMP, 'photo1.jpeg', 4, 1),
('Corso Base di HTML & CSS', 'Introduzione allo sviluppo web per principianti.', '2026-02-14', '15:00:00', 'Aula Web - Edificio B', 50, 0, 'APPROVED', CURRENT_TIMESTAMP, 'photo3.jpeg', 3, 2),
('Tavola Rotonda: Smart Cities', 'Discussione su urbanistica, IoT e mobilità sostenibile.', '2026-05-28', '16:00:00', 'Sala Conferenze - Edificio A', 120, 0, 'WAITING', CURRENT_TIMESTAMP, 'photo2.jpeg', 4, 1),
('Meeting Volontariato Alimentare', 'Organizzazione raccolte e distribuzione cibo per famiglie.', '2026-03-30', '10:30:00', 'Centro Sociale - Edificio D', 80, 0, 'APPROVED', CURRENT_TIMESTAMP, 'photo1.jpeg', 3, 5),
('Corso Avanzato React', 'Componenti, state management e performance optimization.', '2026-06-05', '09:30:00', 'Aula Dev - Edificio C', 35, 0, 'WAITING', CURRENT_TIMESTAMP, 'photo3.jpeg', 4, 2),
('Maratona di Coding', '24 ore di sviluppo per costruire progetti su temi sociali.', '2026-07-24', '12:00:00', 'Lab Maratona - Edificio C', 200, 0, 'APPROVED', CURRENT_TIMESTAMP, 'photo2.jpeg', 3, 2),
('Seminario Psicologia dello Sport', 'Strategie mentali per migliorare la prestazione sportiva.', '2026-05-18', '18:00:00', 'Aula B2 - Edificio D', 60, 0, 'APPROVED', CURRENT_TIMESTAMP, 'photo1.jpeg', 4, 4),
('Workshop Arduino per Maker', 'Costruzione di prototipi e controlli con sensori.', '2026-04-28', '14:00:00', 'FabLab - Edificio B', 30, 0, 'WAITING', CURRENT_TIMESTAMP, 'photo3.jpeg', 3, 2),
('Corso di Lingua Spagnola Livello A2', 'Lezioni pratiche e conversazione guidata.', '2026-03-05', '17:00:00', 'Sala Lingue - Edificio B', 25, 0, 'APPROVED', CURRENT_TIMESTAMP, 'photo1.jpeg', 3, 5),
('Seminario Tecnologia e Etica', 'Riflettere sugli impatti etici delle tecnologie emergenti.', '2026-08-02', '10:00:00', 'Auditorium - Edificio A', 180, 0, 'WAITING', CURRENT_TIMESTAMP, 'photo3.jpeg', 4, 1),
('Torneo di Basket 3x3', 'Competizione aperta a squadre universitarie.', '2026-06-30', '19:00:00', 'Palazzetto - Edificio D', 48, 0, 'APPROVED', CURRENT_TIMESTAMP, 'photo2.jpeg', 4, 4),
('Laboratorio Teatro Improvvisazione', 'Esercizi per migliorare creatività e presenza scenica.', '2026-04-12', '20:00:00', 'Teatro Studio - Edificio A', 60, 0, 'APPROVED', CURRENT_TIMESTAMP, 'photo1.jpeg', 3, 5),
('Corso SEO e Content Marketing', 'Tecniche per aumentare visibilità e traffico organico.', '2026-05-09', '11:00:00', 'Aula Marketing - Edificio B', 40, 0, 'WAITING', CURRENT_TIMESTAMP, 'photo3.jpeg', 4, 2),
('Laboratorio Giardinaggio Urbano', 'Workshop pratico su orti in vaso e biodiversità locale.', '2026-04-22', '09:00:00', 'Giardino Comune - Edificio C', 30, 0, 'APPROVED', CURRENT_TIMESTAMP, 'photo1.jpeg', 3, 5),
('Seminario Fotogrammetria con Drone', 'Tecniche di rilievo e ricostruzione 3D con droni.', '2026-07-16', '10:00:00', 'Piazzale D - Edificio C', 50, 0, 'WAITING', CURRENT_TIMESTAMP, 'photo2.jpeg', 4, 3),
('Incontro Startup FemTech', 'Networking e pitch per iniziative femtech.', '2026-06-11', '17:30:00', 'Hub Donne - Edificio A', 90, 0, 'APPROVED', CURRENT_TIMESTAMP, 'photo1.jpeg', 3, 1),
('Seminario Legislazione Digitale', 'Aspetti legali di privacy, copyright e contratti digitali.', '2026-05-26', '15:00:00', 'Aula Giurisprudenza - Edificio B', 120, 0, 'WAITING', CURRENT_TIMESTAMP, 'photo3.jpeg', 4, 1),
('Camminata Salute e Benessere', 'Passeggiata guidata e sessione di stretching all''aperto.', '2026-03-08', '07:30:00', 'Parco Sud - Edificio D', 100, 0, 'APPROVED', CURRENT_TIMESTAMP, 'photo2.jpeg', 3, 4),
('Laboratorio Video Editing', 'Montaggio base e tecniche rapide per contenuti social.', '2026-04-05', '14:30:00', 'Media Lab - Edificio B', 25, 0, 'WAITING', CURRENT_TIMESTAMP, 'photo1.jpeg', 4, 2),
('Seminario Economia Circolare', 'Modelli di business rigenerativi e casi studio.', '2026-06-02', '10:30:00', 'Sala Conferenze - Edificio A', 150, 0, 'APPROVED', CURRENT_TIMESTAMP, 'photo3.jpeg', 3, 1),
('Workshop Blockchain per Business', 'Applicazioni pratiche oltre le criptovalute.', '2026-07-01', '09:00:00', 'Lab Fintech - Edificio C', 60, 0, 'WAITING', CURRENT_TIMESTAMP, 'photo2.jpeg', 4, 1),
('Corso di Primo Soccorso', 'Formazione base e certificazione per gestire emergenze.', '2026-03-12', '09:00:00', 'Sala Medica - Edificio D', 40, 0, 'APPROVED', CURRENT_TIMESTAMP, 'photo1.jpeg', 3, 4),
('Festa di Fine Anno Accademico', 'Celebrazione con musica, food truck e premiazioni.', '2026-06-20', '18:00:00', 'Campo Principale - Edificio B', 500, 0, 'APPROVED', CURRENT_TIMESTAMP, 'photo3.jpeg', 4, 5),
('Seminario Accessibilità Digitale', 'Progettare prodotti inclusivi secondo le linee guida WCAG.', '2026-05-15', '10:00:00', 'Aula A1 - Edificio A', 80, 0, 'WAITING', CURRENT_TIMESTAMP, 'photo2.jpeg', 3, 3),
('Club di Lettura Tecnico', 'Incontri mensili per discutere libri su tecnologia e innovazione.', '2026-04-20', '18:30:00', 'Biblioteca - Edificio B', 30, 0, 'APPROVED', CURRENT_TIMESTAMP, 'photo1.jpeg', 3, 5),
('Festival della Robotica', 'Gare, dimostrazioni e workshop per appassionati di robotica.', '2026-09-12', '09:00:00', 'Padiglione Tecnico - Edificio C', 400, 0, 'WAITING', CURRENT_TIMESTAMP, 'photo3.jpeg', 4, 2),
('Ciclo di Incontri: Storia della Musica', 'Lezioni e ascolti guidati su vari periodi storici.', '2026-05-21', '20:00:00', 'Sala Musica - Edificio A', 60, 0, 'APPROVED', CURRENT_TIMESTAMP, 'photo1.jpeg', 3, 5);

-- =====================================
-- SUBSCRIPTION
-- =====================================
INSERT INTO `SUBSCRIPTION` (user_id, event_id, participation_code, status, checkin_time) VALUES
(1, 1, 'SUB1001', 'REGISTERED', NULL),
(2, 1, 'SUB1002', 'REGISTERED', NULL),
(4, 4, 'SUB1004', 'PRESENT', '2026-04-10 08:05:00'),
(1, 9, 'SUB1010', 'PRESENT', '2026-06-08 19:35:00'),
(2, 7, 'SUB1011', 'PRESENT', '2026-05-12 17:05:00'),
(5, 10, 'SUB1013', 'PRESENT', '2026-05-20 11:05:00'),
(2, 4, 'SUB1014', 'CANCELLED', NULL);
