<?php

require_once "../config/db.php";

session_start();

if (!empty($_SESSION["admin_id"])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($email === "" || $password === "") {

        $error = "Please enter your email and password.";

    } else {

        $stmt = $pdo->prepare(
            "SELECT id, name, email, password
             FROM admins
             WHERE email = ?
             LIMIT 1"
        );

        $stmt->execute([$email]);

        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin["password"])) {

            session_regenerate_id(true);

            $_SESSION["admin_id"] = $admin["id"];
            $_SESSION["admin_name"] = $admin["name"];
            $_SESSION["admin_email"] = $admin["email"];

            header("Location: dashboard.php");
            exit;

        } else {

            $error = "Invalid email or password.";

        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>GEN-ESIS Admin Login</title>

    <link rel="stylesheet" href="admin.css">

</head>

<body class="login-page">

<div class="login-box">

    <div class="admin-brand">
        GEN-<span>ESIS</span>
    </div>

    <p class="admin-label">
        THE POET ADMINISTRATION
    </p>

    <?php if ($error): ?>

        <div class="error">
            <?= htmlspecialchars($error) ?>
        </div>

    <?php endif; ?>

    <form method="POST">

        <label>Email</label>

        <input
            type="email"
            name="email"
            placeholder="admin@genesispoet.com"
            required
        >

        <label>Password</label>

        <input
            type="password"
            name="password"
            placeholder="Enter password"
            required
        >

        <button type="submit">
            LOGIN
        </button>

    </form>

    <a
        href="../index.html"
        class="back-link"
    >
        ← Back to website
    </a>

</div>

</body>

</html>