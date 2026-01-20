<?php

require_once __DIR__ . '/Database.php';

/**
 * Post model for handling post-related database operations.
 * 
 * This class provides methods for CRUD operations on post records,
 * including creating, retrieving, updating, and deleting posts.
 */
class Post
{
    /**
     * @var mysqli Database connection instance.
     */
    private $db;

    /**
     * Constructor - initializes database connection.
     * 
     * Uses the Singleton Database class to establish a database connection.
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Retrieve all posts from the database.
     * 
     * @return array Array of post records, each as an associative array.
     *               Returns empty array if no posts found or query fails.
     */
    public function all(): array
    {
        $query = "SELECT id, user_username, title, content, num_collaborators, skills_required, created_at, status FROM posts ORDER BY created_at DESC";
        $result = $this->db->query($query);

        if (!$result) return [];

        $data = $result->fetch_all(MYSQLI_ASSOC);
        $result->free();

        return $data;
    }

    /**
     * Count total number of posts.
     * 
     * @return int Total post count.
     */
    public function count(): int
    {
        $result = $this->db->query("SELECT COUNT(*) as count FROM posts");
        if (!$result) return 0;

        $count = $result->fetch_assoc()['count'] ?? 0;
        $result->free();

        return (int)$count;
    }

    /**
     * Count total number of posts pending approval.
     * 
     * @return int Total pending posts count.
     */
    public function countPending(): int
    {
        $result = $this->db->query("SELECT COUNT(*) as count FROM posts WHERE status = 'Pendente'");
        if (!$result) return 0;

        $count = $result->fetch_assoc()['count'] ?? 0;
        $result->free();

        return (int)$count;
    }

    /**
     * 
     * @param int $id The post ID to search for.
     * @return array|null Associative array containing post data if found, null otherwise.
     */
    public function find($id): ?array
    {
        $stmt = $this->db->prepare("SELECT id, user_username, title, content, num_collaborators, skills_required, created_at, status FROM posts WHERE id = ? LIMIT 1");
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        $result->free();
        $stmt->close();

        return $data ?: null;
    }

