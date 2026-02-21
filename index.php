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
                <div class="form-group custom-field full-width">
                    <label for="nome_completo">Nome completo</label>
                    <input type="text" id="nome_completo" name="nome_completo" placeholder="Insira seu nome completo" required>
                    <span class="error-msg" id="name-error"></span>
                </div>

                <div class="form-group custom-field row-field">
                    <label>Você irá ao evento?</label>
                    <div class="radio-group">
                        <label class="radio-box">
                            <input type="radio" name="presenca" value="sim" required>
                            <span>sim</span>
                        </label>
                        <label class="radio-box">
                            <input type="radio" name="presenca" value="não">
                            <span>não</span>
                        </label>
                    </div>
                </div>

                <div class="form-group custom-field row-field">
                    <label for="adultos">Quantidade de adultos incluindo você</label>
                    <div class="select-wrapper">
                        <select name="adultos" id="adultos">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                    </div>
                </div>

                <div class="form-group custom-field row-field">
                    <label for="criancas">Quantidade de crianças</label>
                    <div class="select-wrapper">
                        <select name="criancas" id="criancas">
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                    </div>
                </div>

                <div class="form-group custom-field full-width">
                    <label for="email">E-mail</label>
                    <p class="help-text">Você receberá a confirmação de presença neste e-mail.</p>
                    <input type="email" id="email" name="email" placeholder="exemplo@email.com" required>
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