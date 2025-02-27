<?php
$host = getenv('DB_HOST') ?: 'mysql-g23g-production.up.railway.app';
$db   = getenv('DB_DATABASE') ?: 'railway';
$user = getenv('DB_USERNAME') ?: 'root';
$pass = getenv('DB_PASSWORD') ?: 'OXIKabdHfQFCRRbGYBhzRrUKhTGwxDea';
$port = getenv('DB_PORT') ?: '3306';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8", $user, $pass);
    echo "✅ Connexion réussie à la base de données !";
} catch (PDOException $e) {
    echo "❌ Erreur de connexion : " . $e->getMessage();
}