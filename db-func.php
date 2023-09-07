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
}


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


function is_project_exist_by_id(mysqli $mysqli, int $project_id, int $user_id): bool
{
    $sql = "SELECT * FROM `project` WHERE `id` = {$project_id} AND `user_id` = {$user_id}";
    $result = mysqli_query($mysqli, $sql);
    
    return boolval(mysqli_fetch_assoc($result));
}

function is_project_exist_by_name(mysqli $mysqli, string $project_name, int $user_id): bool
{
    $project_name = mysqli_real_escape_string($mysqli, $project_name);
    $sql = "SELECT * FROM `project` WHERE `name` = '{$project_name}' AND `user_id` = {$user_id}";

    $result = mysqli_query($mysqli, $sql);
    
    return boolval(mysqli_fetch_assoc($result));
}


function create_task(mysqli $mysqli, string $task_name, int $user_id, int $project_id, ?string $deadline): bool
{
    $task_name = mysqli_real_escape_string($mysqli, $task_name);
    
    if (is_string($deadline)) {
        $deadline = mysqli_real_escape_string($mysqli, $deadline);
        $sql = "INSERT INTO `task` (name, user_id, project_id, deadline) VALUES ('$task_name', $user_id, $project_id, '$deadline')";
    } else {
        $sql = "INSERT INTO `task` (name, user_id, project_id, deadline) VALUES ('$task_name', $user_id, $project_id, null)";
    }

    return mysqli_query($mysqli, $sql);
}


function is_task_exist_by_name(mysqli $mysqli, string $task, int $user_id): bool
{
    $task = mysqli_real_escape_string($mysqli, $task);
    $sql = "SELECT * FROM `task` WHERE `name` = '{$task}' AND `user_id` = $user_id";
    $result = mysqli_query($mysqli, $sql);

    return boolval(mysqli_fetch_assoc($result));
}

function get_task_by_id(mysqli $mysqli, int $task_id, int $user_id): array
{
    $sql = "SELECT * FROM `task` WHERE `id` = $task_id AND `user_id` = $user_id";
    $result = mysqli_query($mysqli, $sql);

    return mysqli_fetch_assoc($result);
}


function get_user_projects(mysqli $mysqli, int $user_id): array
{
    $projects = [];
    
    $user_id = intval($user_id);
    $sql = "SELECT * FROM `project` WHERE `user_id` = $user_id";
    $result = mysqli_query($mysqli, $sql);
    
    while ($project = mysqli_fetch_assoc($result)) {
        $projects[] = $project;
    };
    
    return $projects;
}


function get_user_tasks(mysqli $mysqli, int $user_id, bool $show_completed, ?int $project_id = null, ?string $tab = null): array
{
    $tasks = [];

    if (isset($tab)) {
        $tab = mysqli_real_escape_string($mysqli, $tab);
    } 

    
    $user_id = intval($user_id);
    $sql = "
        SELECT t.*, tf.path AS file_path
        FROM task t
        LEFT JOIN task_file tf ON tf.task_id = t.id
        WHERE t.user_id = {$user_id}
    ";

    if (isset($project_id)) {
        $sql .= " AND t.project_id = {$project_id}";
    }

    if (isset($tab)) {
        switch ($tab) {
            case 'today':
                $sql .= " AND t.deadline = CURDATE()";
                break;
            case 'tomorrow':
                $sql .= " AND t.deadline = CURDATE() + INTERVAL 1 DAY";
                break;
            case 'expired':
                $sql .= " AND t.deadline < CURDATE()";
                break;
        }
    }
    if (isset($show_completed) && $show_completed === 0) {
        $sql .= ' AND t.is_completed = 0';
    }


    $result = mysqli_query($mysqli, $sql);
    while ($task = mysqli_fetch_assoc($result)) {
        $tasks[] = $task;
    }

    return $tasks;
}

function create_task_file(mysqli $mysqli, string $path, int $task_id): bool
{
    $path = mysqli_real_escape_string($mysqli, $path);
    $sql = "INSERT INTO `task_file` (path, task_id) VALUES ('$path', $task_id)";

    return mysqli_query($mysqli, $sql);
}

function update_task_status(mysqli $mysqli, int $task_id, int $new_status): bool
{
    $sql = "UPDATE `task` SET `is_completed` = $new_status WHERE `id` = $task_id";
    
    return mysqli_query($mysqli, $sql);
}

function get_tasks_by_query(mysqli $mysqli, string $task, int $user_id): array
{
    $tasks = [];

    $sql = "SELECT * FROM `task` WHERE `user_id` = $user_id AND `name` LIKE '%{$task}%'";

    $result = mysqli_query($mysqli, $sql);
    while ($task = mysqli_fetch_assoc($result)) {
        $tasks[] = $task;
    }

    return $tasks;
}
