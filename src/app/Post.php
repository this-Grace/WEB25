<?php

require_once __DIR__ . '/../config/database.php';

/**
 * Post model per la gestione delle operazioni relative ai post nel database.
 * 
 * Questa classe fornisce metodi per operazioni di CRUD, ricerca e moderazione post.
 */
class Post
{
    /**
     * @var mysqli Istanza della connessione al database
     */
    private $db;

    /**
     * Costruttore - inizializza la connessione al database
     */
    public function __construct()
    {
        global $dbh;
        $this->db = $dbh->getConnection();
    }

    /**
     * Ritorna tutti i post con opzioni di filtro
     * 
     * @param string $status Filtro per stato (published, hidden, closed)
     * @param string $searchTerm Termine di ricerca nel titolo/descrizione
     * @param int $limit Numero massimo di risultati
     * @return array Array di post
     */
    public function all($status = '', $searchTerm = '', $limit = 50): array
    {
        try {
            $query = "SELECT p.id, p.user_id, CONCAT(u.name, ' ', u.surname) as author, 
                             p.title, p.description,
                             DATE_FORMAT(p.created_at, '%Y-%m-%d %H:%i') as created_at,
                             (SELECT COUNT(*) FROM likes WHERE post_id = p.id) as likes_count,
                             (SELECT COUNT(*) FROM skips WHERE post_id = p.id) as skips_count,
                             p.status
                      FROM posts p
                      JOIN users u ON p.user_id = u.id
                      WHERE 1=1";

            $params = [];
            $types = '';

            if (!empty($status)) {
                $query .= " AND p.status = ?";
                $params[] = $status;
                $types .= 's';
            }

            if (!empty($searchTerm)) {
                $query .= " AND (p.title LIKE ? OR p.description LIKE ?)";
                $searchPattern = "%{$searchTerm}%";
                $params[] = $searchPattern;
                $params[] = $searchPattern;
                $types .= 'ss';
            }

            $query .= " ORDER BY p.created_at DESC LIMIT ?";
            $params[] = $limit;
            $types .= 'i';

            $stmt = $this->db->prepare($query);

            if (!empty($params)) {
                $refs = [];
                $refs[] = $types;
                foreach ($params as $key => $value) {
                    $refs[] = &$params[$key];
                }
                call_user_func_array([$stmt, 'bind_param'], $refs);
            }

            $stmt->execute();
            $result = $stmt->get_result();
            $posts = $result->fetch_all(MYSQLI_ASSOC);

            $result->free();
            $stmt->close();

            return $posts;
        } catch (Exception $e) {
            // It's a good practice to log the error
            // error_log($e->getMessage());
            return [];
        }
    }

