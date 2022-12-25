<?php

require_once('init.php');

if (!isset($_SESSION['user'])) {
    header('Location: /register-page.php');
    exit;
}

$user_id = intval($_SESSION['user']['id']);

const INPUT_NAME = 'project';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $project = trim($_POST[INPUT_NAME] ?? '');

    if (mb_strlen($project) === 0) {
        $errors[INPUT_NAME] = 'Please enter a name of your project.';
    } else if (is_project_exist($mysqli, $project, $user_id)) {
        $errors[INPUT_NAME] = 'This project already exists.';
    }

    if (empty($errors)) {
        if (create_project($mysqli, $project, $user_id)) {
            setcookie('adding-successful', 1);
            header('Location: /main-page.php');
        }
    }
}

$page_content = includeTemplate('project-add.php', [
    'errors' => $errors,
    'input_name' => INPUT_NAME
]);

$page_layout = includeTemplate('layouts\main-layout.php', [
    'page_content' => $page_content,
    'css_file' => 'css\project-task_create-style.css',
    'title' => 'Create a project'
]);

print($page_layout);
