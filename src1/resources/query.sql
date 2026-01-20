/*
========================================
 UniMatch - Query Utils
========================================
*/

/*
========================================
 HOME / SWIPE POSTS
========================================
*/

/*
QUERY: Recupera il prossimo post da mostrare all'utente

Regole:
- esclude i post dell'utente stesso
- esclude i post già visualizzati (like o skip)
- restituisce UN SOLO post
*/
SELECT p.*
FROM posts p
WHERE p.user_username != :username
AND NOT EXISTS (
    SELECT 1
    FROM reactions r
    WHERE r.post_id = p.id
      AND r.user_username = :username
)
ORDER BY p.created_at
LIMIT 1;


/*
QUERY: Salva una reazione ad un post (like o skip)

Note:
- la PK (user_username, post_id) impedisce doppie reazioni
- se la INSERT fallisce, reazione già presente
*/
INSERT INTO reactions (user_username, post_id, reaction_type)
VALUES (:username, :post_id, :reaction_type);

/*
QUERY: Creazione di un nuovo post di progetto
Include tutti i campi richiesti dall'analisi: corso, numero collaboratori e competenze
*/
INSERT INTO posts (user_username, title, content, degree_course, num_collaborators, skills_required)
VALUES (:username, :title, :content, :degree_course, :num_collaborators, :skills_required);

/*
QUERY: Recupera i post pubblicati dall'utente loggato
Serve per la sezione "I miei post" del profilo
*/
SELECT * FROM posts 
WHERE user_username = :username 
ORDER BY created_at DESC;


/*
========================================
 REACTIONS STATS
========================================
*/

/*
QUERY: Recupera tutti i post a cui l'utente ha messo LIKE
*/
SELECT p.*
FROM posts p
JOIN reactions r ON r.post_id = p.id
WHERE r.user_username = :username
AND r.reaction_type = 'like'
ORDER BY r.created_at DESC;


/*
QUERY: Recupera tutti i post a cui l'utente ha messo SKIP
*/
SELECT p.*
FROM posts p
JOIN reactions r ON r.post_id = p.id
WHERE r.user_username = :username
AND r.reaction_type = 'skip'
ORDER BY r.created_at DESC;


/*
QUERY: Utenti che hanno messo LIKE a un mio post specifico
*/
SELECT
    u.username,
    u.first_name,
    u.surname,
    u.avatar_url,
    u.degree_course,
    r.created_at AS reacted_at
FROM reactions r
JOIN users u ON r.user_username = u.username
JOIN posts p ON r.post_id = p.id
WHERE p.id = :post_id
AND p.user_username = :my_username
AND r.reaction_type = 'like'
ORDER BY r.created_at DESC;


/*
QUERY: Utenti che hanno messo SKIP a un mio post specifico
*/
SELECT
    u.username,
    u.first_name,
    u.surname,
    u.avatar_url,
    u.degree_course,
    r.created_at AS reacted_at
FROM reactions r
JOIN users u ON r.user_username = u.username
JOIN posts p ON r.post_id = p.id
WHERE p.id = :post_id
AND p.user_username = :my_username
AND r.reaction_type = 'skip'
ORDER BY r.created_at DESC;


/*
QUERY: Conteggio like / skip su un mio post
*/
SELECT
    r.reaction_type,
    COUNT(*) AS total
FROM reactions r
JOIN posts p ON r.post_id = p.id
WHERE p.id = :post_id
AND p.user_username = :my_username
GROUP BY r.reaction_type;



/*
========================================
 CHAT LOGIC
========================================
*/

/*
QUERY: Verifica se l'utente può avviare una chat con un altro

Regola:
- l'altro utente deve aver messo LIKE ad almeno un mio post
*/
SELECT 1
FROM reactions r
JOIN posts p ON r.post_id = p.id
WHERE p.user_username = :me
AND r.user_username = :other
AND r.reaction_type = 'like'
LIMIT 1;


/*
QUERY: Crea una nuova conversazione
*/
INSERT INTO conversations () VALUES ();


/*
QUERY: Aggiunge due partecipanti alla conversazione
*/
INSERT INTO conversation_participants (conversation_id, user_username)
VALUES
(:conversation_id, :userA),
(:conversation_id, :userB);

/*
QUERY: Recupera la lista delle chat attive con l'anteprima dell'ultimo messaggio
*/
SELECT 
    c.id AS conversation_id,
    cp_other.user_username AS chat_partner,
    u.avatar_url,
    m.text AS last_message,
    m.created_at AS last_message_time,
    m.is_read
FROM conversation_participants cp_me
JOIN conversation_participants cp_other 
    ON cp_me.conversation_id = cp_other.conversation_id AND cp_other.user_username != :me
JOIN users u ON cp_other.user_username = u.username
JOIN conversations c ON c.id = cp_me.conversation_id
LEFT JOIN messages m ON m.id = (
    SELECT id FROM messages 
    WHERE conversation_id = c.id 
    ORDER BY created_at DESC LIMIT 1
)
WHERE cp_me.user_username = :me
ORDER BY m.created_at DESC;

/*
QUERY: Segna i messaggi come letti
Da eseguire quando l'utente apre la finestra di chat
*/
UPDATE messages 
SET is_read = TRUE 
WHERE conversation_id = :conversation_id 
AND sender_username != :me;


/*
========================================
 MESSAGES
========================================
*/

/*
QUERY: Recupera tutti i messaggi di una conversazione
*/
SELECT *
FROM messages
WHERE conversation_id = :conversation_id
ORDER BY created_at;


/*
QUERY: Inserisce un nuovo messaggio
*/
INSERT INTO messages (conversation_id, sender_username, text)
VALUES (:conversation_id, :sender, :text);


/*
========================================
 REPORTS
========================================
*/

/*
QUERY: Inserisce una segnalazione di un post
*/
INSERT INTO reports (
    reporter_username,
    reported_post_id,
    reason,
    description
) VALUES (
    :reporter,
    :post_id,
    :reason,
    :description
);
