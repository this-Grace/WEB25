<?php

require_once __DIR__ . '/../config/database.php';

/**
 * User model per la gestione delle operazioni relative agli utenti nel database.
 * 
 * Questa classe fornisce metodi per operazioni di CRUD, autenticazione
 * e gestione del profilo utente.
 */
class User
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
     * Ritorna tutti gli utenti dal database
     * 
     * @return array Array di record utenti, vuoto se nessun utente trovato
     */
    public function all(): array
    {
        try {
            $query = "SELECT u.id, u.email, u.name, u.surname, u.bio, u.avatar,
                             u.university, u.created_at, u.updated_at
                      FROM users u
                      ORDER BY u.created_at DESC";
            $result = $this->db->query($query);

            if (!$result) return [];

            $data = $result->fetch_all(MYSQLI_ASSOC);
            $result->free();

            return $data;
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * Conta il numero totale di utenti
     * 
     * @return int Numero totale di utenti
     */
    public function count(): int
    {
        try {
            $result = $this->db->query("SELECT COUNT(*) as count FROM users");
            if (!$result) return 0;

            $count = $result->fetch_assoc()['count'] ?? 0;
            $result->free();

            return (int)$count;
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Trova un utente tramite email o username per il login
     *
     * @param string $value Email o username
     * @return array|null Dati utente incluso password hash, null se non trovato
     */
    public function find(string $value): ?array
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT id, email, password_hash, name, surname,
                        bio, avatar, university, created_at
                 FROM users
                 WHERE email = ? OR id = ?
                 LIMIT 1"
            );

            $stmt->bind_param('ss', $value, $value);
            $stmt->execute();

            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            $result->free();
            $stmt->close();

            return $user ?: null;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Autentica le credenziali dell'utente
     * 
     * @param string $login Email o username dell'utente
     * @param string $password Password in chiaro da verificare
     * @return array|null Dati utente se validi, null altrimenti
     */
    public function checkLogin($login, $password): ?array
    {
        $user = $this->find($login);
        if (!$user) return null;

        if (!password_verify($password, $user['password_hash'])) {
            return null;
        }

        unset($user['password_hash']);
        return $user;
    }

    /**
     * Verifica se un'email è già registrata
     * 
     * @param string $email Indirizzo email da verificare
     * @return bool True se esiste, false altrimenti
     */
    public function emailExists($email): bool
    {
        try {
            $stmt = $this->db->prepare("SELECT 1 FROM users WHERE email = ? LIMIT 1");
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->store_result();

            $exists = $stmt->num_rows > 0;
            $stmt->close();

            return $exists;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Crea un nuovo utente nel database
     * 
     * @param string $email Email dell'utente
     * @param string $password Password in chiaro (verrà hashato)
     * @param string $name Nome dell'utente
     * @param string $surname Cognome dell'utente
     * @param string $university Università dell'utente
     * @return bool True se creazione riuscita, false altrimenti
     */
    public function create($email, $password, $name, $surname, $university): bool
    {
        try {
            if ($this->emailExists($email)) {
                return false;
            }

            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $this->db->prepare(
                "INSERT INTO users (email, password_hash, name, surname, university, created_at, updated_at)
                 VALUES (?, ?, ?, ?, ?, NOW(), NOW())"
            );
            $stmt->bind_param('sssss', $email, $hash, $name, $surname, $university);

            $success = $stmt->execute();
            $stmt->close();

            return $success;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Aggiorna le informazioni del profilo utente
     * 
     * @param int $id ID dell'utente da aggiornare
     * @param string $name Nome aggiornato
     * @param string $surname Cognome aggiornato
     * @param string $bio Biografia aggiornata
     * @param string $avatar URL avatar aggiornato
     * @return bool True se aggiornamento riuscito, false altrimenti
     */
    public function update($id, $name, $surname, $bio, $avatar): bool
    {
        try {
            $stmt = $this->db->prepare(
                "UPDATE users SET name = ?, surname = ?, bio = ?, avatar = ?, updated_at = NOW() WHERE id = ?"
            );
            $stmt->bind_param('ssssi', $name, $surname, $bio, $avatar, $id);

            $success = $stmt->execute();
            $stmt->close();

            return $success;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Cancella un utente dal database
     * 
     * @param int $id ID dell'utente da cancellare
     * @return bool True se cancellazione riuscita, false altrimenti
     */
    public function delete($id): bool
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
            $stmt->bind_param('i', $id);

            $success = $stmt->execute();
            $stmt->close();

            return $success;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Ottiene un utente per ID
     * 
     * @param int $id ID dell'utente
     * @return array|null Dati utente, null se non trovato
     */
    public function getById($id): ?array
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT id, email, name, surname, bio, avatar, university, created_at, updated_at
                 FROM users WHERE id = ? LIMIT 1"
            );
            $stmt->bind_param('i', $id);
            $stmt->execute();

            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            $result->free();
            $stmt->close();

            return $user ?: null;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Cambia la password di un utente
     * 
     * @param int $id ID dell'utente
     * @param string $newPassword Nuova password in chiaro
     * @return bool True se cambio riuscito, false altrimenti
     */
    public function changePassword($id, $newPassword): bool
    {
        try {
            $hash = password_hash($newPassword, PASSWORD_DEFAULT);

            $stmt = $this->db->prepare(
                "UPDATE users SET password_hash = ?, updated_at = NOW() WHERE id = ?"
            );
            $stmt->bind_param('si', $hash, $id);

            $success = $stmt->execute();
            $stmt->close();

            return $success;
        } catch (Exception $e) {
            return false;
        }
    }
}
