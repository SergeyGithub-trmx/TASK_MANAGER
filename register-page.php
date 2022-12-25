<?php

require_once('init.php');

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (mb_strlen($login) === 0) {
        $errors['login'] = 'Please enter a login.';
    }

    if (is_login_exist($mysqli, $login)) {
        $errors['login'] = 'This login is already in use.';
    } else if (mb_strlen($email) === 0) {
        $errors['email'] = 'Please enter an email address.';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address.';
    } else if (is_email_exist($mysqli, $email)) {
        $errors['email'] = 'This email is already in use.';
    }

    if (mb_strlen($password) === 0) {
        $errors['password'] = 'Please enter a password!';
    } else if (mb_strlen($password) < 16) {
        $errors['password'] = 'Password must contain at least 16 characters!';
    }

    if (empty($errors)) {
        if (create_user($mysqli, [$login, $email, $password])) {
            setcookie('register-successful', 1);
            header('Location: /login-page.php');
        }
    }
}

$page_content = includeTemplate('register.php', [
    'errors' => $errors
]);

$page_header = includeTemplate('layouts\header.php');

$page_layout = includeTemplate('layouts\main-layout.php', [
    'page_content' => $page_content,
    'page_header' => $page_header,
    'css_file' => 'css\login-register_page-style.css',
    'title' => 'Task Manager - Register'
]);

print($page_layout);