<?php
session_start();
// Opcional: Se desejar permitir que qualquer um veja a página, pode remover essa checagem
// Mas com a checagem, evitamos acessos diretos.
if (!isset($_SESSION['rsvp_nome'])) {
    header("Location: index.php");
    exit;
}
$nome = $_SESSION['rsvp_nome'];
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
                <li><strong>Data do evento:</strong> 25 de março de 2026</li>
                <li><strong>Horário:</strong> Início às 19h30</li>
                <li><strong>Local:</strong> Espaço Eventos Jardim<br><small>Rua Exemplo, 123 – Centro</small></li>
            </ul>

            <div class="map-container">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3657.1492723789523!2d-46.656571584346764!3d-23.563099467540203!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce59c8da0aa315%3A0xd59f9431f2c9776a!2sAv.%20Paulista%2C%20S%C3%A3o%20Paulo%20-%20SP!5e0!3m2!1spt-BR!2sbr!4v1614050000000!5m2!1spt-BR!2sbr"
                    width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </main>
    </div>
</body>

</html>