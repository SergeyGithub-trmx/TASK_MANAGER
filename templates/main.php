<div class="main-wrapper">
    <div class="projects-bar">
        <p>Your projects</p>

        <div class="work-buttons">
            <a class="create-new-btn create-new-project-btn" href="./create-project.php">Create new project</a>
        </div>
    </div>

    <div class="projects-tasks_wrapper">
        <ul class="projects_wrapper">
            <?php $tab = isset($_GET['tab']) ? "&tab={$_GET['tab']}" : ''; ?>
            <?php foreach($projects as $project): ?>
                <?= include_template('_partials\_project.php', ['project' => $project, 'tab' => $tab]) ?>
            <?php endforeach; ?>
        </ul>

        <ul class="tasks_wrapper">
            <?php foreach($tasks as $task): ?>
                <?= include_template('_partials\_task.php', ['task' => $task]) ?>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="tasks-bar">
        <p>Your tasks</p>

        <input placeholder="Search tasks" id="searching-tasks">

        <p id="tasks-filter">Filter</p>

        <div class="tasks-filter">

            <ul class="filter_wrapper">
                <?php foreach ($filters as $filter): ?>
                    <?php $classname = isset($_GET['tab']) && $_GET['tab'] === $filter['tab'] ? 'filter--active' : ''; ?>
                    <?php $project = isset($_GET['project']) ? "project={$_GET['project']}&" : ''; ?>
                    <li>
                        <a class="<?= $classname ?>" href="/main-page.php?<?= $project . "tab={$filter['tab']}" ?>"><?= $filter['text'] ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="work-buttons">
            <a class="create-new-btn create-new-task-btn" href="./create-task.php">Create new task</a>
        </div>

    </div>
</div>
