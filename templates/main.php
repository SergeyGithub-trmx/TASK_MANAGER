<div class="main-wrapper">
    <div class="projects-bar">
        <p>
            Your projects
        </p>

        <div class="work-buttons">
            <a class="create-new-project-btn" href="./create-project.php">Create new project</a>
        </div>
    </div>

    <div class="projects-tasks_wrapper">
        <ul class="projects_wrapper">
            <?php foreach($projects as $project): ?>
                <?= includeTemplate('_partials\_project.php', ['project' => $project]) ?>
            <?php endforeach; ?>
        </ul>

        <ul class="tasks_wrapper">
            <?php foreach($tasks as $task): ?>
                <?= includeTemplate('_partials\_task.php', ['task' => $task]) ?>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="tasks-bar">
        <p>
            Your tasks
        </p>
        <input placeholder="Search tasks" id="searching-tasks">

        <p id="tasks-filter">Filter</p>

        <div class="tasks-filter">

            <ul class="filter_wrapper">
                <?php foreach ($filters as $filter): ?>
                    <?php $classname = isset($_GET['tab']) && $_GET['tab'] === $filter['tab'] ? 'filter--active' : ''; ?>
                    <li class="<?= $classname ?>">
                        <a href="<?= $filter['url'] ?>"><?= $filter['text'] ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="work-buttons">
            <a class="create-new-task-btn" href="#">Create new task</a>
        </div>

    </div>
</div>
