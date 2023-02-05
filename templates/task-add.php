<?php

/** @var string input_name */
/** @var array projects */
/** @var array errors */
/** @param string $date */

?>

<div class="alpha-container"></div>

<div class="registration-block">
    <form method="post" action="" enctype="multipart/form-data">
        <h2 class="text-center">TASK</h3>

        <div class="form-group name-entering">
            <input
                class="form-control item"
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

        <div class="form-group file-input">
            <input
                class="form-control item"
                type="file"
                name="task-file"
                id="username"
            >
        </div>

        <div class="horizontal-block">
            <div class="form-group project-selection">
                <select name="project">
                    <?php foreach ($projects as $project): ?>
                        <option value="<?= $project['id'] ?>"><?= $project['name'] ?></option>
                    <?php endforeach; ?>
                </select>

                <?php if (isset($errors['project'])): ?>
                    <p style="color: red; font-weight: bold; text-align: center"><?= $errors['project'] ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group deadline-time">
                <input
                    type="text"
                    name="deadline"
                    value="<?= $_POST['deadline'] ?? '' ?>"
                    placeholder="Deadline"
                >

                <?php if (isset($errors['deadline'])): ?>
                    <p style="color: red; font-weight: bold; text-align: center"><?= $errors['deadline'] ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group">
            <button
                class="btn btn-primary btn-block log-in"
                type="submit"
            >Add</button>
        </div>

    </form>
</div>
