<?php

$filters = [
    [
        'text' => 'All',
        'tab' => 'all',
        'url' => 'http://localhost/main-page.php?tab=all'
    ],
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
    ]
];

require_once('init.php');

$user_id = intval($_SESSION['user']['id']);
$project_id = isset($_GET['project']) ? intval($_GET['project']) : null;
$tab = isset($_GET['tab']) ? mysqli_real_escape_string($mysqli, $_GET['tab']) : null;

$projects = get_user_projects($mysqli, $user_id);
$tasks = get_user_tasks($mysqli, $user_id, $project_id, $tab);

$page_content = include_template('main.php', [
    'tasks' => $tasks,
    'projects' => $projects,
    'filters' => $filters
]);

$page_header = include_template('layouts\header.php');

$page_layout = include_template('layouts\main-layout.php', [
    'page_content' => $page_content,
    'page_header' => $page_header,
    'css_file' => 'css\main_page-style.css',
    'title' => 'Task Manager - Main page'
]);

print($page_layout);