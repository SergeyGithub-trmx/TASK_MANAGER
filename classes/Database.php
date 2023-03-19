<?php

class Database
{
    private ?\mysqli $mysqli = null;
    private static ?Database $db = null;

    /**
     * Возвращает экземпляр класса Database
     * @return Database
     */
    public static function getInstance(): Database
    {
        if (self::$db === null) {
            self::$db = new Database();
        }

        return self::$db;
    }

    private function __construct()
    {
        $db_config = require_once 'config/db.php';
        $db_config = array_values($db_config);
        $this->mysqli = new \mysqli(...$db_config);

        if (!$this->mysqli) {
            http_response_code(500);
            exit;
        }

        $this->mysqli->set_charset('utf8');
    }

    /**
     * Выполняет sql-запрос и возвращает массив содержащий ассоциативные массивы
     * с данными результирующей таблицы
     *
     * @param string $sql SQL-запрос с плейсхолдерами вместо значений
     * @param array $stmt_data Данные для вставки на место плейсхолдеров
     *
     * @return array
     */
    public function select(string $sql, array $stmt_data = []): array
    {
        $stmt = $this->executeQuery($sql, $stmt_data);
        if (!$result = $stmt->get_result()) {
            http_response_code(500);
            exit;
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Выполняет sql-запрос и возвращает ассоциативный массив значений,
     * соответствующий результирующей выборке, где каждый ключ в массиве
     * соответствует имени одного из столбцов выборки или null,
     * если других строк не существует
     *
     * @param string $sql SQL-запрос с плейсхолдерами вместо значений
     * @param array $stmt_data Данные для вставки на место плейсхолдеров
     *
     * @return array|null
     */
    public function selectOne(string $sql, array $stmt_data = []): ?array
    {
        $stmt = $this->executeQuery($sql, $stmt_data);
        if (!$result = $stmt->get_result()) {
            http_response_code(500);
            exit;
        }

        return $result->fetch_assoc();
    }

    /**
     * Выполняет sql-запрос и возвращает число рядов в результирующей выборке
     *
     * Замечание:
     * Если число рядов больше чем PHP_INT_MAX,
     * то число будет возвращено в виде строки
     *
     * @param string $sql SQL-запрос с плейсхолдерами вместо значений
     * @param array $stmt_data Данные для вставки на место плейсхолдеров
     *
     * @return int|string
     */
    public function getNumRows(string $sql, array $stmt_data = []): int|string
    {
        $stmt = $this->executeQuery($sql, $stmt_data);
        if (!$result = $stmt->get_result()) {
            http_response_code(500);
            exit;
        }

        return $result->num_rows;
    }

    /**
     * Выполняет sql-запрос и возвращает значение поля AUTO_INCREMENT,
     * которое было затронуто предыдущим запросом.
     * Возвращает ноль, если предыдущий запрос не затронул таблицы,
     * содержащие поле AUTO_INCREMENT
     *
     * @param string $sql SQL-запрос с плейсхолдерами вместо значений
     * @param array $stmt_data Данные для вставки на место плейсхолдеров
     *
     * @return int
     */
    public function getLastId(string $sql, array $stmt_data = []): int
    {
        $stmt = $this->getPrepareStmt($sql, $stmt_data);
        if (!$stmt->execute()) {
            http_response_code(500);
            exit;
        }

        return $stmt->insert_id;
    }

    /**
     * Создаёт и выполняет подготовленное выражение.
     * Возвращает экземпляр класса mysqli_stmt в случае успешного завершения
     * или завершает скрипт с 500 кодом ответа HTTP в случае возникновения ошибки
     *
     * @param string $sql SQL-запрос с плейсхолдерами вместо значений
     * @param array $stmt_data Данные для вставки на место плейсхолдеров
     *
     * @return mysqli_stmt
     */
    public function executeQuery(string $sql, array $stmt_data = []): \mysqli_stmt
    {
        $stmt = $this->getPrepareStmt($sql, $stmt_data);
        if (!$stmt->execute()) {
            http_response_code(500);
            exit;
        }

        return $stmt;
    }

    /**
     * Создаёт подготовленное выражение на основе готового SQL запроса и переданных данных.
     * Возвращает экземпляр класса mysqli_stmt в случае успешного завершения
     * или завершает скрипт с 500 кодом ответа HTTP в случае возникновения ошибки
     *
     * @param string $sql SQL-запрос с плейсхолдерами вместо значений
     * @param array $data Данные для вставки на место плейсхолдеров
     *
     * @return mysqli_stmt Подготовленное выражение
     */
    private function getPrepareStmt(string $sql, array $data): \mysqli_stmt
    {
        if (!$stmt = $this->mysqli->prepare($sql)) {
            http_response_code(500);
            exit;
        }

        if ($data) {
            $types = '';
            $stmt_data = [];

            foreach ($data as $value) {
                $type = 's';

                if (is_int($value)) {
                    $type = 'i';
                } elseif (is_double($value)) {
                    $type = 'd';
                } elseif (is_string($value)) {
                    $type = 's';
                }

                if ($type) {
                    $types .= $type;
                    $stmt_data[] = $value;
                }
            }

            $values = array_merge([$types], $stmt_data);

            if (!$stmt->bind_param(...$values)) {
                http_response_code(500);
                exit;
            }
        }

        return $stmt;
    }

    /**
     * Проверяет наличие пользователя в БД по электронной почте,
     * возвращает true при наличии или false в случае отсутствия
     * @param string $email Электронная почта
     * @return bool
     */
    public function isUserExist(string $email): bool
    {
        $query = (new QueryBuilder())
            ->select(['id'])
            ->from('user')
            ->where('=', 'email', '?');

        return $query->exists([$email]);
    }


    public function createUser(array $data): bool
    {
        $password_hash = password_hash($data[2], PASSWORD_DEFAULT);
        $query = (new QueryBuilder())
            ->insert('user', ['login', 'email', 'password_hash'], array_fill(0, 3, '?'));

        return boolval($this->executeQuery($query->getQuery(), [$data[0], $data[1], $password_hash]));
    }


    public function getUserByLogin(string $login): ?array
    {
        $sql = "SELECT * FROM `user` WHERE `login` = ? OR `email` = ?";

        return $this->selectOne($sql, [$login, $login]);
    }


    public function isLoginExist(string $login): bool
    {
        $sql = "SELECT * FROM `user` WHERE `login` = ?";

        return boolval($this->selectOne($sql, [$login]));
    }


    public function isEmailExist(string $email): bool
    {
        $sql = "SELECT * FROM `user` WHERE `email` = ?";

        return boolval($this->selectOne($sql, [$email]));
    }


    public function createProject(string $project, int $user_id): bool
    {
        $sql = "INSERT INTO `project` (name, user_id) VALUES (?, ?)";

        return boolval($this->executeQuery($sql, [$project, $user_id]));
    }


    public function isProjectExist(mixed $value, int $user_id): bool
    { 
        $sql = "SELECT * FROM `project`";

        if (gettype($value) === "string") {
            $sql .= " WHERE `name` = ? AND `user_id` = ?";
        } else {
            $sql .= " WHERE `id` = ? AND `user_id` = ?";
        }

        return boolval($this->selectOne($sql, [$value, $user_id]));
    }


    public function createTask(string $task_name, int $user_id, int $project_id, ?string $deadline): mixed
    {   
        $value = $deadline ? '"$deadline"' : null;
        $sql = "INSERT INTO `task` (name, user_id, project_id, deadline) VALUES (?, ?, ?, ?)";

        if ($this->executeQuery($sql, [$task_name, $user_id, $project_id, $deadline])) {
            return $this->mysqli->insert_id;
        }

        return false;
    }


    public function isTaskExistByName(string $task, int $user_id): bool
    {
        $sql = "SELECT * FROM `task` WHERE `name` = ? AND `user_id` = ?";

        return boolval($this->selectOne($sql, [$task, $user_id]));
    }


    public function getTaskById(int $task_id, int $user_id): array
    {
        $sql = "SELECT * FROM `task` WHERE `id` = ? AND `user_id` = ?";

        return $this->selectOne($sql, [$task_id, $user_id]);
    }


    public function getUserProjects(int $user_id): array
    {
        $sql = "SELECT * FROM `project` WHERE `user_id` = ?";

        return $this->select($sql, [$user_id]);
    }


    public function getUserTasks(int $user_id, ?bool $show_completed = false, ?int $project_id = null, ?string $tab = null): array
    {
        $stmt_data = [$user_id];

        $sql = "
            SELECT t.*, tf.path AS file_path
            FROM task t
            LEFT JOIN task_file tf ON tf.task_id = t.id
            WHERE t.user_id = ?
        ";

        if (isset($project_id)) {
            $sql .= " AND t.project_id = ?";
            $stmt_data[] = $project_id;
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

        if (!$show_completed) {
            $sql .= " AND t.is_completed = 0";
        }

        return $this->select($sql, $stmt_data);
    }


    public function createTaskFile(string $path, int $task_id): void
    {
        $sql = "INSERT INTO `task_file` (path, task_id) VALUES (?, ?)";

        $this->executeQuery($sql, [$path, $task_id]);
    }


    public function updateTaskStatus(int $task_id, int $new_status): void
    {
        $sql = "UPDATE `task` SET `is_completed` = ? WHERE `id` = ?";

        $this->executeQuery($sql, [$new_status, $task_id]);
    }


    public function getTasksByQuery(string $task, int $user_id): array
    {
        $task = $this->mysqli->real_escape_string(str_replace('_', '\_', $task));
        $sql = "SELECT * FROM `task` WHERE `user_id` = ? AND `name` LIKE '%{$task}%'";

        return $this->select($sql, [$user_id]);
    }
}