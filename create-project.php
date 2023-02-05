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
    $project_name = trim($_POST[INPUT_NAME] ?? '');

    if (mb_strlen($project_name) === 0) {
        $errors[INPUT_NAME] = 'Please enter a name of your project.';
    } else if (is_project_exist_by_name($mysqli, $project_name, $user_id)) {
        $errors[INPUT_NAME] = 'This project already exists.';
    }

    if (empty($errors)) {
        if (create_project($mysqli, $project_name, $user_id)) {
            setcookie('adding-successful', 1);
            header('Location: /main-page.php');
        }
    }
}

$page_content = include_template('project-add.php', [
    'errors' => $errors,
    'input_name' => INPUT_NAME
]);

$page_layout = include_template('layouts\main-layout.php', [
    'page_content' => $page_content,
    'css_file' => 'css\project-task_creation-style.css',
    'title' => 'Create a project'
]);

print($page_layout);
