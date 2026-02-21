<?php
session_start();
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome_completo'] ?? '');

    if (empty($nome)) {
        header("Location: index.php?error=" . urlencode("O nome é obrigatório."));
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO convidados (nome_completo, data_confirmacao) VALUES (:nome, NOW())");
        $stmt->execute(['nome' => $nome]);

        // Redireciona para a página de detalhes com sucesso
        $_SESSION['rsvp_nome'] = $nome;
        header("Location: detalhes-evento.php");
        exit;
    } catch (\Exception $e) {
        header("Location: index.php?error=" . urlencode("Erro ao salvar confirmação. Tente novamente."));
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
