<?php

class Database
{
    private ?\mysqli $mysqli = null;
    private static ?Database $db = null;

    /**
     * Возвращает ээкземпляр класса Database
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
}
