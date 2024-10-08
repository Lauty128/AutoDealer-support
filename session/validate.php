<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['valid'])) {
    // Si no hay sesión, redirigir al login
    header("Location: /login");
    exit();
}

// Si hay sesión, continúa con la aplicación
?>