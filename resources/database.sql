DROP DATABASE IF EXISTS web25;
CREATE DATABASE web25;
USE web25;

-- =====================================
-- DATABASE
-- =====================================
CREATE DATABASE eventi_universitari;
USE eventi_universitari;

-- =====================================
-- UTENTE
-- =====================================
CREATE TABLE UTENTE (
    id_utente INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    cognome VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    ruolo ENUM('USER', 'ADMIN') NOT NULL,
    data_registrazione TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =====================================
-- CATEGORIA
-- =====================================
CREATE TABLE CATEGORIA (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL UNIQUE,
    slug VARCHAR(50) NOT NULL UNIQUE,
    descrizione TEXT,
    attiva BOOLEAN DEFAULT TRUE
);

-- =====================================
-- EVENTO
-- =====================================
CREATE TABLE EVENTO (
    id_evento INT AUTO_INCREMENT PRIMARY KEY,
    titolo VARCHAR(100) NOT NULL,
    descrizione TEXT NOT NULL,
    data_evento DATE NOT NULL,
    ora_evento TIME NOT NULL,
    luogo VARCHAR(100) NOT NULL,
    posti_totali INT NOT NULL CHECK (posti_totali > 0),
    posti_disponibili INT NOT NULL CHECK (posti_disponibili >= 0),
    stato ENUM('BOZZA', 'PUBBLICATO', 'ANNULLATO') NOT NULL,
    data_creazione TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_pubblicazione TIMESTAMP NULL,

    id_admin INT NOT NULL,
    id_categoria INT NOT NULL,

    CONSTRAINT fk_evento_admin
        FOREIGN KEY (id_admin)
        REFERENCES UTENTE(id_utente),

    CONSTRAINT fk_evento_categoria
        FOREIGN KEY (id_categoria)
        REFERENCES CATEGORIA(id_categoria)
);

-- =====================================
-- ISCRIZIONE
-- =====================================
CREATE TABLE ISCRIZIONE (
    id_iscrizione INT AUTO_INCREMENT PRIMARY KEY,
    id_utente INT NOT NULL,
    id_evento INT NOT NULL,
    data_iscrizione TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    codice_partecipazione VARCHAR(20) NOT NULL UNIQUE,
    stato ENUM('ISCRITTO', 'PRESENTE', 'ASSENTE', 'CANCELLATO') NOT NULL,
    orario_checkin TIMESTAMP NULL,

    CONSTRAINT fk_iscrizione_utente
        FOREIGN KEY (id_utente)
        REFERENCES UTENTE(id_utente),

    CONSTRAINT fk_iscrizione_evento
        FOREIGN KEY (id_evento)
        REFERENCES EVENTO(id_evento),

    CONSTRAINT unica_iscrizione
        UNIQUE (id_utente, id_evento)
);

-- =====================================
-- ATTIVITA UTENTE
-- =====================================
CREATE TABLE ATTIVITA_UTENTE (
    id_attivita INT AUTO_INCREMENT PRIMARY KEY,
    id_utente INT NOT NULL,
    tipo_attivita ENUM(
        'CREA_EVENTO',
        'MODIFICA_EVENTO',
        'PUBBLICA_EVENTO',
        'ISCRIZIONE_EVENTO',
        'PARTECIPAZIONE_EVENTO',
        'CANCELLA_ISCRIZIONE'
    ) NOT NULL,
    id_evento INT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    descrizione TEXT,

    CONSTRAINT fk_attivita_utente
        FOREIGN KEY (id_utente)
        REFERENCES UTENTE(id_utente),

    CONSTRAINT fk_attivita_evento
        FOREIGN KEY (id_evento)
        REFERENCES EVENTO(id_evento)
);
