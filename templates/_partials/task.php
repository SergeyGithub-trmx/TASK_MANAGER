<li>
    <div class="task">
        <h3><?= esc($task['name']) ?></h3>
        <p>Created: <?= esc($task['dt_create']) ?></p>

        <?php if(isset($task['deadline'])): ?>
            <p>Deadline: <?= date('Y-m-d', strtotime($task['deadline'])) ?></p>
        <?php else: ?>
            <p>Deadline: indefinitely</p>
        <?php endif; ?>

        <?php if(isset($task['file_path'])): ?>
            <?php $url = '/uploads/' . esc($task['file_path']); ?>
            <p>File: <a href="<?= $url ?>" download><?= explode('_', $task['file_path'])[1] ?></a></p>
        <?php else: ?>
            <p>File: no file</p>
        <?php endif; ?>

        <a
            href="\execute-task.php?task=<?= $task['id'] ?>"
            class="<?= $task['is_completed'] ? 'completed' : '' ?>"
        >Completed: <?= $task['is_completed'] ? 'true' : 'false' ?></a>

    </div>
</li> 
