<?php

require_once('init.php');

if (!isset($_SESSION['user'])) {
    header('Location: /register-page.php');
    exit;
}

$user_id = intval($_SESSION['user']['id']);

const INPUT_NAME = 'task';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_name = trim($_POST[INPUT_NAME] ?? '');
    $project_id = intval($_POST['project'] ?? 0);
    $deadline = (is_null($_POST['deadline']) || mb_strlen($_POST['deadline']) === 0) ? null : trim($_POST['deadline']);

    $errors[INPUT_NAME] = required($task_name);
    if (is_task_exist_by_name($mysqli, $task_name, $user_id)) {
        $errors[INPUT_NAME] = 'This task already exists.';
    }
    
    if (!is_project_exist_by_id($mysqli, $project_id, $user_id)) {
        $errors['project'] = 'This project does not exist.';
    }

    if (isset($deadline) && !is_date_valid($deadline)) {
        $errors['deadline'] = 'Incorrect date format.';
    }

    if (empty(array_filter($errors))) {
        if (create_task($mysqli, $task_name, $user_id, $project_id, $deadline)) {
            
            if (!empty($_FILES['task-file']['tmp_name'])) {
                $file_name = uniqid() . '_' . str_replace('_', '-', $_FILES['task-file']['name']);
                $file_url = __DIR__ . '/uploads/' . $file_name;

                if (move_uploaded_file($_FILES['task-file']['tmp_name'], $file_url)) {
                    $task_id = mysqli_insert_id($mysqli);
                    create_task_file($mysqli, $file_name, $task_id);
                }
            }
            setcookie('adding-successful', 1);
            header('Location: /main-page.php');
        }
    }
}

$projects = get_user_projects($mysqli, $user_id);

$page_content = include_template('task-add.php', [
    'errors' => $errors,
    'input_name' => INPUT_NAME,
    'projects' => $projects
]);

$page_layout = include_template('layouts\main-layout.php', [
    'page_content' => $page_content,
    'css_file' => 'css\project-task_creation-style.css',
    'title' => 'Create a task',
]);

print($page_layout);
