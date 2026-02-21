<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data_evento = trim($_POST['data_evento'] ?? '');
    $horario_evento = trim($_POST['horario_evento'] ?? '');
    $local_nome = trim($_POST['local_nome'] ?? '');
    $local_endereco = trim($_POST['local_endereco'] ?? '');
    $latitude = trim($_POST['latitude'] ?? '');
    $longitude = trim($_POST['longitude'] ?? '');

    if (empty($data_evento) || empty($horario_evento) || empty($local_nome) || empty($local_endereco)) {
        header("Location: dashboard.php?error=" . urlencode("Por favor, preencha os campos obrigatórios."));
        exit;
    }

    try {
        $stmt = $pdo->query("SELECT id FROM evento_info LIMIT 1");
        $row = $stmt->fetch();

        if ($row) {
            // Update
            $update = $pdo->prepare("UPDATE evento_info SET data_evento = :data, horario_evento = :horario, local_nome = :nome, local_endereco = :endereco, latitude = :lat, longitude = :lng WHERE id = :id");
            $update->execute([
                'data' => $data_evento,
                'horario' => $horario_evento,
                'nome' => $local_nome,
                'endereco' => $local_endereco,
                'lat' => $latitude ?: null,
                'lng' => $longitude ?: null,
                'id' => $row['id']
            ]);
        } else {
            // Insert
            $insert = $pdo->prepare("INSERT INTO evento_info (data_evento, horario_evento, local_nome, local_endereco, latitude, longitude) VALUES (:data, :horario, :nome, :endereco, :lat, :lng)");
            $insert->execute([
                'data' => $data_evento,
                'horario' => $horario_evento,
                'nome' => $local_nome,
                'endereco' => $local_endereco,
                'lat' => $latitude ?: null,
                'lng' => $longitude ?: null
            ]);
        }

        header("Location: dashboard.php?success=" . urlencode("Configurações do evento salvas com sucesso!"));
        exit;
    } catch (\Exception $e) {
        header("Location: dashboard.php?error=" . urlencode("Erro ao salvar as configurações."));
        exit;
    }
} else {
    header("Location: dashboard.php");
    exit;
}
