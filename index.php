<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de Presença – Casamento João e Maria</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container public-page">
        <header>
            <h1>Confirmação de Presença – Casamento João e Maria</h1>
        </header>

        <main>
            <p class="welcome-text">Estamos muito felizes em celebrar este momento especial com você. Por favor,
                confirme sua presença abaixo.</p>

            <form action="confirmar.php" method="POST" id="rsvp-form" class="card">
                <?php
                if (isset($_GET['error'])) {
                    echo '<div class="alert alert-error">Erro: ' . htmlspecialchars($_GET['error']) . '</div>';
                }
                ?>
                <div class="form-group">
                    <label for="nome_completo">Nome completo *</label>
                    <input type="text" id="nome_completo" name="nome_completo" placeholder="Digite seu nome completo"
                        required>
                    <span class="error-msg" id="name-error"></span>
                </div>

                <button type="submit" class="btn btn-primary" id="btn-confirmar">
                    <span id="btn-text">Confirmar presença</span>
                </button>
            </form>
        </main>
    </div>

    <script src="js/script.js"></script>
</body>

</html>