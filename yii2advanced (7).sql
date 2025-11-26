-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: mysql
-- Время создания: Ноя 26 2025 г., 18:59
-- Версия сервера: 5.7.44
-- Версия PHP: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `yii2advanced`
--

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1763915333),
('m130524_201442_init', 1763915335),
('m190124_110200_add_verification_token_column_to_user_table', 1763915335);

-- --------------------------------------------------------

--
-- Структура таблицы `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `img_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `correct` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `question`
--

INSERT INTO `question` (`id`, `test_id`, `type`, `img_path`, `correct`) VALUES
(81, 6, 'single', 'uploads/questions/6925a3ee9a8a3_crop_1_0.jpg', 'С'),
(82, 6, 'single', 'uploads/questions/6925a3ee9fbee_crop_1_1.jpg', 'С'),
(83, 6, 'single', 'uploads/questions/6925a3eea24a3_crop_1_2.jpg', 'С'),
(84, 6, 'single', 'uploads/questions/6925a3eea4d6a_crop_1_3.jpg', 'А'),
(85, 6, 'single', 'uploads/questions/6925a3eea7a24_crop_1_4.jpg', 'В'),
(86, 6, 'single', 'uploads/questions/6925a3eea9fb4_crop_1_5.jpg', 'С'),
(87, 6, 'single', 'uploads/questions/6925a3eeac47c_crop_2_10.jpg', 'D'),
(88, 6, 'single', 'uploads/questions/6925a3eeae5ac_crop_2_11.jpg', 'B'),
(89, 6, 'single', 'uploads/questions/6925a3eeb06e8_crop_2_6.jpg', 'C'),
(90, 6, 'single', 'uploads/questions/6925a3eeb3b91_crop_2_7.jpg', 'B'),
(91, 6, 'single', 'uploads/questions/6925a3eeb5bec_crop_2_8.jpg', 'C'),
(92, 6, 'single', 'uploads/questions/6925a3eeb7c37_crop_2_9.jpg', 'D'),
(93, 6, 'single', 'uploads/questions/6925a3eeba3ce_crop_3_12.jpg', 'A'),
(94, 6, 'single', 'uploads/questions/6925a3eebd146_crop_3_13.jpg', 'D'),
(95, 6, 'single', 'uploads/questions/6925a3eebf3f1_crop_3_14.jpg', 'C'),
(96, 6, 'single', 'uploads/questions/6925a3eec2282_crop_3_15.jpg', 'A'),
(97, 6, 'single', 'uploads/questions/6925a3eec4248_crop_3_16.jpg', 'C'),
(98, 6, 'single', 'uploads/questions/6925a3eec613f_crop_3_17.jpg', 'B'),
(99, 6, 'single', 'uploads/questions/6925a3eec7f39_crop_4_18.jpg', 'D'),
(100, 6, 'single', 'uploads/questions/6925a3eec9dae_crop_4_19.jpg', 'B'),
(101, 6, 'single', 'uploads/questions/6925a3eecbd86_crop_4_20.jpg', 'D'),
(102, 6, 'single', 'uploads/questions/6925a3eecdf0a_crop_4_21.jpg', 'C'),
(103, 6, 'single', 'uploads/questions/6925a3eecfefb_crop_5_22.jpg', 'D'),
(104, 6, 'single', 'uploads/questions/6925a3eed205e_crop_5_23.jpg', 'A'),
(105, 6, 'single', 'uploads/questions/6925a3eed52a9_crop_5_24.jpg', 'B'),
(106, 6, 'single', 'uploads/questions/6925a3eed76d4_crop_5_25.jpg', 'C'),
(107, 6, 'single', 'uploads/questions/6925a3eeda3eb_crop_5_26.jpg', 'B'),
(108, 6, 'single', 'uploads/questions/6925a3eedc28d_crop_5_27.jpg', 'D'),
(109, 6, 'single', 'uploads/questions/6925a3eeddfa9_crop_6_28.jpg', 'C'),
(110, 6, 'single', 'uploads/questions/6925a3eedfd6b_crop_6_29.jpg', 'C'),
(111, 6, 'match', 'uploads/questions/6925a3eee1d48_crop_6_30.jpg', 'A-2 B-4'),
(112, 6, 'match', 'uploads/questions/6925a3eee3f53_crop_6_31.jpg', 'A-4 B-1'),
(113, 6, 'match', 'uploads/questions/6925a3eee6197_crop_6_32.jpg', 'A-2 B-3'),
(114, 6, 'match', 'uploads/questions/6925a3eee7ea0_crop_7_33.jpg', 'A-1 B-2'),
(115, 6, 'match', 'uploads/questions/6925a3eeea441_crop_7_34.jpg', 'A-1 B-2'),
(116, 6, 'multiple', 'uploads/questions/6925a3eeed505_crop_7_35.jpg', 'AD'),
(117, 6, 'single', 'uploads/questions/6925a3eeef6cd_crop_7_36.jpg', 'C'),
(118, 6, 'multiple', 'uploads/questions/6925a3eef2d6c_crop_8_37.jpg', 'BE'),
(119, 6, 'multiple', 'uploads/questions/6925a3ef01186_crop_8_38.jpg', 'CF'),
(120, 6, 'multiple', 'uploads/questions/6925a3ef031ab_crop_8_39.jpg', 'AD'),
(121, 7, 'single', 'uploads/questions/69274a86ccc7d_10.jpg', 'C'),
(122, 7, 'single', 'uploads/questions/69274a86e3928_11.jpg', 'A'),
(123, 7, 'single', 'uploads/questions/69274a86e7ecf_12.jpg', 'A'),
(124, 7, 'single', 'uploads/questions/69274a86ec436_13.jpg', 'A'),
(125, 7, 'single', 'uploads/questions/69274a86f1419_14.jpg', 'A'),
(126, 7, 'single', 'uploads/questions/69274a8701548_15.jpg', 'D'),
(127, 7, 'single', 'uploads/questions/69274a87058d8_16.jpg', 'D'),
(128, 7, 'single', 'uploads/questions/69274a870a248_17.jpg', 'C'),
(129, 7, 'single', 'uploads/questions/69274a870e8e4_18.jpg', 'D'),
(130, 7, 'single', 'uploads/questions/69274a8713995_19.jpg', 'C'),
(131, 7, 'single', 'uploads/questions/69274a8717691_20.jpg', 'B'),
(132, 7, 'single', 'uploads/questions/69274a871b61d_21.jpg', 'C'),
(133, 7, 'single', 'uploads/questions/69274a871fbf2_22.jpg', 'B'),
(134, 7, 'single', 'uploads/questions/69274a87246ba_23.jpg', 'C'),
(135, 7, 'single', 'uploads/questions/69274a8729082_24.jpg', 'B'),
(136, 7, 'single', 'uploads/questions/69274a872e42c_25.jpg', 'D'),
(137, 7, 'single', 'uploads/questions/69274a87333ea_26.jpg', 'A'),
(138, 7, 'single', 'uploads/questions/69274a8738d3f_27.jpg', 'B'),
(139, 7, 'single', 'uploads/questions/69274a873d97c_28.jpg', 'D'),
(140, 7, 'single', 'uploads/questions/69274a8743300_29.jpg', 'B'),
(141, 7, 'single', 'uploads/questions/69274a8749cfb_30.jpg', 'A'),
(142, 7, 'single', 'uploads/questions/69274a874f12b_31.jpg', 'D'),
(143, 7, 'single', 'uploads/questions/69274a8754a6a_32.jpg', 'A'),
(144, 7, 'single', 'uploads/questions/69274a875aff4_33.jpg', 'A'),
(145, 7, 'single', 'uploads/questions/69274a8763a5c_34.jpg', 'D'),
(146, 7, 'single', 'uploads/questions/69274a8769589_35.jpg', 'A'),
(147, 7, 'single', 'uploads/questions/69274a8770007_36.jpg', 'B'),
(148, 7, 'single', 'uploads/questions/69274a8776423_37.jpg', 'A'),
(149, 7, 'single', 'uploads/questions/69274a877c2a4_38.jpg', 'D'),
(150, 7, 'single', 'uploads/questions/69274a8781d42_39.jpg', 'B'),
(151, 7, 'match', 'uploads/questions/69274a8786663_40.jpg', 'A-1 B-2'),
(152, 7, 'match', 'uploads/questions/69274a878ae33_41.jpg', 'A-2 B-3'),
(153, 7, 'match', 'uploads/questions/69274a878ff9a_42.jpg', 'A-3 B-4'),
(154, 7, 'match', 'uploads/questions/69274a8794ea0_43.jpg', 'A-1 B-3'),
(155, 7, 'match', 'uploads/questions/69274a8798bb6_44.jpg', 'A-3 B-1'),
(156, 7, 'multiple', 'uploads/questions/69274a879cf75_45.jpg', 'AEF'),
(157, 7, 'multiple', 'uploads/questions/69274a87a0f1c_46.jpg', 'BE'),
(158, 7, 'multiple', 'uploads/questions/69274a87a4c04_47.jpg', 'CDE'),
(159, 7, 'multiple', 'uploads/questions/69274a87a8056_48.jpg', 'BDE'),
(160, 7, 'multiple', 'uploads/questions/69274a87ab868_49.jpg', 'ABC');

