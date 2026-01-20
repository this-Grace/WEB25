<?php

require_once __DIR__ . '/../config/database.php';

/**
 * Dashboard model per la gestione delle statistiche e dati della dashboard admin.
 * 
 * Questa classe fornisce metodi per recuperare statistiche, ultimi utenti, report aperti ecc.
 */
class Dashboard
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
     * Conta gli utenti totali attivi
     * 
     * @return int Numero di utenti
     */
    public function getTotalUsers(): int
    {
        try {
            $result = $this->db->query("SELECT COUNT(*) as count FROM users WHERE status != 'deleted'");
            if (!$result) return 0;

            $count = $result->fetch_assoc()['count'] ?? 0;
            $result->free();

            return (int)$count;
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Conta i report aperti
     * 
     * @return int Numero di report aperti
     */
    public function getOpenReportsCount(): int
    {
        try {
            $result = $this->db->query("SELECT COUNT(*) as count FROM reports WHERE status = 'open'");
            if (!$result) return 0;

            $count = $result->fetch_assoc()['count'] ?? 0;
            $result->free();

            return (int)$count;
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Conta i post pubblicati
     * 
     * @return int Numero di post pubblicati
     */
    public function getPublishedPostsCount(): int
    {
        try {
            $result = $this->db->query("SELECT COUNT(*) as count FROM posts WHERE status = 'published'");
            if (!$result) return 0;

            $count = $result->fetch_assoc()['count'] ?? 0;
            $result->free();

            return (int)$count;
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Conta i match attivi
     * 
     * @return int Numero di match
     */
    public function getActiveMatchesCount(): int
    {
        try {
            $result = $this->db->query("SELECT COUNT(*) as count FROM matches");
            if (!$result) return 0;

            $count = $result->fetch_assoc()['count'] ?? 0;
            $result->free();

            return (int)$count;
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Ottiene gli ultimi utenti registrati
     * 
     * @param int $limit Numero massimo di risultati
     * @return array Array di utenti
     */
    public function getLatestUsers($limit = 5): array
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT id, CONCAT(name, ' ', surname) as name, email, DATE_FORMAT(created_at, '%Y-%m-%d') as joined 
                 FROM users 
                 WHERE status != 'deleted' 
                 ORDER BY created_at DESC 
                 LIMIT ?"
            );
            $stmt->bind_param('i', $limit);
            $stmt->execute();

            $result = $stmt->get_result();
            $users = $result->fetch_all(MYSQLI_ASSOC);

            $result->free();
            $stmt->close();

            return $users;
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * Ottiene i report aperti
     * 
     * @param int $limit Numero massimo di risultati
     * @return array Array di report
     */
    public function getOpenReports($limit = 5): array
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT r.id, CONCAT(u.name, ' ', u.surname) as user, r.reason, DATE_FORMAT(r.created_at, '%Y-%m-%d') as created
                 FROM reports r
                 JOIN users u ON r.reported_user_id = u.id
                 WHERE r.status = 'open'
                 ORDER BY r.created_at DESC
                 LIMIT ?"
            );
            $stmt->bind_param('i', $limit);
            $stmt->execute();

            $result = $stmt->get_result();
            $reports = $result->fetch_all(MYSQLI_ASSOC);

            $result->free();
            $stmt->close();

            return $reports;
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * Ottiene gli ultimi post pubblicati
     * 
     * @param int $limit Numero massimo di risultati
     * @return array Array di post
     */
    public function getLatestPosts($limit = 5): array
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT p.id, p.title, CONCAT(u.name, ' ', u.surname) as author, DATE_FORMAT(p.created_at, '%Y-%m-%d') as created
                 FROM posts p
                 JOIN users u ON p.user_id = u.id
                 WHERE p.status = 'published'
                 ORDER BY p.created_at DESC
                 LIMIT ?"
            );
            $stmt->bind_param('i', $limit);
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

    /**
     * Calcola la crescita mensile degli utenti
     * 
     * @return int Percentuale di crescita
     */
    public function getMonthlyGrowth(): int
    {
        try {
            $now = new DateTime();
            $thisMonthStart = $now->format('Y-m-01');
            $lastMonthStart = (new DateTime($now->format('Y-m-01') . ' -1 month'))->format('Y-m-01');
            $lastMonthEnd = (new DateTime($now->format('Y-m-01') . ' -1 day'))->format('Y-m-d');

            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM users WHERE DATE(created_at) >= ? AND status != 'deleted'");
            $stmt->bind_param('s', $thisMonthStart);
            $stmt->execute();
            $thisMonthCount = $stmt->get_result()->fetch_assoc()['count'] ?? 0;
            $stmt->close();

            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM users WHERE DATE(created_at) >= ? AND DATE(created_at) <= ? AND status != 'deleted'");
            $stmt->bind_param('ss', $lastMonthStart, $lastMonthEnd);
            $stmt->execute();
            $lastMonthCount = $stmt->get_result()->fetch_assoc()['count'] ?? 0;
            $stmt->close();

            return $lastMonthCount > 0 ? round((($thisMonthCount - $lastMonthCount) / $lastMonthCount) * 100) : 0;
        } catch (Exception $e) {
            return 0;
        }
    }
}
