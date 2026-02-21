<?php
session_start();
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome_completo'] ?? '');
    $presenca = trim($_POST['presenca'] ?? '');
    $adultos = isset($_POST['adultos']) ? (int) $_POST['adultos'] : 0;
    $criancas = isset($_POST['criancas']) ? (int) $_POST['criancas'] : 0;
    $email = trim($_POST['email'] ?? '');

    if (empty($nome) || empty($presenca) || empty($email)) {
        header("Location: index.php?error=" . urlencode("Por favor, preencha todos os campos obrigatórios."));
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO convidados (nome_completo, presenca, adultos, criancas, email, data_confirmacao) VALUES (:nome, :presenca, :adultos, :criancas, :email, NOW())");
        $stmt->execute([
            'nome' => $nome,
            'presenca' => $presenca,
            'adultos' => $adultos,
            'criancas' => $criancas,
            'email' => $email
        ]);

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
