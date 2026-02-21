<?php
// includes/db.php

$host = 'localhost';
$db = 'evento_rsvp'; // Nome do banco de dados
$user = 'root';        // Usuário do banco de dados (alterar conforme ambiente)
$pass = 'NovaSenhaForte123';            // Senha do banco de dados (alterar conforme ambiente)
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Ativa exceções para erros
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Retorna resultados como array associativo
    PDO::ATTR_EMULATE_PREPARES => false,                  // Usa prepares reais
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Erro de conexão ao banco de dados: " . $e->getMessage());
}
?>