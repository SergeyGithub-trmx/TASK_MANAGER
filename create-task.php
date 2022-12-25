<?php

// require_once('init.php');

// if (!isset($_SESSION['user'])) {
//     header('Location: /register-page.php');
//     exit;
// }

// $user_id = intval($_SESSION['user']['id']);

// const INPUT_NAME = 'task';

// $errors = [];

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $project = trim($_POST[INPUT_NAME] ?? '');

//     if (mb_strlen($project) === 0) {
//         $errors[INPUT_NAME] = 'Please enter a name of your task.';
//     } else if (is_project_exist($mysqli, $project, $user_id)) {
//         $errors[INPUT_NAME] = 'This task already exists.';
//     }

//     if (empty($errors)) {
//         if (create_task($mysqli, $task, $user_id)) {
//             setcookie('adding-successful', 1);
//             header('Location: /main-page.php');
//         }
//     }
// }

// $page_content = includeTemplate('task-add.php', [
//     'errors' => $errors
// ]);

// $page_layout = includeTemplate('layouts\main-layout.php', [
//     'page_content' => $page_content,
//     'css_file' => 'css\login-register_page-style.css',
//     'title' => 'Create a task',
// ]);

// print($page_layout);
