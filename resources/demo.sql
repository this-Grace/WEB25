USE web25;

-- =====================================
-- UTENTI
-- =====================================
INSERT INTO UTENTE (nome, cognome, email, password, ruolo) VALUES
('Mario', 'Rossi', 'mario.rossi@uni.it', 'hash_password_1', 'ADMIN'),
('Laura', 'Bianchi', 'laura.bianchi@uni.it', 'hash_password_2', 'ADMIN'),
('Luca', 'Verdi', 'luca.verdi@studenti.it', 'hash_password_3', 'USER'),
('Giulia', 'Neri', 'giulia.neri@studenti.it', 'hash_password_4', 'USER'),
('Paolo', 'Blu', 'paolo.blu@studenti.it', 'hash_password_5', 'USER');

-- =====================================
-- CATEGORIE
-- =====================================
INSERT INTO CATEGORIA (nome, slug, descrizione) VALUES
('Conferenze', 'conferenze', 'Eventi di tipo accademico'),
('Workshop', 'workshop', 'Attività pratiche e laboratori'),
('Seminari', 'seminari', 'Seminari didattici'),
('Party', 'party', 'Eventi sociali e feste'),
('Sport', 'sport', 'Attività sportive'),
('Social', 'social', 'Eventi di aggregazione');

-- =====================================
-- EVENTI
-- =====================================
INSERT INTO EVENTO (
    titolo, descrizione, data_evento, ora_evento, luogo,
    posti_totali, posti_disponibili, stato,
    data_pubblicazione, immagine, id_admin, id_categoria
) VALUES
(
    'Conferenza su Intelligenza Artificiale',
    'Introduzione alle applicazioni dell’AI',
    '2026-03-15', '10:00:00', 'Aula Magna',
    200, 197, 'PUBBLICATO',
    CURRENT_TIMESTAMP, 'img/ai_conference.jpg', 1, 1
),
(
    'Workshop di Cybersecurity',
    'Laboratorio pratico sulla sicurezza informatica',
    '2026-03-20', '14:00:00', 'Laboratorio 3',
    30, 28, 'PUBBLICATO',
    CURRENT_TIMESTAMP, 'img/cyber_workshop.png', 2, 2
),
(
    'Seminario di Basi di Dati',
    'Normalizzazione e progettazione ER',
    '2026-04-02', '09:30:00', 'Aula B1',
    100, 100, 'BOZZA',
    NULL, 'img/db_seminar.jpg', 1, 3
);

-- =====================================
-- ISCRIZIONI
-- =====================================
INSERT INTO ISCRIZIONE (
    id_utente, id_evento, codice_partecipazione, stato
) VALUES
(3, 1, 'AI2026LUC', 'ISCRITTO'),
(4, 1, 'AI2026GIU', 'PRESENTE'),
(5, 1, 'AI2026PAO', 'ASSENTE'),
(3, 2, 'CYB2026LUC', 'PRESENTE'),
(4, 2, 'CYB2026GIU', 'ISCRITTO');

-- =====================================
-- ATTIVITÀ UTENTE
-- =====================================
INSERT INTO ATTIVITA_UTENTE (
    id_utente, tipo_attivita, id_evento, descrizione
) VALUES
(1, 'CREA_EVENTO', 1, 'Creazione evento AI'),
(1, 'PUBBLICA_EVENTO', 1, 'Pubblicazione evento AI'),
(2, 'CREA_EVENTO', 2, 'Creazione workshop cybersecurity'),
(3, 'ISCRIZIONE_EVENTO', 1, 'Iscrizione alla conferenza AI'),
(4, 'PARTECIPAZIONE_EVENTO', 1, 'Partecipazione conferenza AI'),
(3, 'PARTECIPAZIONE_EVENTO', 2, 'Partecipazione workshop cybersecurity');
