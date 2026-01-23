<?php

/**
 * Event Class
 * A data mapper for the EVENT table providing common queries and updates.
 * Uses prepared statements to prevent SQL injection.
 */
class Event
{
    /** @var mysqli $conn */
    private $conn;

    /**
     * Constructor
     * @param mysqli $conn
     */
    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Find event by id
     * @param int $id
     * @return array|null
     */
    public function findById(int $id): ?array
    {
        $sql = 'SELECT id, title, description, event_date,  location, total_seats, available_seats, status, created_at, image, user_email, category_id FROM EVENT WHERE id = ? LIMIT 1';
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return null;
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        $stmt->close();
        return $row ?: null;
    }

    /**
     * Retrieve events with optional pagination
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function findAll(int $limit = 100, int $offset = 0): array
    {
        $sql = 'SELECT e.id, e.title, e.description, e.event_date, e.location, e.total_seats, e.available_seats, e.status, e.created_at, e.image, e.user_email, e.category_id, c.name AS category_label'
            . ' FROM EVENT e'
            . ' LEFT JOIN CATEGORY c ON e.category_id = c.id'
            . ' ORDER BY e.event_date'
            . ' LIMIT ? OFFSET ?';

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return [];
        $stmt->bind_param('ii', $limit, $offset);
        $stmt->execute();
        $res = $stmt->get_result();
        $rows = [];
        while ($row = $res->fetch_assoc()) {
            if (!isset($row['category_label'])) {
                $row['category_label'] = 'Evento';
            }
            $rows[] = $row;
        }
        $stmt->close();
        return $rows;
    }

    /**
     * Find events by user email
     * @param string $email
     * @return array
     */
    public function findByUser(string $email): array
    {
        $sql = 'SELECT id, title, description, event_date, location, total_seats, available_seats, status, created_at, image, user_email, category_id FROM EVENT WHERE user_email = ? ORDER BY event_date';
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return [];
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $res = $stmt->get_result();
        $rows = [];
        while ($row = $res->fetch_assoc()) {
            $rows[] = $row;
        }
        $stmt->close();
        return $rows;
    }

    /**
     * Find events by category id
     * @param int $categoryId
     * @return array
     */
    public function findByCategory(int $categoryId): array
    {
        $sql = 'SELECT id, title, description, event_date, location, total_seats, available_seats, status, created_at, image, user_email, category_id FROM EVENT WHERE category_id = ? ORDER BY event_date';
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return [];
        $stmt->bind_param('i', $categoryId);
        $stmt->execute();
        $res = $stmt->get_result();
        $rows = [];
        while ($row = $res->fetch_assoc()) {
            $rows[] = $row;
        }
        $stmt->close();
        return $rows;
    }

    /**
     * Create a new event
     * @return bool
     */
    public function create(string $title, string $description, string $event_date, string $location, int $total_seats, int $available_seats, string $status, ?string $image, string $user_email, int $category_id): bool
    {
        $sql = 'INSERT INTO EVENT (title, description, event_date, location, total_seats, available_seats, status, created_at, image, user_email, category_id) VALUES (?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP, ?, ?, ?)';
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;
        $ok = $stmt->bind_param('ssssiisssi', $title, $description, $event_date, $location, $total_seats, $available_seats, $status, $image, $user_email, $category_id) && $stmt->execute();
        $stmt->close();
        return (bool)$ok;
    }

    /**
     * Update an existing event
     * @return bool
     */
    public function update(int $id, string $title, string $description, string $event_date, string $location, int $total_seats, int $available_seats, string $status, ?string $image, int $category_id): bool
    {
        $sql = 'UPDATE EVENT SET title = ?, description = ?, event_date = ?, location = ?, total_seats = ?, available_seats = ?, status = ?, image = ?, category_id = ? WHERE id = ?';
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;
        $ok = $stmt->bind_param('ssssiissii', $title, $description, $event_date, $location, $total_seats, $available_seats, $status, $image, $category_id, $id) && $stmt->execute();
        $stmt->close();
        return (bool)$ok;
    }

    /**
     * Delete an event by id
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $sql = 'DELETE FROM EVENT WHERE id = ?';
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param('i', $id);
        $ok = $stmt->execute();
        $stmt->close();
        return (bool)$ok;
    }

    /**
     * Reserve a seat (decrement available_seats if possible)
     * @param int $id
     * @return bool True if a seat was reserved, false otherwise
     */
    public function reserveSeat(int $id): bool
    {
        $sql = 'UPDATE EVENT SET available_seats = available_seats - 1 WHERE id = ? AND available_seats > 0';
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $affected = $stmt->affected_rows;
        $stmt->close();
        return $affected > 0;
    }

    /**
     * Cancel a reservation (increment available_seats)
     * @param int $id
     * @return bool
     */
    public function cancelReservation(int $id): bool
    {
        $sql = 'UPDATE EVENT SET available_seats = available_seats + 1 WHERE id = ?';
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param('i', $id);
        $ok = $stmt->execute();
        $stmt->close();
        return (bool)$ok;
    }

    /**
     * Simple search by title or description
     * @param string $q
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function search(string $q, int $limit = 50, int $offset = 0): array
    {
        $like = '%' . $q . '%';
        $sql = 'SELECT e.id, e.title, e.description, e.event_date, e.location, e.total_seats, e.available_seats, e.status, e.created_at, e.image, e.user_email, e.category_id, c.name AS category_label'
            . ' FROM EVENT e'
            . ' LEFT JOIN CATEGORY c ON e.category_id = c.id'
            . ' WHERE e.title LIKE ? OR e.description LIKE ?'
            . ' ORDER BY e.event_date'
            . ' LIMIT ? OFFSET ?';
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return [];
        $stmt->bind_param('ssii', $like, $like, $limit, $offset);
        $stmt->execute();
        $res = $stmt->get_result();
        $rows = [];
        while ($row = $res->fetch_assoc()) {
            if (!isset($row['category_label'])) {
                $row['category_label'] = 'Evento';
            }
            $rows[] = $row;
        }
        $stmt->close();
        return $rows;
    }
}
