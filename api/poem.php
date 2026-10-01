<?php

require_once "../config/db.php";

header("Content-Type: application/json; charset=utf-8");

try {

    $stmt = $pdo->query(
        "SELECT id, title, category, content, created_at
         FROM poems
         WHERE status = 'published'
         ORDER BY created_at DESC"
    );

    $poems = $stmt->fetchAll();

    echo json_encode(
        $poems,
        JSON_UNESCAPED_UNICODE
    );

} catch (PDOException $e) {

    http_response_code(500);

    echo json_encode([
        "error" => "Unable to load poems."
    ]);

}
?>