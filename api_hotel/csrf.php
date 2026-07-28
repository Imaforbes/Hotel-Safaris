<?php
/**
 * ==============================================================================
 * SISTEMA DE GESTIÓN HOTELERA "SAFARI'S" - HELPER DE SEGURIDAD CSRF & XSS
 * ==============================================================================
 * Autor: Imanol (@imaforbes)
 * Stack: PHP 8+, Session Tokens
 * Descripción:
 *   Genera y valida tokens CSRF (Cross-Site Request Forgery) para proteger
 *   formularios POST contra solicitudes fraudulentas desde sitios externos.
 * ==============================================================================
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field(): string {
    $token = htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8');
    return '<input type="hidden" name="csrf_token" value="' . $token . '">';
}

function csrf_verify(): bool {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $token_recibido = $_POST['csrf_token'] ?? '';
        $token_sesion = $_SESSION['csrf_token'] ?? '';
        if (empty($token_recibido) || !hash_equals($token_sesion, $token_recibido)) {
            http_response_code(403);
            die('Error de seguridad (403 Forbidden): Token CSRF inválido o expirado. Vuelva a intentar la operación.');
        }
    }
    return true;
}
?>
