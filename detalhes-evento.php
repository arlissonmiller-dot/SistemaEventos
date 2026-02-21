<?php
session_start();
// Opcional: Se desejar permitir que qualquer um veja a página, pode remover essa checagem
// Mas com a checagem, evitamos acessos diretos.
if (!isset($_SESSION['rsvp_nome'])) {
    header("Location: index.php");
    exit;
}
$nome = $_SESSION['rsvp_nome'];

require_once 'includes/db.php';

// Fetch event info (assuming 1st row contains configurations)
$stmt = $pdo->query("SELECT * FROM evento_info LIMIT 1");
$evento_info = $stmt->fetch();

// Format date and time if available
$data_formatada = "Data a definir";
$hora_formatada = "Horário a definir";
if ($evento_info) {
    if (!empty($evento_info['data_evento'])) {
        $data_obj = new DateTime($evento_info['data_evento']);
        $formatter = new IntlDateFormatter('pt_BR', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
        $data_formatada = $formatter->format($data_obj);
    }

    if (!empty($evento_info['horario_evento'])) {
        $horario_obj = new DateTime($evento_info['horario_evento']);
        $hora_formatada = $horario_obj->format('H\hi');
    }

    $local_nome = $evento_info['local_nome'] ?? 'Local a definir';
    $local_endereco = $evento_info['local_endereco'] ?? 'Endereço a definir';

    $lat = $evento_info['latitude'] ?? '-23.563099467540203';
    $lng = $evento_info['longitude'] ?? '-46.656571584346764';
} else {
    // Falbacks if empty
    $data_formatada = "25 de março de 2026";
    $hora_formatada = "19h30";
    $local_nome = "Espaço Eventos Jardim";
    $local_endereco = "Rua Exemplo, 123 – Centro";
    $lat = "-23.563099467540203";
    $lng = "-46.656571584346764";
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Evento</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container">
        <header>
            <h1>Obrigado por confirmar presença,<br><strong>
                    <?php echo htmlspecialchars($nome); ?>!
                </strong></h1>
        </header>

        <main class="card">
            <h2>Informações do Evento</h2>
            <ul class="event-details">
                <li><strong>Data do evento:</strong> <?php echo htmlspecialchars($data_formatada); ?></li>
                <li><strong>Horário:</strong> Início às <?php echo htmlspecialchars($hora_formatada); ?></li>
                <li><strong>Local:</strong>
                    <?php echo htmlspecialchars($local_nome); ?><br><small><?php echo htmlspecialchars($local_endereco); ?></small>
                </li>
            </ul>

            <div class="map-container">
                <iframe
                    src="https://maps.google.com/maps?q=<?php echo urlencode($lat); ?>,<?php echo urlencode($lng); ?>&hl=pt&z=15&output=embed"
                    width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </main>
    </div>
</body>

</html>