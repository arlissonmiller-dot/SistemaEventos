<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';

require_login();
$current_page = basename($_SERVER['PHP_SELF']);

// Recuperar o nome do admin atual, se disponível
$admin_nome = $_SESSION['admin_user'];
if (isset($_SESSION['admin_id'])) {
    $stmt_menu = $pdo->prepare("SELECT nome FROM usuarios_admin WHERE id = ?");
    $stmt_menu->execute([$_SESSION['admin_id']]);
    if ($menu_user = $stmt_menu->fetch()) {
        $admin_nome = $menu_user['nome'];
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Painel Administrativo</title>
    <!-- Incluindo FontAwesome para ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="admin-body">

    <div class="admin-layout">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Panel</h2>
                <div class="user-greeting">
                    <i class="fas fa-user-circle"></i> Olá,
                    <?php echo htmlspecialchars($admin_nome); ?>
                </div>
            </div>

            <nav class="sidebar-nav">
                <ul>
                    <li>
                        <a href="dashboard.php" class="<?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li>
                        <a href="convidados.php"
                            class="<?php echo $current_page == 'convidados.php' ? 'active' : ''; ?>">
                            <i class="fas fa-users"></i> Confirmados
                        </a>
                    </li>
                    <li>
                        <a href="perfil.php" class="<?php echo $current_page == 'perfil.php' ? 'active' : ''; ?>">
                            <i class="fas fa-user-edit"></i> Editar Perfil
                        </a>
                    </li>
                    <li>
                        <a href="admins.php" class="<?php echo $current_page == 'admins.php' ? 'active' : ''; ?>">
                            <i class="fas fa-user-shield"></i> Administradores
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="sidebar-footer">
                <a href="logout.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Sair</a>
            </div>
        </aside>

        <main class="admin-content">