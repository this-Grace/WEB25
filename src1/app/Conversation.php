<?php

require_once __DIR__ . '/Database.php';

/**
 * Conversation model for handling conversation-related database operations.
 * 
 * This class provides methods for managing conversations and messages.
 */
class Conversation
{
    /**
     * @var mysqli Database connection instance.
     */
    private $db;

    /**
     * Constructor - initializes database connection.
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Get all conversations for a user.
     * 
     * @param string $username Username to get conversations for.
     * @return array Array of conversations with last message info.
     */
    public function getUserConversations(string $username): array
    {
        $stmt = $this->db->prepare(
            "SELECT 
                c.id,
                c.created_at,
                lm.text AS last_message,
                lm.created_at AS last_message_at,
                COALESCE(SUM(CASE WHEN m.is_read = FALSE AND m.sender_username != ? THEN 1 ELSE 0 END), 0) AS unread_count
            FROM conversations c
            JOIN conversation_participants cp 
                ON c.id = cp.conversation_id
            LEFT JOIN messages lm 
                ON lm.id = (
                    SELECT id 
                    FROM messages 
                    WHERE conversation_id = c.id 
                    ORDER BY created_at DESC 
                    LIMIT 1
                )
            LEFT JOIN messages m 
                ON m.conversation_id = c.id
            WHERE cp.user_username = ?
            GROUP BY c.id, c.created_at, lm.text, lm.created_at
            ORDER BY 
                (lm.created_at IS NULL) ASC,
                lm.created_at DESC"
        );

        $stmt->bind_param('ss', $username, $username);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        $result->free();
        $stmt->close();

        return $data;
    }

    /**
     * Find a conversation by ID.
     * 
     * @param int $id Conversation ID.
     * @return array|null Conversation data if found, null otherwise.
     */
    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT id, created_at FROM conversations WHERE id = ? LIMIT 1");
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        $result->free();
        $stmt->close();

        return $data ?: null;
    }

    /**
     * Get participants of a conversation.
     * 
     * @param int $conversationId Conversation ID.
     * @return array Array of usernames participating in the conversation.
     */
    public function getParticipants(int $conversationId): array
    {
        $stmt = $this->db->prepare(
            "SELECT cp.user_username, u.first_name, u.surname, u.avatar_url 
             FROM conversation_participants cp 
             JOIN users u ON cp.user_username = u.username 
             WHERE cp.conversation_id = ?"
        );
        $stmt->bind_param('i', $conversationId);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        $result->free();
        $stmt->close();

        return $data;
    }

    /**
     * Find conversation between two users.
     * 
     * @param string $user1 First username.
     * @param string $user2 Second username.
     * @return int|null Conversation ID if exists, null otherwise.
     */
    public function findBetweenUsers(string $user1, string $user2): ?int
    {
        $stmt = $this->db->prepare(
            "SELECT cp1.conversation_id
             FROM conversation_participants cp1
             JOIN conversation_participants cp2 ON cp1.conversation_id = cp2.conversation_id
             WHERE cp1.user_username = ? AND cp2.user_username = ?
             GROUP BY cp1.conversation_id
             HAVING COUNT(*) = 2
             LIMIT 1"
        );

        $stmt->bind_param('ss', $user1, $user2);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $result->free();
        $stmt->close();

        return $row['conversation_id'] ?? null;
    }

    /**
     * Create a new conversation.
     * 
     * @param array $participants Array of usernames to add as participants.
     * @return int|bool Conversation ID if creation successful, false otherwise.
     */
    public function create(array $participants): int|false
    {
        $this->db->begin_transaction();

        $existing = $this->findBetweenUsers($participants[0], $participants[1]);
        if ($existing) return $existing;

        try {
            $stmt = $this->db->prepare("INSERT INTO conversations () VALUES ()");
            $stmt->execute();
            $conversationId = $this->db->insert_id;
            $stmt->close();

            $stmt = $this->db->prepare("INSERT INTO conversation_participants (conversation_id, user_username) VALUES (?, ?)");
            foreach ($participants as $username) {
                $stmt->bind_param('is', $conversationId, $username);
                $stmt->execute();
            }
            $stmt->close();

            $this->db->commit();
            return $conversationId;
        } catch (Exception $e) {
            $this->db->rollback();
            return false;
        }
    }

    /**
     * Delete a conversation.
     * 
     * @param int $id Conversation ID to delete.
     * @return bool True if deletion successful, false otherwise.
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM conversations WHERE id = ?");
        $stmt->bind_param('i', $id);

        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }
}
