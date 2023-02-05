<header class="page-header">
    <?php if (isset($_COOKIE['register-successful'])): ?>
        <?php setcookie('register-successful', 1, time() - 3600); ?>
        Register completed successfully!
    <?php else: ?>
        <h2>Universal Task Manager</h2>
        <?php if (isset($_SESSION['user'])): ?>
            <p style="order: -1; font-family: Aller; color: #3fcf3f"><?= esc($_SESSION['user']['login']) ?></p>
            <a class="logout" href="./logout.php">Log out</a>
        <?php endif; ?>
    <?php endif; ?>
</header>
