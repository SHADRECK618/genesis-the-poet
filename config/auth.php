<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function requireLogin()
{
    if (empty($_SESSION["admin_id"])) {
        header("Location: login.php");
        exit;
    }
}

function e($value)
{
    return htmlspecialchars(
        $value ?? "",
        ENT_QUOTES,
        "UTF-8"
    );
}
?>