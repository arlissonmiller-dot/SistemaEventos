<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_login();

// Count total guests
$stmt = $pdo->query("SELECT COUNT(*) as total FROM convidados");
$total_convidados = $stmt->fetch()['total'];

// Fetch event info
$stmt = $pdo->query("SELECT * FROM evento_info LIMIT 1");
$evento_info = $stmt->fetch();

// Event date for countdown
// Formatting date and time for Javascript: YYYY-MM-DDTHH:MM:SS
$event_date_format = '2026-03-25T19:30:00'; // Default fallback
if ($evento_info && !empty($evento_info['data_evento']) && !empty($evento_info['horario_evento'])) {
    $event_date_format = $evento_info['data_evento'] . 'T' . $evento_info['horario_evento'];
}
?>
<?php include 'includes/admin_header.php'; ?>

<div class="dashboard-header">
    <h1>Visão Geral</h1>
</div>

<div class="dashboard-grid">
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-users"></i></div>
        <div class="stat-content">
            <h3>Total de Confirmados</h3>
            <div class="stat-value"><?php echo $total_convidados; ?> <small>pessoas</small></div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-clock"></i></div>
        <div class="stat-content">
            <h3>Contagem Regressiva</h3>
            <div class="stat-value" id="countdown">Carregando...</div>
        </div>
    </div>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success"
        style="background-color: #d1e7dd; color: #0f5132; border: 1px solid #badbcc; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
        <?php echo htmlspecialchars($_GET['success']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-error">
        <?php echo htmlspecialchars($_GET['error']); ?>
    </div>
<?php endif; ?>

<div class="dashboard-header" style="margin-top: 40px;">
    <h1>Configurar Evento</h1>
</div>

<div class="card" style="margin-bottom: 30px;">
    <form action="salvar_evento.php" method="POST">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div class="form-group custom-field full-width" style="margin-bottom: 0;">
                <label for="data_evento">Data do Evento *</label>
                <input type="date" id="data_evento" name="data_evento"
                    value="<?php echo htmlspecialchars($evento_info['data_evento'] ?? '2026-03-25'); ?>" required>
            </div>
            <div class="form-group custom-field full-width" style="margin-bottom: 0;">
                <label for="horario_evento">Horário de Início *</label>
                <input type="time" id="horario_evento" name="horario_evento"
                    value="<?php echo htmlspecialchars($evento_info['horario_evento'] ?? '19:30'); ?>" required>
            </div>
        </div>

        <div class="form-group custom-field full-width">
            <label for="local_nome">Nome do Local *</label>
            <input type="text" id="local_nome" name="local_nome" placeholder="Ex: Espaço Eventos Jardim"
                value="<?php echo htmlspecialchars($evento_info['local_nome'] ?? 'Espaço Eventos Jardim'); ?>" required>
        </div>

        <div class="form-group custom-field full-width">
            <label for="local_endereco">Endereço Completo *</label>
            <input type="text" id="local_endereco" name="local_endereco" placeholder="Ex: Rua Exemplo, 123 – Centro"
                value="<?php echo htmlspecialchars($evento_info['local_endereco'] ?? 'Rua Exemplo, 123 – Centro'); ?>"
                required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div class="form-group custom-field full-width" style="margin-bottom: 0;">
                <label for="latitude">Latitude (Google Maps)</label>
                <input type="text" id="latitude" name="latitude" placeholder="Ex: -23.563099"
                    value="<?php echo htmlspecialchars($evento_info['latitude'] ?? '-23.563099467540203'); ?>">
                <small class="help-text">Opcional. Usado para centralizar o mapa.</small>
            </div>
            <div class="form-group custom-field full-width" style="margin-bottom: 0;">
                <label for="longitude">Longitude (Google Maps)</label>
                <input type="text" id="longitude" name="longitude" placeholder="Ex: -46.656571"
                    value="<?php echo htmlspecialchars($evento_info['longitude'] ?? '-46.656571584346764'); ?>">
                <small class="help-text">Opcional. Usado para centralizar o mapa.</small>
            </div>
        </div>

        <button type="submit" class="btn btn-primary" style="width: auto; padding: 10px 20px;">
            <i class="fas fa-save"></i> Salvar Configurações
        </button>
    </form>
</div>

<script>
    const eventDate = new Date('<?php echo $event_date_format; ?>').getTime();
    const countdownEl = document.getElementById('countdown');

    setInterval(() => {
        const now = new Date().getTime();
        const distance = eventDate - now;

        if (distance < 0) {
            countdownEl.innerHTML = "O evento já começou!";
            return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        countdownEl.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s";
    }, 1000);
</script>

<?php include 'includes/admin_footer.php'; ?>