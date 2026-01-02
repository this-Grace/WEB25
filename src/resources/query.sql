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
AND p.id NOT IN (
    SELECT r.post_id
    FROM reactions r
    WHERE r.user_username = :username
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
