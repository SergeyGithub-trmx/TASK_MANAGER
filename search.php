<?php

require_once('init.php');

$user_id = intval($_SESSION['user']['id']);
$query = $_GET['q'] ?? '';

$projects = $db->getUserProjects($user_id);
$tasks = $db->getTasksByQuery($query, $user_id);

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