-- --------------------------------------------------------

--
-- Структура таблицы `subject`
--

CREATE TABLE `subject` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `subject`
--

INSERT INTO `subject` (`id`, `title`) VALUES
(1, 'Биология'),
(2, 'Математика'),
(3, 'Информатика');

-- --------------------------------------------------------

--
-- Структура таблицы `test`
--

CREATE TABLE `test` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `version` int(11) NOT NULL,
  `status` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'new'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `test`
--

INSERT INTO `test` (`id`, `subject_id`, `version`, `status`) VALUES
(6, 2, 1, 'new'),
(7, 3, 1, 'new');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `auth_key`, `password_hash`) VALUES
(1, 'admin', 'admin', 'au1iKPvEQiBP6jHBK8qaLZI3_LMLaAJY', '$2y$13$oCzJism2GEWua9igEEDam.2Ie5ES8qznXovZFdrVA2LdyOh44UNGG'),
(4, 'Бейбарыс Мухаммедьяров', '980330350846', 'q58TESayDH7P0_TkfMVXBmwVaSWRauFs', NULL),
(5, NULL, '980330350847', 'gQLDZ27x8jdpccJ-7YHLvYi2TYn9H-_B', NULL),
(6, 'Муха Бейба', '980330350848', 'weuMJ_7OID0JkqFMJSdFEgXxvoRlQ8jd', NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_question_test` (`test_id`);

--
-- Индексы таблицы `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_test_subject` (`subject_id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT для таблицы `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `test`
--
ALTER TABLE `test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `fk_question_test` FOREIGN KEY (`test_id`) REFERENCES `test` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `test`
--
ALTER TABLE `test`
  ADD CONSTRAINT `fk_test_subject` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
