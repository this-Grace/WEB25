<?php

require_once __DIR__ . '/Database.php';

/**
 * Message model for handling message-related database operations.
 * 
 * This class provides methods for managing messages within conversations.
 */
class Message
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
     * Get all messages in a conversation.
     * 
     * @param int $conversationId Conversation ID.
     * @return array Array of messages ordered by creation time.
     */
    public function getByConversation(int $conversationId): array
    {
        $stmt = $this->db->prepare(
            "SELECT m.id, m.conversation_id, m.sender_username, m.text, m.created_at, m.is_read,
                    u.first_name, u.surname, u.avatar_url 
             FROM messages m 
             JOIN users u ON m.sender_username = u.username 
             WHERE m.conversation_id = ? 
             ORDER BY m.created_at ASC"
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
     * Find a message by ID.
     * 
     * @param int $id Message ID.
     * @return array|null Message data if found, null otherwise.
     */
    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT id, conversation_id, sender_username, text, created_at, is_read 
             FROM messages 
             WHERE id = ? LIMIT 1"
        );
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        $result->free();
        $stmt->close();

        return $data ?: null;
    }

    /**
     * Create a new message.
     * 
     * @param int $conversationId Conversation ID.
     * @param string $senderUsername Sender's username.
     * @param string $text Message text.
     * @return int|bool Message ID if creation successful, false otherwise.
     */
    public function create(int $conversationId, string $senderUsername, string $text): int|false
    {
        $stmt = $this->db->prepare(
            "INSERT INTO messages (conversation_id, sender_username, text) VALUES (?, ?, ?)"
        );
        $stmt->bind_param('iss', $conversationId, $senderUsername, $text);

        $success = $stmt->execute();
        $messageId = $this->db->insert_id;
        $stmt->close();

        return $success ? $messageId : false;
    }

    /**
     * Mark a message as read.
     * 
     * @param int $id Message ID.
     * @return bool True if successful, false otherwise.
     */
    public function markAsRead(int $id): bool
    {
        $stmt = $this->db->prepare("UPDATE messages SET is_read = TRUE WHERE id = ?");
        $stmt->bind_param('i', $id);

        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    /**
     * Mark all messages in a conversation as read for a user.
     * 
     * @param int $conversationId Conversation ID.
     * @param string $username Username of the reader.
     * @return bool True if successful, false otherwise.
     */
    public function markConversationAsRead(int $conversationId, string $username): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE messages SET is_read = TRUE 
             WHERE conversation_id = ? AND sender_username != ? AND is_read = FALSE"
        );
        $stmt->bind_param('is', $conversationId, $username);

        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    /**
     * Get unread message count for a user.
     * 
     * @param string $username Username to check.
     * @return int Number of unread messages.
     */
    public function getUnreadCount(string $username): int
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) as count 
             FROM messages m
             JOIN conversation_participants cp ON m.conversation_id = cp.conversation_id
             WHERE cp.user_username = ? AND m.sender_username != ? AND m.is_read = FALSE"
        );
        $stmt->bind_param('ss', $username, $username);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $result->free();
        $stmt->close();

        return (int)($row['count'] ?? 0);
    }

    /**
     * Delete a message.
     * 
     * @param int $id Message ID to delete.
     * @return bool True if deletion successful, false otherwise.
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM messages WHERE id = ?");
        $stmt->bind_param('i', $id);

        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }
}