    /**
     * Create a new post record.
     * 
     * @param string $username Username of the post author.
     * @param string $title Post title.
     * @param string $content Post content/description.
     * @param int $numCollaborators Number of collaborators needed.
     * @param string $skillsRequired Required skills (comma-separated or text).
     * @return int|bool Post ID if creation successful, false otherwise.
     */
    public function create($username, $title, $content, $numCollaborators, $skillsRequired = null): int|false
    {
        $stmt = $this->db->prepare("INSERT INTO posts (user_username, title, content, num_collaborators, skills_required) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssi', $username, $title, $content, $numCollaborators, $skillsRequired);

        $success = $stmt->execute();
        $postId = $this->db->insert_id;
        $stmt->close();

        return $success ? $postId : false;
    }

    /**
     * Update a post record.
     * 
     * @param int $id Post ID to update.
     * @param string $title Updated post title.
     * @param string $content Updated post content.
     * @param int $numCollaborators Updated number of collaborators needed.
     * @param string $skillsRequired Updated required skills.
     * @return bool True if update successful, false otherwise.
     */
    public function update($id, $title, $content, $numCollaborators, $skillsRequired = null): bool
    {
        $stmt = $this->db->prepare("UPDATE posts SET title = ?, content = ?, num_collaborators = ?, skills_required = ? WHERE id = ?");
        $stmt->bind_param('ssssi', $title, $content, $numCollaborators, $skillsRequired, $id);

        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    /**
     * Delete a post from the database.
     * 
     * @param int $id Post ID to delete.
     * @return bool True if deletion successful, false otherwise.
     */
    public function delete($id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM posts WHERE id = ?");
        $stmt->bind_param('i', $id);

        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    /**
     * Add a reaction (like or skip) to a post.
     * 
     * @param int $postId The ID of the post to react to.
     * @param string $username Username of the user reacting.
     * @param string $type Type of reaction ('like' or 'skip').
     * @return bool True if reaction was successfully added/updated, false otherwise.
     */
    public function react($postId, $username, $type): bool
    {
        if (!in_array($type, ['like', 'skip'])) return false;

        $stmt = $this->db->prepare(
            "REPLACE INTO reactions (user_username, post_id, reaction_type) VALUES (?, ?, ?)"
        );
        $stmt->bind_param('sis', $username, $postId, $type);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    /**
     * Get reaction counts for a specific post.
     * 
     * @param int $postId The ID of the post to get reactions for.
     * @return array Associative array with reaction counts: ['like' => count, 'skip' => count]
     */
    public function getReactions($postId): array
    {
        $stmt = $this->db->prepare(
            "SELECT reaction_type, COUNT(*) as count 
             FROM reactions WHERE post_id = ? GROUP BY reaction_type"
        );
        $stmt->bind_param('i', $postId);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        $result->free();
        $stmt->close();

        $reactions = ['like' => 0, 'skip' => 0];
        foreach ($data as $row) {
            $reactions[$row['reaction_type']] = (int)$row['count'];
        }

        return $reactions;
    }

    /**
     * Get users who liked a specific post.
     * 
     * @param int $postId The ID of the post.
     * @return array Array of users who liked the post, each with username and name.
     */
    public function getLikedByUsers($postId): array
    {
        $stmt = $this->db->prepare(
            "SELECT u.username, u.name, u.avatar 
             FROM reactions r
             JOIN users u ON r.user_username = u.username
             WHERE r.post_id = ? AND r.reaction_type = 'like'
             ORDER BY r.created_at DESC"
        );
        $stmt->bind_param('i', $postId);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        $result->free();
        $stmt->close();

        return $data;
    }

    /**
     * Get user's reaction to a specific post.
     * 
     * @param int $postId The ID of the post.
     * @param string $username Username of the user.
     * @return string|null Reaction type ('like' or 'skip') or null if no reaction.
     */
    public function getUserReaction($postId, $username): ?string
    {
        $stmt = $this->db->prepare(
            "SELECT reaction_type FROM reactions WHERE post_id = ? AND user_username = ? LIMIT 1"
        );
        $stmt->bind_param('is', $postId, $username);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $result->free();
        $stmt->close();

        return $row['reaction_type'] ?? null;
    }

    /**
     * Get the next post for a user that they haven't reacted to yet.
     * Only returns posts with 'Approvato' status.
     * 
     * @param string $username Username of the user.
     * @return array|null The next post data or null if none available.
     */
    public function nextPost($username): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT p.id, p.user_username, p.title, p.content, p.num_collaborators, p.skills_required, p.created_at,
                f.name AS degree_course
            FROM posts p
            INNER JOIN users u ON p.user_username = u.username
            LEFT JOIN faculties f ON u.faculty_id = f.id
            LEFT JOIN reactions r ON p.id = r.post_id AND r.user_username = ?
            WHERE p.user_username != ? AND r.post_id IS NULL AND p.status = 'Approvato'
            ORDER BY p.created_at DESC
            LIMIT 1"
        );
        $stmt->bind_param('ss', $username, $username);
        $stmt->execute();

        $result = $stmt->get_result();
        $post = $result->fetch_assoc();

        $result->free();
        $stmt->close();

        return $post ?: null;
    }

    /**
     * Calculate monthly growth percentage.
     * 
     * @return int Growth percentage compared to last month.
     */
    public function getMonthlyGrowth(): int
    {
        $now = new DateTime();
        $thisMonthStart = $now->format('Y-m-01');
        $lastMonthStart = (new DateTime($now->format('Y-m-01') . ' -1 month'))->format('Y-m-01');
        $lastMonthEnd = (new DateTime($now->format('Y-m-01') . ' -1 day'))->format('Y-m-d');

        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM posts WHERE DATE(created_at) >= ?");
        $stmt->bind_param('s', $thisMonthStart);
        $stmt->execute();
        $thisMonthCount = $stmt->get_result()->fetch_assoc()['count'] ?? 0;
        $stmt->close();

        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM posts WHERE DATE(created_at) >= ? AND DATE(created_at) <= ?");
        $stmt->bind_param('ss', $lastMonthStart, $lastMonthEnd);
        $stmt->execute();
        $lastMonthCount = $stmt->get_result()->fetch_assoc()['count'] ?? 0;
        $stmt->close();

        return $lastMonthCount > 0 ? round((($thisMonthCount - $lastMonthCount) / $lastMonthCount) * 100) : 0;
    }
}
