<?php

$filters = [
    [
        'text' => 'For today',
        'tab' => 'today',
        'url' => 'http://localhost/main-page.php?tab=today'
    ],
    [
        'text' => 'For tomorrow',
        'tab' => 'tomorrow',
        'url' => 'http://localhost/main-page.php?tab=tomorrow'
    ],
    [
        'text' => 'Expired',
        'tab' => 'expired',
        'url' => 'http://localhost/main-page.php?tab=expired'
    ],
    [
        'text' => 'Completed',
        'tab' => 'completed',
        'url' => 'http://localhost/main-page.php?tab=completed'
    ]
];

require_once('init.php');

$sql = 'SELECT * FROM `project`';
$project_result = mysqli_query($mysqli, $sql);

$sql = 'SELECT * FROM `task`';
$task_result = mysqli_query($mysqli, $sql);

$projects = [];
$tasks = [];

while ($project = mysqli_fetch_assoc($project_result)) {
    $projects[] = $project;
}

while ($task = mysqli_fetch_assoc($task_result)) {
    $tasks[] = $task;
}

$page_content = includeTemplate('main.php', [
    'tasks' => $tasks,
    'projects' => $projects,
    'filters' => $filters
]);

$page_header = includeTemplate('layouts\header.php');

$page_layout = includeTemplate('layouts\main-layout.php', [
    'page_content' => $page_content,
    'page_header' => $page_header,
    'css_file' => 'css\main_page-style.css',
    'title' => 'Task Manager - Main page'
]);

print($page_layout);