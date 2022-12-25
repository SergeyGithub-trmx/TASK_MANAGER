<?php

/** @var array $errors */

?>
<div class="registration-block">
    <form method="post" action="">
        <h2 class="text-center">Registraion</h3>

        <div class="form-group" style="text-align: center;">
            <?php $style = isset($errors['login']) ? 'border: 2px solid red;' : '' ?>
            <?php $style .= 'margin: 0;'; ?>
            <input
                class="form-control item"
                type="text"
                name="login"
                value="<?= $_POST['login'] ?? '' ?>"
                id="username"
                placeholder="Username"
                style="<?= $style ?>"
            >

            <?php if (isset($errors['login'])): ?>
                <p style="color: red; font-weight: bold;"><?= $errors['login'] ?></p>
            <?php endif; ?>

        </div>

        <div class="form-group" style="margin-top: 30px; text-align: center;">
            <?php $style = isset($errors['email']) ? 'border: 2px solid red;' : '' ?>
            <?php $style .= 'margin: 0;'; ?>
            <input
                class="form-control item"
                type="text"
                name="email"
                value="<?= $_POST['email'] ?? '' ?>"
                id="email"
                placeholder="Email"
                style="<?= $style ?>"
            >

            <?php if (isset($errors['email'])): ?>
                <p style="color: red; font-weight: bold;"><?= $errors['email'] ?></p>
            <?php endif; ?>

        </div>

        <div class="form-group" style="margin-top: 30px; text-align: center;">
            <?php $style = isset($errors['password']) ? 'border: 2px solid red;' : '' ?>
            <?php $style .= 'margin: 0;'; ?>
            <input
                class="form-control item"
                type="password"
                name="password"
                value="<?= $_POST['password'] ?? '' ?>"
                id="password"
                placeholder="Password"
                style="<?= $style ?>"
            >

            <?php if (isset($errors['password'])): ?>
                <p style="color: red; font-weight: bold;"><?= $errors['password'] ?></p>
            <?php endif; ?>

        </div>

        <div class="form-group">
            <button
                class="btn btn-primary btn-block create-account"
                type="submit"
                style="margin: 20px 0 10px 0;"
            >Create</button>
        </div>

        <p class="account-existed-check" style="margin: 10px 0 0 0;">
            Already have an account?
        </p>

        <a href="./login-page.php" style="margin: 20px 0 -10px 0;">Log in</a>
    </form>
</div>