<?php

require_once "../config/db.php";
require_once "../config/auth.php";

requireLogin();

$id = isset($_GET["id"])
    ? (int) $_GET["id"]
    : 0;

$title = "";
$category = "";
$content = "";
$status = "draft";

$error = "";

if ($id > 0) {

    $stmt = $pdo->prepare(
        "SELECT *
         FROM poems
         WHERE id = ?"
    );

    $stmt->execute([$id]);

    $poem = $stmt->fetch();

    if (!$poem) {

        header("Location: poems.php");
        exit;

    }

    $title = $poem["title"];
    $category = $poem["category"];
    $content = $poem["content"];
    $status = $poem["status"];
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = trim($_POST["title"] ?? "");
    $category = trim($_POST["category"] ?? "");
    $content = trim($_POST["content"] ?? "");
    $status = $_POST["status"] ?? "draft";

    if ($title === "" || $category === "" || $content === "") {

        $error = "Please complete all fields.";

    } elseif (!in_array($status, ["draft", "published"])) {

        $error = "Invalid poem status.";

    } else {

        if ($id > 0) {

            $stmt = $pdo->prepare(
                "UPDATE poems
                 SET title = ?,
                     category = ?,
                     content = ?,
                     status = ?
                 WHERE id = ?"
            );

            $stmt->execute([
                $title,
                $category,
                $content,
                $status,
                $id
            ]);

        } else {

            $stmt = $pdo->prepare(
                "INSERT INTO poems
                 (title, category, content, status)
                 VALUES (?, ?, ?, ?)"
            );

            $stmt->execute([
                $title,
                $category,
                $content,
                $status
            ]);
        }

        header("Location: poems.php");
        exit;
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

    <title>
        <?= $id > 0 ? "Edit Poem" : "Add Poem" ?>
    </title>

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

            <a href="poems.php">
                Manage Poems
            </a>

            <a href="poem_form.php" class="active">
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
                    POETRY EDITOR
                </p>

                <h1>
                    <?= $id > 0 ? "Edit Poem" : "Add New Poem" ?>
                </h1>

            </div>

        </div>


        <section class="form-section">

            <?php if ($error): ?>

                <div class="error">
                    <?= e($error) ?>
                </div>

            <?php endif; ?>


            <form method="POST">

                <div class="form-group">

                    <label>
                        Poem Title
                    </label>

                    <input
                        type="text"
                        name="title"
                        value="<?= e($title) ?>"
                        placeholder="Enter poem title"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        Category
                    </label>

                    <select
                        name="category"
                        required
                    >

                        <option value="">
                            Select category
                        </option>

                        <?php

                        $categories = $pdo
                            ->query(
                                "SELECT name
                                 FROM categories
                                 ORDER BY name"
                            )
                            ->fetchAll();

                        foreach ($categories as $cat):

                        ?>

                            <option
                                value="<?= e($cat["name"]) ?>"
                                <?= $category === $cat["name"]
                                    ? "selected"
                                    : "" ?>
                            >
                                <?= e($cat["name"]) ?>
                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>


                <div class="form-group">

                    <label>
                        Poem
                    </label>

                    <textarea
                        name="content"
                        rows="16"
                        placeholder="Write your poem here..."
                        required
                    ><?= e($content) ?></textarea>

                </div>


                <div class="form-group">

                    <label>
                        Status
                    </label>

                    <select name="status">

                        <option
                            value="draft"
                            <?= $status === "draft"
                                ? "selected"
                                : "" ?>
                        >
                            Draft — Private
                        </option>

                        <option
                            value="published"
                            <?= $status === "published"
                                ? "selected"
                                : "" ?>
                        >
                            Published — Visible to Visitors
                        </option>

                    </select>

                </div>


                <div class="form-actions">

                    <button
                        type="submit"
                        class="admin-button"
                    >
                        <?= $id > 0
                            ? "UPDATE POEM"
                            : "SAVE POEM" ?>
                    </button>

                    <a
                        href="poems.php"
                        class="cancel-button"
                    >
                        CANCEL
                    </a>

                </div>

            </form>

        </section>

    </main>

</div>

</body>

</html>