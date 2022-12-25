<?php

function create_user(mysqli $mysqli, array $data): bool
{
    [$login, $email, $password] = $data;
    
    $login = mysqli_real_escape_string($mysqli, $login);
    $email = mysqli_real_escape_string($mysqli, $email);
    $password = mysqli_real_escape_string($mysqli, $password);
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    
    $data = "'{$login}', '{$email}', '{$password_hash}'";
    
    $sql = "INSERT INTO `user` (login, email, password_hash) VALUES ($data)";

    return mysqli_query($mysqli, $sql);
};

function get_user_by_login(mysqli $mysqli, string $login): ?array
{
    $login = mysqli_real_escape_string($mysqli, $login);
    $sql = "SELECT * FROM `user` WHERE `login` = '{$login}' OR `email` = '{$login}'";
    
    if (!$result = mysqli_query($mysqli, $sql)) {
        return null;
    }
    
    return mysqli_fetch_assoc($result);
}

function is_login_exist(mysqli $mysqli, string $login): bool
{
    $login = mysqli_real_escape_string($mysqli, $login);
    $sql = "SELECT * FROM `user` WHERE `login` = '{$login}'";
    $result = mysqli_query($mysqli, $sql);
    
    return boolval(mysqli_fetch_assoc($result));
}

function is_email_exist(mysqli $mysqli, string $email): bool
{
    $email = mysqli_real_escape_string($mysqli, $email);
    $sql = "SELECT * FROM `user` WHERE `email` = '{$email}'";
    $result = mysqli_query($mysqli, $sql);
    
    return boolval(mysqli_fetch_assoc($result));
}

function create_project(mysqli $mysqli, string $project, int $user_id): bool
{
    $project = mysqli_real_escape_string($mysqli, $project);
    $sql = "INSERT INTO `project` (name, user_id) VALUES ('$project', $user_id)";

    return mysqli_query($mysqli, $sql);
}

function create_task(mysqli $mysqli, string $task, int $user_id): bool
{
    $task = mysqli_real_escape_string($mysqli, $task);
    $sql = "INSERT INTO `project` (name, user_id) VALUES ('$task', $user_id)";

    return mysqli_query($mysqli, $sql);
}

function is_project_exist(mysqli $mysqli, string $project, int $user_id): bool
{
    $project = mysqli_real_escape_string($mysqli, $project);
    $sql = "SELECT * FROM `project` WHERE `name` = '{$project}' AND `user_id` = '{$user_id}'";
    $result = mysqli_query($mysqli, $sql);
    
    return boolval(mysqli_fetch_assoc($result));
}

// function is_task_exist(mysqli $mysqli, string $task, int $user_id, int $project_id): bool
// {
//     $task = mysqli_real_escape_string($mysqli, $task);
//     $sql = "SELECT * FROM `project` WHERE `name` = '{$task}' AND `user_id` = '{$user_id}' AND `project_id` = '{$project_id}'";
//     $result = mysqli_query($mysqli, $sql);

//     return boolval(mysqli_fetch_assoc($result));
// }

function get_user_projects(mysqli $mysqli, int $user_id): array
{
    $projects = [];
    
    $user_id = intval($user_id);
    $sql = "SELECT * FROM `project` WHERE `user_id` = {$user_id}";
    $result = mysqli_query($mysqli, $sql);
    
    while ($project = mysqli_fetch_assoc($result)) {
        $projects = $project;
    };
    
    return $projects;
};

function get_user_tasks(mysqli $mysqli, int $user_id): array
{
    $tasks = [];
    
    $user_id = intval($user_id);
    $sql = "SELECT * FROM `task` WHERE `user_id` = {$user_id}";
    $result = mysqli_query($mysqli, $sql);
    
    while ($task = mysqli_fetch_assoc($result)) {
        $tasks = $task;
    };
    
    return $tasks;
};
