<?php

require_once('init.php');

if (!isset($_SESSION['user'])) {
    header('Location: /register-page.php');
    exit;
}

$user_id = intval($_SESSION['user']['id']);
$project_id = isset($_GET['project']) ? intval($_GET['project']) : null;
$tab = $_GET['tab'] ?? null;
$show_completed = isset($_GET['show_completed']) && $_GET['show_completed'] === '1' ? true : false;

$projects = $db->getUserProjects($user_id);
$tasks = $db->getUserTasks($user_id, $show_completed, $project_id, $tab);

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
