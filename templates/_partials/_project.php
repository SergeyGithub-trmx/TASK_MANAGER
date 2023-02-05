<?php 

$classname = isset($_GET['project']) && $_GET['project'] === $project['id'] ? 'project--active' : '';

?>
<li>
    <div class="project <?= $classname ?>">
        <a href="/main-page.php?project=<?= htmlspecialchars($project['id']) . $tab ?>"><?= htmlspecialchars($project['name']) ?></a>
    </div>
</li>
