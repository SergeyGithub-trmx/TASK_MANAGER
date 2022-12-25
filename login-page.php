<?php

require_once('init.php');

if (isset($_SESSION['user'])) {
    header('Location: /main-page.php');
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (mb_strlen($login) === 0) {
        $errors['login'] = 'Please enter a login.';
    }

    if (mb_strlen($password) === 0) {
        $errors['password'] = 'Please enter a password!';
    }

    if (empty($errors)) {
        if ($user = get_user_by_login($mysqli, $login)) {
            if (password_verify($password, $user['password_hash'])) {
                $_SESSION['user'] = $user;
                header('Location: /main-page.php');
            } else {
                $errors['password'] = 'Incorrect login or password.';
            }
        } else {
            $errors['password'] = 'Cannot find this user.';
        }
    }
}

$page_content = includeTemplate('login.php', [
    'errors' => $errors
]);

$page_header = includeTemplate('layouts\header.php');

$page_layout = includeTemplate('layouts\main-layout.php', [
    'page_content' => $page_content,
    'page_header' => $page_header,
    'css_file' => 'css\login-register_page-style.css',
    'title' => 'Task Manager - Login',
]);

print($page_layout);
