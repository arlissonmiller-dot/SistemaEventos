<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_login();

// Count total guests
$stmt = $pdo->query("SELECT COUNT(*) as total FROM convidados");
$total_convidados = $stmt->fetch()['total'];

// Event date for countdown
$event_date = '2026-03-25T19:30:00';
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

<script>
    const eventDate = new Date('<?php echo $event_date; ?>').getTime();
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