    /**
     * Ottiene un post per ID
     * 
     * @param int $id ID del post
     * @return array|null Dati del post, null se non trovato
     */
    public function getById($id): ?array
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT p.id, p.user_id, CONCAT(u.name, ' ', u.surname) as author,
                        p.title, p.description,
                        DATE_FORMAT(p.created_at, '%Y-%m-%d %H:%i') as created_at,
                        DATE_FORMAT(p.updated_at, '%Y-%m-%d %H:%i') as updated_at,
                        (SELECT COUNT(*) FROM likes WHERE post_id = p.id) as likes_count,
                        (SELECT COUNT(*) FROM skips WHERE post_id = p.id) as skips_count,
                        p.status
                 FROM posts p
                 JOIN users u ON p.user_id = u.id
                 WHERE p.id = ? LIMIT 1"
            );
            $stmt->bind_param('i', $id);
            $stmt->execute();

            $result = $stmt->get_result();
            $post = $result->fetch_assoc();

            $result->free();
            $stmt->close();

            return $post ?: null;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Crea un nuovo post
     * 
     * @param int $user_id ID dell'utente che crea il post
     * @param string $title Titolo del post
     * @param string $description Descrizione breve
     * @param string $content Contenuto completo
     * @param string $status Stato del post (published, draft, hidden)
     * @return bool True se creazione riuscita, false altrimenti
     */
    public function create($user_id, $title, $description, $content, $status = 'published'): bool
    {
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO posts (user_id, title, description, content, status, created_at, updated_at)
                 VALUES (?, ?, ?, ?, ?, NOW(), NOW())"
            );
            $stmt->bind_param('issss', $user_id, $title, $description, $content, $status);

            $success = $stmt->execute();
            $stmt->close();

            return $success;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Aggiorna un post
     * 
     * @param int $id ID del post
     * @param string $title Titolo aggiornato
     * @param string $description Descrizione aggiornata
     * @param string $content Contenuto aggiornato
     * @return bool True se aggiornamento riuscito, false altrimenti
     */
    public function update($id, $title, $description, $content): bool
    {
        try {
            $stmt = $this->db->prepare(
                "UPDATE posts SET title = ?, description = ?, content = ?, updated_at = NOW() WHERE id = ?"
            );
            $stmt->bind_param('sssi', $title, $description, $content, $id);

            $success = $stmt->execute();
            $stmt->close();

            return $success;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Cambia lo stato di un post
     * 
     * @param int $id ID del post
     * @param string $status Nuovo stato (published, hidden, closed)
     * @return bool True se cambio riuscito, false altrimenti
     */
    public function changeStatus($id, $status): bool
    {
        try {
            if (!in_array($status, ['published', 'hidden', 'closed'])) {
                return false;
            }

            $stmt = $this->db->prepare(
                "UPDATE posts SET status = ?, updated_at = NOW() WHERE id = ?"
            );
            $stmt->bind_param('si', $status, $id);

            $success = $stmt->execute();
            $stmt->close();

            return $success;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Elimina un post
     * 
     * @param int $id ID del post da eliminare
     * @return bool True se eliminazione riuscita, false altrimenti
     */
    public function delete($id): bool
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM posts WHERE id = ?");
            $stmt->bind_param('i', $id);

            $success = $stmt->execute();
            $stmt->close();

            return $success;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Conta i post totali per utente
     * 
     * @param int $user_id ID dell'utente
     * @return int Numero di post
     */
    public function countByUser($user_id): int
    {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM posts WHERE user_id = ?");
            $stmt->bind_param('i', $user_id);
            $stmt->execute();

            $result = $stmt->get_result();
            $count = $result->fetch_assoc()['count'] ?? 0;

            $result->free();
            $stmt->close();

            return (int)$count;
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Conta i post totali per stato
     * 
     * @param string $status Stato del post
     * @return int Numero di post
     */
    public function countByStatus($status): int
    {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM posts WHERE status = ?");
            $stmt->bind_param('s', $status);
            $stmt->execute();

            $result = $stmt->get_result();
            $count = $result->fetch_assoc()['count'] ?? 0;

            $result->free();
            $stmt->close();

            return (int)$count;
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Ottiene i post di un utente
     * 
     * @param int $user_id ID dell'utente
     * @param int $limit Numero massimo di risultati
     * @return array Array di post
     */
    public function getByUser($user_id, $limit = 50): array
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT id, user_id, title, description,
                        DATE_FORMAT(created_at, '%Y-%m-%d %H:%i') as created_at,
                        (SELECT COUNT(*) FROM likes WHERE post_id = p.id) as likes_count,
                        (SELECT COUNT(*) FROM skips WHERE post_id = p.id) as skips_count,
                        status
                 FROM posts p
                 WHERE user_id = ?
                 ORDER BY created_at DESC
                 LIMIT ?"
            );
            $stmt->bind_param('ii', $user_id, $limit);
            $stmt->execute();

            $result = $stmt->get_result();
            $posts = $result->fetch_all(MYSQLI_ASSOC);

            $result->free();
            $stmt->close();

            return $posts;
        } catch (Exception $e) {
            return [];
        }
    }
}
