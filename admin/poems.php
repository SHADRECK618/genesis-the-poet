<?php

require_once "../config/db.php";
require_once "../config/auth.php";

requireLogin();

if (isset($_GET["delete"])) {

    $id = (int) $_GET["delete"];

    if ($id > 0) {

        $stmt = $pdo->prepare(
            "DELETE FROM poems WHERE id = ?"
        );

        $stmt->execute([$id]);
    }

    header("Location: poems.php");
    exit;
}

$stmt = $pdo->query(
    "SELECT id, title, category, status, created_at, updated_at
     FROM poems
     ORDER BY created_at DESC"
);

$poems = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Manage Poems</title>

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

            <a href="dashboard.php">
                Dashboard
            </a>

            <a href="poems.php" class="active">
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
                    POETRY MANAGEMENT
                </p>

                <h1>
                    Your Poems
                </h1>

            </div>

            <a
                href="poem_form.php"
                class="admin-button"
            >
                + ADD POEM
            </a>

        </div>


        <section class="admin-section">

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
                                Created
                            </th>

                            <th>
                                Actions
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php if (!$poems): ?>

                        <tr>

                            <td colspan="5">
                                No poems found.
                            </td>

                        </tr>

                    <?php endif; ?>


                    <?php foreach ($poems as $poem): ?>

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

                            <td class="actions">

                                <a
                                    href="poem_form.php?id=<?= $poem["id"] ?>"
                                >
                                    Edit
                                </a>

                                <a
                                    href="poems.php?delete=<?= $poem["id"] ?>"
                                    onclick="return confirm('Delete this poem?')"
                                    class="delete"
                                >
                                    Delete
                                </a>

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