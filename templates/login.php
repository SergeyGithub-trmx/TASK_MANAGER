<div class="registration-block">
    <form method="post" action="">
        <h2 class="text-center">Log in</h3>

        <div class="form-group">
            <input class="form-control item"
                type="text"
                name="login"
                id="username"
                value="<?= $_POST['login'] ?? '' ?>"
                placeholder="Login or email"
            >

            <?php if (isset($errors['login'])): ?>
                <p style="color: red; font-weight: bold; text-align: center; margin: -20px 0 20px 0;"><?= $errors['login'] ?></p>
            <?php endif; ?>

        </div>

        <div class="form-group">
            <input
                class="form-control item"
                type="password"
                name="password"
                value="<?= $_POST['password'] ?? '' ?>"
                id="password"
                placeholder="Password"
            >

            <?php if (isset($errors['password'])): ?>
                <p style="color: red; font-weight: bold; text-align: center; margin: -20px 0 20px 0;"><?= $errors['password'] ?></p>
            <?php endif; ?>

        </div>

        <div class="form-group">
            <button
                class="btn btn-primary btn-block log-in"
                type="submit"
            >Go!</button>
        </div>

        <p class="account-existed-check" style="margin: 10px 0 0 0;">
            Don't have an account?
        </p>

        <a href="./register-page.php" style="margin: 20px 0 -10px 0;">Create!</a>
    </form>
</div>
