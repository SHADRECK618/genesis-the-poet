<?php

require_once "../config/db.php";
require_once "../config/auth.php";

requireLogin();

$total = $pdo
    ->query("SELECT COUNT(*) FROM poems")
    ->fetchColumn();

$published = $pdo
    ->query("SELECT COUNT(*) FROM poems WHERE status = 'published'")
    ->fetchColumn();

$drafts = $pdo
    ->query("SELECT COUNT(*) FROM poems WHERE status = 'draft'")
    ->fetchColumn();

$stmt = $pdo->query(
    "SELECT id, title, category, status, created_at
     FROM poems
     ORDER BY created_at DESC
     LIMIT 5"
);

$recentPoems = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="admin.css">

</head>

<body>

<div class="admin-layout">

    <aside class="sidebar">

        <div class="sidebar-logo">
            GEN-<span>ESIS</span>
        </div>

        <p class="sidebar-title">
            THE POET
        </p>

        <nav>

            <a href="dashboard.php" class="active">
                Dashboard
            </a>

            <a href="poems.php">
                Manage Poems
            </a>

            <a href="poem_form.php">
                Add Poem
            </a>

            <a href="../index.html" target="_blank">
                View Website
            </a>

            <a href="logout.php">
                Logout
            </a>

        </nav>

    </aside>


    <main class="admin-main">

        <div class="admin-top">

            <div>

                <p class="admin-label">
                    ADMINISTRATION
                </p>

                <h1>
                    Welcome,
                    <?= e($_SESSION["admin_name"]) ?>
                </h1>

            </div>

            <a
                href="poem_form.php"
                class="admin-button"
            >
                + ADD POEM
            </a>

        </div>


        <div class="stats">

            <div class="stat-card">

                <span>
                    TOTAL POEMS
                </span>

                <strong>
                    <?= $total ?>
                </strong>

            </div>

            <div class="stat-card">

                <span>
                    PUBLISHED
                </span>

                <strong>
                    <?= $published ?>
                </strong>

            </div>

            <div class="stat-card">

                <span>
                    DRAFTS
                </span>

                <strong>
                    <?= $drafts ?>
                </strong>

            </div>

        </div>


        <section class="admin-section">

            <div class="section-top">

                <h2>
                    Recent Poems
                </h2>

                <a href="poems.php">
                    View All
                </a>

            </div>


            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>

                            <th>
                                Title
                            </th>

                            <th>
                                Category
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Date
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php foreach ($recentPoems as $poem): ?>

                        <tr>

                            <td>
                                <?= e($poem["title"]) ?>
                            </td>

                            <td>
                                <?= e($poem["category"]) ?>
                            </td>

                            <td>

                                <span class="status <?= e($poem["status"]) ?>">
                                    <?= ucfirst(e($poem["status"])) ?>
                                </span>

                            </td>

                            <td>
                                <?= date(
                                    "d M Y",
                                    strtotime($poem["created_at"])
                                ) ?>
                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </section>

    </main>

</div>

</body>

</html>