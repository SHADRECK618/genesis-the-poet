<?php

require_once "config/db.php";

$name = "GEN-ESIS THE POET";
$email = "admin@genesispoet.com";
$password = "Admin@123";

$hash = password_hash(
    $password,
    PASSWORD_DEFAULT
);

$stmt = $pdo->prepare(
    "SELECT id
     FROM admins
     WHERE email = ?"
);

$stmt->execute([$email]);

$existing = $stmt->fetch();

if ($existing) {

    $stmt = $pdo->prepare(
        "UPDATE admins
         SET name = ?,
             password = ?
         WHERE email = ?"
    );

    $stmt->execute([
        $name,
        $hash,
        $email
    ]);

    echo "Admin account updated successfully.";

} else {

    $stmt = $pdo->prepare(
        "INSERT INTO admins
         (name, email, password)
         VALUES (?, ?, ?)"
    );

    $stmt->execute([
        $name,
        $email,
        $hash
    ]);

    echo "Admin account created successfully.";
}

echo "<br><br>";
echo "Email: " . htmlspecialchars($email);
echo "<br>";
echo "Password: " . htmlspecialchars($password);

?>