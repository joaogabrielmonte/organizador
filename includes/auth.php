<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function checkLogin() {
    if (!isset($_SESSION['usuario'])) {
        header("Location: ../controllers/login.php");
        exit;
    }
}
