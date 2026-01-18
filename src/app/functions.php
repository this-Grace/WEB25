<?php
/**
 * Helper functions for common operations
 */

/**
 * Requires user to be logged in
 * 
 * Redirects to login page if user is not authenticated.
 */
function requireLogin(): void
{
    if (empty($_SESSION['username'])) {
        // setFlashMessage('error', 'Devi essere loggato per accedere a questa pagina.');
        redirect('login.php');
    }
}

/**
 * Generates and returns a CSRF token
 * 
 * Creates a cryptographically secure token if one doesn't exist,
 * otherwise returns the existing token from session.
 * 
 * @return string CSRF token
 */
function generateCsrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validates a CSRF token against the session token
 * 
 * Uses hash_equals() for timing-attack safe comparison.
 * 
 * @param string|null $token Token from form submission
 * @return bool True if token is valid, false otherwise
 */
function isValidCsrf(?string $token): bool
{
    return $token !== null
        && isset($_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Checks if a string contains only allowed username characters
 * 
 * @param string $username Username to validate
 * @return bool True if username format is valid
 */
function isValidUsernameFormat(string $username): bool
{
    return preg_match('/^[a-zA-Z0-9_]+$/', $username) === 1;
}

/**
 * Validates password strength
 * 
 * @param string $password Password to validate
 * @param int $minLength Minimum password length (default: 8)
 * @return bool True if password meets requirements
 */
function isValidPassword(string $password, int $minLength = 8): bool
{
    return strlen($password) >= $minLength;
}

/**
 * Validates email format
 * 
 * @param string $email Email to validate
 * @return bool True if email format is valid
 */
function isValidEmail(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Redirects to a specified URL
 * 
 * @param string $url URL to redirect to
 * @param int $statusCode HTTP status code (default: 302)
 * @return void
 */
function redirect(string $url, int $statusCode = 302): void
{
    header("Location: $url", true, $statusCode);
    exit;
}

/**
 * Formats error messages for display
 * 
 * Converts array of errors to HTML with proper spacing
 * 
 * @param array $errors Array of error messages
 * @return string Formatted HTML errors
 */
function formatErrors(array $errors): string
{
    if (empty($errors)) {
        return '';
    }

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
 * Sets a flash message in session
 * 
 * @param string $type Message type (e.g., 'success', 'error')
 * @param string $message Message content
 * @return void
 */
function setFlashMessage(string $type, string $message): void
{
    $_SESSION['flash_messages'][$type] = $message;
}

/**
 * Retrieves and clears a flash message from session
 * 
 * @param string $type Message type to retrieve
 * @return string|null Message content or null if not set
 */
function getFlashMessage(string $type): ?string
{
    if (!empty($_SESSION['flash_messages'][$type])) {
        $msg = $_SESSION['flash_messages'][$type];
        unset($_SESSION['flash_messages'][$type]);
        return $msg;
    }
    return null;
}
