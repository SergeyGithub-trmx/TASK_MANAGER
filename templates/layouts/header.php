<header>
    <?php if (isset($_COOKIE['register-successful'])): ?>
        <?php setcookie('register-successful', 1, time() - 3600); ?>
        Register completed successfully!
    <?php else: ?>
        Universal Task Manager
        <?php if (isset($_SESSION['user'])): ?>
            <a class="logout" href="./logout.php">Log out</a>
        <?php endif; ?>
    <?php endif; ?>
</header>
