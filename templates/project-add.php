<?php

/** @var string input_name */
/** @var array errors */

?>

<div class="alpha-container"></div>

<div class="registration-block">
    <form method="post" action="">
        <h2 class="text-center">PROJECT</h3>

        <div class="form-group">
            <input class="form-control item"
                type="text"
                name="<?= $input_name ?>"
                id="username"
                value="<?= $_POST[$input_name] ?? '' ?>"
                placeholder="Name"
            >

            <?php if (isset($errors[$input_name])): ?>
                <p style="color: red; font-weight: bold; text-align: center; margin: -20px 0 20px 0"><?= $errors[$input_name] ?></p>
            <?php endif; ?>

        </div>

        <div class="form-group">
            <button
                class="btn btn-primary btn-block log-in"
                type="submit"
            >Add</button>
        </div> 

    </form>
</div>
