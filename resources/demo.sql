USE web25;

-- ----------------------------------------------------
-- Inserimento utenti
-- ----------------------------------------------------
INSERT INTO users (email, password_hash, first_name, last_name, avatar_url) VALUES
('alice@example.com', 'hash1', 'Alice', 'Rossi', 'https://i.pravatar.cc/150?img=1'),
('bob@example.com', 'hash2', 'Bob', 'Bianchi', 'https://i.pravatar.cc/150?img=2'),
('carla@example.com', 'hash3', 'Carla', 'Verdi', 'https://i.pravatar.cc/150?img=3'),
('daniele@example.com', 'hash4', 'Daniele', 'Neri', 'https://i.pravatar.cc/150?img=4'),
('elena@example.com', 'hash5', 'Elena', 'Gialli', 'https://i.pravatar.cc/150?img=5');

-- ----------------------------------------------------
-- Utenti che possono creare eventi
-- ----------------------------------------------------
INSERT INTO event_owners (user_id) VALUES
(1),
(3),
(5);

-- ----------------------------------------------------
-- Categorie eventi
-- ----------------------------------------------------
INSERT INTO categories (category_name, category_icon) VALUES
('Musica', 'bi-music-note'),
('Sport', 'bi-basket'),
('Arte', 'bi-palette'),
('Tecnologia', 'bi-laptop');

-- ----------------------------------------------------
-- Eventi
-- ----------------------------------------------------
INSERT INTO events (event_name, event_date, eventOwner_id, category_id, location, description, event_url, event_status) VALUES
('Concerto Jazz', '2026-02-28 20:00:00', 1, 1, 'Auditorium San Marino', 'Un fantastico concerto jazz con ospiti internazionali.', 'https://example.com/concertojazz', 'pubblicato'),
('Maratona Cittadina', '2026-03-15 09:00:00', 3, 2, 'Centro Città', 'Maratona annuale con percorso panoramico.', 'https://example.com/maratona', 'bozza'),
('Mostra d’Arte Moderna', '2026-04-10 18:00:00', 5, 3, 'Galleria Nazionale', 'Esposizione di artisti emergenti.', 'https://example.com/arte', 'pubblicato');

-- ----------------------------------------------------
-- Registrazioni ai eventi
-- ----------------------------------------------------
INSERT INTO event_registrations (event_id, user_id) VALUES
(1, 2),
(1, 3),
(2, 2),
(3, 1),
(3, 4);
