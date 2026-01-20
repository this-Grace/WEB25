<?php

/**
 * Generate or retrieve CSRF token
 */
function generateCsrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validate CSRF token
 */
function isValidCsrf(?string $token): bool
{
    return !empty($token) && hash_equals($_SESSION['csrf_token'] ?? '', $token);
}

/**
 * Set flash message
 */
function setFlashMessage(string $type, string $message): void
{
    $_SESSION['flash'][$type] = $message;
}

/**
 * Get and clear flash message
 */
function getFlashMessage(string $type): ?string
{
    $message = $_SESSION['flash'][$type] ?? null;
    unset($_SESSION['flash'][$type]);
    return $message;
}

/**
 * Redirect to URL
 */
function redirect(string $url): void
{
    header("Location: $url");
    exit;
}

/**
 * Format errors array to HTML list
 */
function formatErrors(array $errors): string
{
    if (count($errors) === 1) {
        return htmlspecialchars($errors[0]);
    }
    $html = '<ul class="mb-0">';
    foreach ($errors as $error) {
        $html .= '<li>' . htmlspecialchars($error) . '</li>';
    }
    $html .= '</ul>';
    return $html;
}

/**
 * Validate email format
 */
function isValidEmail(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate password strength
 */
function isValidPassword(string $password): bool
{
    return strlen($password) >= 8;
}

/**
 * Validate username format
 */
function isValidUsernameFormat(string $username): bool
{
    return preg_match('/^[a-zA-Z0-9_]+$/', $username) === 1;
}

/**
 * Hash password
 */
function hashPassword(string $password): string
{
    return password_hash($password, PASSWORD_ARGON2ID);
}

/**
 * Verify password
 */
function verifyPassword(string $password, string $hash): bool
{
    return password_verify($password, $hash);
}

/**
 * Sanitize HTML output
 */
function e(?string $string): string
{
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Check if user is logged in
 */
function isLoggedIn(): bool
{
    return !empty($_SESSION['user_id']);
}

/**
 * Require authentication
 */
function requireAuth(): void
{
    if (!isLoggedIn()) {
        redirect('login.php');
    }
}

/**
 * Redirect if authenticated
 */
function redirectIfAuth(string $url = 'index.php'): void
{
    if (isLoggedIn()) {
        redirect($url);
    }
}
