<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_login();

$msg = '';
$error = '';

// Add new admin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $nome = trim($_POST['nome'] ?? '');
    $usuario = trim($_POST['usuario'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (empty($nome) || empty($usuario) || empty($senha)) {
        $error = 'Todos os campos são obrigatórios para adicionar um novo administrador.';
    } else {
        // Check if user exists
        $stmt_check = $pdo->prepare("SELECT id FROM usuarios_admin WHERE usuario = ?");
        $stmt_check->execute([$usuario]);
        if ($stmt_check->fetch()) {
            $error = 'Este login de usuário já está em uso.';
        } else {
            $hash = password_hash($senha, PASSWORD_BCRYPT);
            $stmt_add = $pdo->prepare("INSERT INTO usuarios_admin (nome, usuario, senha_hash) VALUES (?, ?, ?)");
            if ($stmt_add->execute([$nome, $usuario, $hash])) {
                $msg = 'Novo administrador adicionado com sucesso!';
            } else {
                $error = 'Erro ao adicionar administrador.';
            }
        }
    }
}

// Remove admin
if (isset($_GET['remove']) && is_numeric($_GET['remove'])) {
    $remove_id = (int) $_GET['remove'];
    // Avoid deleting oneself
    if ($remove_id === (int) $_SESSION['admin_id']) {
        $error = "Você não pode remover a si próprio.";
    } else {
        // Verify existence and delete
        $stmt_del = $pdo->prepare("DELETE FROM usuarios_admin WHERE id = ?");
        if ($stmt_del->execute([$remove_id])) {
            $msg = 'Administrador removido com sucesso!';
        }
    }
}

// Fetch all admins
$stmt_all = $pdo->query("SELECT id, nome, usuario FROM usuarios_admin ORDER BY id ASC");
$admins = $stmt_all->fetchAll();

?>
<?php include 'includes/admin_header.php'; ?>

<div class="dashboard-header">
    <h1>Administradores</h1>
</div>

<?php if ($msg): ?>
    <div class="alert alert-success" style="background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9;"><i
            class="fas fa-check-circle"></i>
        <?php echo htmlspecialchars($msg); ?>
    </div>
<?php endif; ?>
<?php if ($error): ?>
    <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i>
        <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<div class="dashboard-grid">
    <!-- List of admins -->
    <div class="card card-table" style="grid-column: span 2;">
        <h2><i class="fas fa-list"></i> Lista de Administradores</h2>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Usuário (Login)</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admins as $adm): ?>
                        <tr>
                            <td>#
                                <?php echo htmlspecialchars($adm['id']); ?>
                            </td>
                            <td><strong>
                                    <?php echo htmlspecialchars($adm['nome'] ?? 'Administrador'); ?>
                                </strong></td>
                            <td>
                                <?php echo htmlspecialchars($adm['usuario']); ?>
                            </td>
                            <td>
                                <?php if ($adm['id'] !== $_SESSION['admin_id']): ?>
                                    <a href="admins.php?remove=<?php echo $adm['id']; ?>" class="btn btn-outline btn-sm"
                                        style="color: var(--error-color); border-color: var(--error-color);"
                                        onclick="return confirm('Tem certeza que deseja remover este administrador?');">
                                        <i class="fas fa-trash-alt"></i> Remover
                                    </a>
                                <?php else: ?>
                                    <span style="color: #999; font-size: 0.85rem;"><i class="fas fa-user-check"></i> Você</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Form to add new admin -->
    <div class="card">
        <h2><i class="fas fa-user-plus"></i> Novo Admin</h2>
        <form action="admins.php" method="POST" style="margin-top: 20px;">
            <input type="hidden" name="action" value="add">
            <div class="form-group">
                <label for="nome">Nome Completo</label>
                <input type="text" id="nome" name="nome" placeholder="Ex: Maria" required>
            </div>
            <div class="form-group">
                <label for="usuario">Login (Usuário)</label>
                <input type="text" id="usuario" name="usuario" placeholder="Ex: maria_admin" required
                    autocomplete="username">
            </div>
            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" required autocomplete="new-password">
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;"><i class="fas fa-plus"></i>
                Adicionar</button>
        </form>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>