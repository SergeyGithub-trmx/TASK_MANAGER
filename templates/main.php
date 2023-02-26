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
            <?php $show_completed = isset($_GET['show_completed']) ? "&show_completed={$_GET['show_completed']}" : ''; ?>

            <?php if (!empty($projects)): ?>

                <?php foreach($projects as $project): ?>
                    <?= include_template('_partials\project.php', [
                        'project' => $project,
                        'tab' => $tab,
                        'show_completed' => $show_completed
                    ]) ?>
                <?php endforeach; ?>

            <?php else: ?>
                <p>There aren't any projects.</p>
            <?php endif; ?>

        </ul>

        <ul class="tasks_wrapper">
            
            <?php if (!empty($tasks)): ?>

                <?php foreach($tasks as $task): ?>
                    <?= include_template('_partials\task.php', [
                        'task' => $task
                    ]) ?>
                <?php endforeach; ?>

            <?php else: ?>
                <p>There aren't any tasks.</p>
            <?php endif; ?>

        </ul>
    </div>

    <div class="tasks-bar">
        <p>Your tasks</p>

        <form method="get" action="search.php">
            <input name="q" type="search" value="<?= $_GET['q'] ?? '' ?>" placeholder="Search tasks" id="searching-tasks">
            <input type="submit">
        </form>

        <p id="tasks-filter">Filters</p>

        <div class="tasks-filter">
            <ul class="filter_wrapper">
                <?php foreach ($filters as $filter): ?>
                    <?php $classname = isset($_GET['tab']) && $_GET['tab'] === $filter['tab'] ? 'filter--active' : ''; ?>
                    <?php $project = isset($_GET['project']) ? "project={$_GET['project']}" : ''; ?>
                    <?php $show_completed = isset($_GET['show_completed']) ? "&show_completed={$_GET['show_completed']}" : ''; ?>

                    <li>
                        <a class="<?= $classname ?>" href="/main-page.php?<?= $project . "&tab={$filter['tab']}" . $show_completed ?>"><?= $filter['text'] ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php $project = isset($_GET['project']) ? "project={$_GET['project']}&" : ''; ?>
            <?php $tab = isset($_GET['tab']) ? "tab={$_GET['tab']}&" : ''; ?>
            <?php $is_completed = boolval($_GET['show_completed'] ?? 0) ? 'show_completed=0' : 'show_completed=1'; ?>

            <?php $link_content = boolval($_GET['show_completed'] ?? 0) ? 'true' : 'false'; ?>
            <a href="/main-page.php?<?= $project . $tab . $is_completed ?>" class="is_completed_filter">Show completed tasks: <?= $link_content ?></a>
        </div>


        <div class="work-buttons">
            <a class="create-new-btn create-new-task-btn" href="./create-task.php">Create new task</a>
        </div>

    </div>
</div>
