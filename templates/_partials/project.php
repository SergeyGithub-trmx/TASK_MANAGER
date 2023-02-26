<?php

/** @var array $project */
/** @var string $tab */
/** @var bool $show_completed */

$classname = ($_GET['project'] ?? null) === $project['id'] ? ' project--active' : '';

?>
<li>
    <a href="/main-page.php?project=<?= esc($project['id']) . $tab . $show_completed ?>">
        <div
            class="project<?= $classname ?>"
        ><?= esc($project['name']) ?></div>
    </a>
</li>
