DROP DATABASE IF EXISTS web25;
CREATE DATABASE web25;
USE web25;

-- =====================================
-- USER
-- =====================================
CREATE TABLE USER (
    email VARCHAR(100) PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    surname VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    avatar VARCHAR(255) DEFAULT 'upload/img/profile/default-avatar.png',
    role ENUM('USER', 'HOST', 'ADMINISTRATOR') NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- -- =====================================
-- -- CATEGORIY
-- -- =====================================
CREATE TABLE CATEGORY (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL UNIQUE
);

-- =====================================
-- EVENT
-- =====================================
CREATE TABLE EVENT (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    event_date DATETIME NOT NULL,
    location VARCHAR(100) NOT NULL,
    total_seats INT NOT NULL CHECK (total_seats > 0),
    available_seats INT NOT NULL CHECK (available_seats >= 0),
    status ENUM('DRAFT', 'PUBLISHED', 'APPROVED', 'CANCELLED') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    image VARCHAR(255) NULL,

    user_email VARCHAR(100) NOT NULL,
    category_id INT NOT NULL,

    CONSTRAINT fk_event_user
        FOREIGN KEY (user_email)
        REFERENCES USER(email),

    CONSTRAINT fk_event_category
        FOREIGN KEY (category_id)
        REFERENCES CATEGORY(id)
);

-- -- =====================================
-- -- ISCRIZIONE
-- -- =====================================
-- CREATE TABLE ISCRIZIONE (
--     id_iscrizione INT AUTO_INCREMENT PRIMARY KEY,
--     id_utente INT NOT NULL,
--     id_evento INT NOT NULL,
--     data_iscrizione TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
--     codice_partecipazione VARCHAR(20) NOT NULL UNIQUE,
--     stato ENUM('ISCRITTO', 'PRESENTE', 'ASSENTE', 'CANCELLATO') NOT NULL,
--     orario_checkin TIMESTAMP NULL,

--     CONSTRAINT fk_iscrizione_utente
--         FOREIGN KEY (id_utente)
--         REFERENCES UTENTE(id_utente),

--     CONSTRAINT fk_iscrizione_evento
--         FOREIGN KEY (id_evento)
--         REFERENCES EVENTO(id_evento),

--     CONSTRAINT unica_iscrizione
--         UNIQUE (id_utente, id_evento)
-- );

-- -- =====================================
-- -- ATTIVITA UTENTE
-- -- =====================================
-- CREATE TABLE ATTIVITA_UTENTE (
--     id_attivita INT AUTO_INCREMENT PRIMARY KEY,
--     id_utente INT NOT NULL,
--     tipo_attivita ENUM(
--         'CREA_EVENTO',
--         'MODIFICA_EVENTO',
--         'PUBBLICA_EVENTO',
--         'ISCRIZIONE_EVENTO',
--         'PARTECIPAZIONE_EVENTO',
--         'CANCELLA_ISCRIZIONE'
--     ) NOT NULL,
--     id_evento INT NULL,
--     timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
--     descrizione TEXT,

--     CONSTRAINT fk_attivita_utente
--         FOREIGN KEY (id_utente)
--         REFERENCES UTENTE(id_utente),

--     CONSTRAINT fk_attivita_evento
--         FOREIGN KEY (id_evento)
--         REFERENCES EVENTO(id_evento)
-- );
