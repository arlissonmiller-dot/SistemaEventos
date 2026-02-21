<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_login();

$msg = '';
$error = '';

$admin_id = $_SESSION['admin_id'];

// Buscar dados atuais do admin
$stmt = $pdo->prepare("SELECT nome, usuario FROM usuarios_admin WHERE id = ?");
$stmt->execute([$admin_id]);
$admin = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $usuario = trim($_POST['usuario'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (empty($nome) || empty($usuario)) {
        $error = 'Nome e usuário são obrigatórios.';
    } else {
        // Verificar se usuário já existe para outro ID
        $stmt_check = $pdo->prepare("SELECT id FROM usuarios_admin WHERE usuario = ? AND id != ?");
        $stmt_check->execute([$usuario, $admin_id]);
        if ($stmt_check->fetch()) {
            $error = 'Este nome de login já está em uso.';
        } else {
            if (!empty($senha)) {
                $hash = password_hash($senha, PASSWORD_BCRYPT);
                $stmt_upd = $pdo->prepare("UPDATE usuarios_admin SET nome = ?, usuario = ?, senha_hash = ? WHERE id = ?");
                $stmt_upd->execute([$nome, $usuario, $hash, $admin_id]);
            } else {
                $stmt_upd = $pdo->prepare("UPDATE usuarios_admin SET nome = ?, usuario = ? WHERE id = ?");
                $stmt_upd->execute([$nome, $usuario, $admin_id]);
            }
            $_SESSION['admin_user'] = $nome; // Update session
            $msg = 'Perfil atualizado com sucesso!';

            // Reload admin data
            $stmt->execute([$admin_id]);
            $admin = $stmt->fetch();
        }
    }
}
?>
<?php include 'includes/admin_header.php'; ?>

<div class="dashboard-header">
    <h1>Editar Perfil</h1>
</div>

<div class="card" style="max-width: 600px;">
    <?php if ($msg): ?>
        <div class="alert alert-success" style="background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9;"><i
                class="fas fa-check-circle"></i>
            <?php echo $msg; ?>
        </div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i>
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form action="perfil.php" method="POST">
        <div class="form-group">
            <label for="nome">Nome Completo</label>
            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($admin['nome']); ?>" required>
        </div>

        <div class="form-group">
            <label for="usuario">Login (Usuário)</label>
            <input type="text" id="usuario" name="usuario" value="<?php echo htmlspecialchars($admin['usuario']); ?>"
                required autocomplete="username">
        </div>

        <div class="form-group">
            <label for="senha">Nova Senha (deixe em branco para manter a atual)</label>
            <input type="password" id="senha" name="senha" placeholder="Digitar nova senha" autocomplete="new-password">
        </div>

        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Salvar Alterações</button>
    </form>
</div>

<?php include 'includes/admin_footer.php'; ?>