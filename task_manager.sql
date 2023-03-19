-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 18 2023 г., 16:14
-- Версия сервера: 8.0.19
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

USE `task_manager`;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `task_manager`
--

-- --------------------------------------------------------

--
-- Структура таблицы `project`
--

CREATE TABLE `project` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `dt_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dt_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `project`
--

INSERT INTO `project` (`id`, `name`, `dt_create`, `dt_update`, `user_id`) VALUES
(21, 'New project_0', '2023-02-05 04:02:55', '2023-02-05 04:02:55', 3),
(22, 'New project_1', '2023-02-05 10:51:21', '2023-02-05 10:51:21', 3),
(23, 'New project_2', '2023-02-05 11:09:00', '2023-02-05 11:09:00', 3),
(24, 'New project_3', '2023-02-19 10:43:22', '2023-02-19 10:43:22', 3),
(25, 'New project_4', '2023-03-12 10:41:27', '2023-03-12 10:41:27', 3),
(26, 'New project_5', '2023-03-12 10:41:30', '2023-03-12 10:41:30', 3),
(27, 'New project_6', '2023-03-12 10:41:33', '2023-03-12 10:41:33', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `task`
--

CREATE TABLE `task` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `dt_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dt_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int UNSIGNED NOT NULL,
  `project_id` int UNSIGNED NOT NULL,
  `deadline` datetime DEFAULT NULL,
  `is_completed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `task`
--

INSERT INTO `task` (`id`, `name`, `dt_create`, `dt_update`, `user_id`, `project_id`, `deadline`, `is_completed`) VALUES
(37, 'New task_0', '2023-02-05 04:03:07', '2023-02-05 04:03:07', 3, 21, '2023-02-09 00:00:00', 1),
(38, 'Parameter is incorrect', '2023-02-05 09:14:24', '2023-02-05 09:14:24', 3, 21, NULL, 1),
(39, 'fsquirt', '2023-02-26 06:09:42', '2023-02-26 06:09:42', 3, 21, NULL, 1),
(40, 'twain32', '2023-02-26 06:10:14', '2023-02-26 06:10:14', 3, 22, NULL, 1),
(41, 'skype', '2023-02-26 09:21:56', '2023-02-26 09:21:56', 3, 21, NULL, 1),
(42, 'explorer', '2023-02-26 09:23:56', '2023-02-26 09:23:56', 3, 21, NULL, 1),
(43, 'perfmon', '2023-02-26 09:24:33', '2023-02-26 09:24:33', 3, 21, NULL, 1),
(44, 'resmon', '2023-02-26 09:26:39', '2023-02-26 09:26:39', 3, 21, NULL, 1),
(45, 'igxpmp32', '2023-02-26 09:28:35', '2023-02-26 09:28:35', 3, 23, NULL, 1),
(46, 'alg', '2023-02-26 09:29:40', '2023-02-26 09:29:40', 3, 24, NULL, 1),
(47, 'atimpc', '2023-02-26 09:32:40', '2023-02-26 09:32:40', 3, 24, NULL, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `task_file`
--

CREATE TABLE `task_file` (
  `id` int UNSIGNED NOT NULL,
  `path` varchar(64) NOT NULL,
  `task_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `task_file`
--

INSERT INTO `task_file` (`id`, `path`, `task_id`) VALUES
(8, '63faf7a68e981_594cc8fbf07cb.png', 39),
(9, '63fb268415e91_Tecno.bmp', 46),
(10, '63fb2738eb47d_Tecno.bmp', 47);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int UNSIGNED NOT NULL,
  `login` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `dt_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dt_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `avatar_path` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `login`, `email`, `password_hash`, `dt_create`, `dt_update`, `avatar_path`) VALUES
(1, 'sergeygaymashev', 'sergeynorfr220@gmail.com', '$2y$10$0crS33CGpQw6MpftAi.6KOwz7Yt4wCl7SvICV45gxXSjFay4kbHqi', '2022-12-17 09:43:36', '2022-12-17 09:43:36', NULL),
(2, 'SergeyGithub-trmx', 'sergeynorfr220@gmail.ru', '$2y$10$.PT2n5CWIbf318L0PHKKTecctdQuJjvMwkqzCcP0kBusqJSxWySBq', '2022-12-23 10:40:41', '2022-12-23 10:40:41', NULL),
(3, 'SergeyGithub-termux', 'sergeynorfr220@inbox.ru', '$2y$10$F9PU1PNq/chUf6cbQABU.uObCCkMZqSqvGuDjqF5Q/.o06UlhuQ5O', '2022-12-26 10:25:17', '2022-12-26 10:25:17', NULL),
(4, 'Admin', 'ytck@a.ru', '$2y$10$FzVqzoOx4cXVqzwhRpZdeuBVYdZyCK4kEyiKX4YIVbTNZaQO.2amy', '2023-03-05 10:58:43', '2023-03-05 10:58:43', NULL),
(6, 'Admin', 'yytck@a.ru', '$2y$10$wGyD/hC6gkIvCUyPCuPUrev9ASbaRY1OC8Y9H.eqC698X8o.TXFxu', '2023-03-05 10:59:19', '2023-03-05 10:59:19', NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `task_file`
--
ALTER TABLE `task_file`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `path` (`path`),
  ADD KEY `task_id` (`task_id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `project`
--
ALTER TABLE `project`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT для таблицы `task`
--
ALTER TABLE `task`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT для таблицы `task_file`
--
ALTER TABLE `task_file`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `project_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `task_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `task_file`
--
ALTER TABLE `task_file`
  ADD CONSTRAINT `task_file_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
