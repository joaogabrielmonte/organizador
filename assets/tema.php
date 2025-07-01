<?php
session_start();
$_SESSION['tema'] = ($_SESSION['tema'] ?? 'dark') === 'dark' ? 'light' : 'dark';
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
