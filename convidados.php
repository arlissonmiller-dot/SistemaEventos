<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_login();

$search = trim($_GET['search'] ?? '');

try {
    if ($search !== '') {
        $stmt = $pdo->prepare("SELECT id, nome_completo, data_confirmacao FROM convidados WHERE nome_completo LIKE :search ORDER BY data_confirmacao DESC");
        $stmt->execute(['search' => '%' . $search . '%']);
    } else {
        $stmt = $pdo->query("SELECT id, nome_completo, data_confirmacao FROM convidados ORDER BY data_confirmacao DESC");
    }

    $convidados = $stmt->fetchAll();
} catch (\Exception $e) {
    die("Erro ao buscar convidados.");
}
?>
<?php include 'includes/admin_header.php'; ?>

<div class="dashboard-header">
    <h1>Lista de Presenças</h1>
    <a href="convidados.php" class="btn btn-outline btn-sm"><i class="fas fa-sync-alt"></i> Atualizar</a>
</div>

<div class="card card-table">
    <form action="convidados.php" method="GET" class="search-box">
        <input type="text" name="search" placeholder="Buscar por nome..."
            value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Buscar</button>
        <?php if ($search !== ''): ?>
            <a href="convidados.php" class="btn btn-outline btn-sm"><i class="fas fa-times"></i></a>
        <?php endif; ?>
    </form>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome Completo</th>
                    <th>Data e Hora da Confirmação</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($convidados) > 0): ?>
                    <?php foreach ($convidados as $convidado): ?>
                        <tr>
                            <td>#
                                <?php echo htmlspecialchars($convidado['id']); ?>
                            </td>
                            <td><strong>
                                    <?php echo htmlspecialchars($convidado['nome_completo']); ?>
                                </strong></td>
                            <td>
                                <?php echo date('d/m/Y \à\s H:i', strtotime($convidado['data_confirmacao'])); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 30px;">
                            <i class="fas fa-inbox fa-3x" style="color: #ccc; margin-bottom: 10px;"></i><br>
                            Nenhum convidado encontrado.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>