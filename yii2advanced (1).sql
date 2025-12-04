-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Хост: mysql
-- Время создания: Дек 04 2025 г., 12:57
-- Версия сервера: 5.7.44
-- Версия PHP: 8.2.27

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
(336, 16, 'single', 'uploads/questions/1764825133_10.jpg', 'A'),
(337, 16, 'single', 'uploads/questions/1764825133_11.jpg', 'A'),
(338, 16, 'single', 'uploads/questions/1764825133_12.jpg', 'A'),
(339, 16, 'single', 'uploads/questions/1764825133_13.jpg', 'A'),
(340, 16, 'single', 'uploads/questions/1764825133_14.jpg', 'C'),
(341, 16, 'single', 'uploads/questions/1764825133_15.jpg', 'D'),
(342, 16, 'single', 'uploads/questions/1764825133_16.jpg', 'A'),
(343, 16, 'single', 'uploads/questions/1764825133_17.jpg', 'B'),
(344, 16, 'single', 'uploads/questions/1764825133_18.jpg', 'C'),
(345, 16, 'single', 'uploads/questions/1764825133_19.jpg', 'D'),
(346, 16, 'single', 'uploads/questions/1764825133_20.jpg', 'A'),
(347, 16, 'single', 'uploads/questions/1764825133_21.jpg', 'A'),
(348, 16, 'single', 'uploads/questions/1764825133_22.jpg', 'D'),
(349, 16, 'single', 'uploads/questions/1764825133_23.jpg', 'C'),
(350, 16, 'single', 'uploads/questions/1764825133_24.jpg', 'B'),
(351, 16, 'single', 'uploads/questions/1764825133_25.jpg', 'D'),
(352, 16, 'single', 'uploads/questions/1764825133_26.jpg', 'C'),
(353, 16, 'single', 'uploads/questions/1764825133_27.jpg', 'A'),
(354, 16, 'single', 'uploads/questions/1764825133_28.jpg', 'D'),
(355, 16, 'single', 'uploads/questions/1764825133_29.jpg', 'A'),
(356, 16, 'single', 'uploads/questions/1764825133_30.jpg', 'A'),
(357, 16, 'single', 'uploads/questions/1764825133_31.jpg', 'A'),
(358, 16, 'single', 'uploads/questions/1764825133_32.jpg', 'A'),
(359, 16, 'single', 'uploads/questions/1764825133_33.jpg', 'D'),
(360, 16, 'single', 'uploads/questions/1764825133_34.jpg', 'D'),
(361, 16, 'single', 'uploads/questions/1764825133_35.jpg', 'D'),
(362, 16, 'single', 'uploads/questions/1764825133_36.jpg', 'B'),
(363, 16, 'single', 'uploads/questions/1764825133_37.jpg', 'C'),
(364, 16, 'single', 'uploads/questions/1764825133_38.jpg', 'D'),
(365, 16, 'single', 'uploads/questions/1764825133_39.jpg', 'A'),
(366, 16, 'match', 'uploads/questions/1764825133_40.jpg', 'A-2 B-1'),
(367, 16, 'match', 'uploads/questions/1764825133_41.jpg', 'A-2 B-3'),
(368, 16, 'match', 'uploads/questions/1764825133_42.jpg', 'A-3 B-2'),
(369, 16, 'match', 'uploads/questions/1764825133_43.jpg', 'A-3 B-4'),
(370, 16, 'match', 'uploads/questions/1764825133_44.jpg', 'A-4 B-3'),
(371, 16, 'multiple', 'uploads/questions/1764825133_45.jpg', 'BDF'),
(372, 16, 'multiple', 'uploads/questions/1764825133_46.jpg', 'CDF'),
(373, 16, 'multiple', 'uploads/questions/1764825133_47.jpg', 'BE'),
(374, 16, 'multiple', 'uploads/questions/1764825133_48.jpg', 'D'),
(375, 16, 'multiple', 'uploads/questions/1764825133_49.jpg', 'D'),
(376, 17, 'single', 'uploads/questions/1764825416_10.jpg', 'C'),
(377, 17, 'single', 'uploads/questions/1764825416_11.jpg', 'A'),
(378, 17, 'single', 'uploads/questions/1764825416_12.jpg', 'A'),
(379, 17, 'single', 'uploads/questions/1764825416_13.jpg', 'A'),
(380, 17, 'single', 'uploads/questions/1764825416_14.jpg', 'A'),
(381, 17, 'single', 'uploads/questions/1764825416_15.jpg', 'D'),
(382, 17, 'single', 'uploads/questions/1764825416_16.jpg', 'D'),
(383, 17, 'single', 'uploads/questions/1764825416_17.jpg', 'C'),
(384, 17, 'single', 'uploads/questions/1764825416_18.jpg', 'D'),
(385, 17, 'single', 'uploads/questions/1764825416_19.jpg', 'C'),
(386, 17, 'single', 'uploads/questions/1764825416_20.jpg', 'B'),
(387, 17, 'single', 'uploads/questions/1764825416_21.jpg', 'C'),
(388, 17, 'single', 'uploads/questions/1764825416_22.jpg', 'B'),
(389, 17, 'single', 'uploads/questions/1764825416_23.jpg', 'C'),
(390, 17, 'single', 'uploads/questions/1764825416_24.jpg', 'B'),
(391, 17, 'single', 'uploads/questions/1764825416_25.jpg', 'D'),
(392, 17, 'single', 'uploads/questions/1764825416_26.jpg', 'A'),
(393, 17, 'single', 'uploads/questions/1764825416_27.jpg', 'B'),
(394, 17, 'single', 'uploads/questions/1764825416_28.jpg', 'D'),
(395, 17, 'single', 'uploads/questions/1764825416_29.jpg', 'B'),
(396, 17, 'single', 'uploads/questions/1764825416_30.jpg', 'A'),
(397, 17, 'single', 'uploads/questions/1764825416_31.jpg', 'D'),
(398, 17, 'single', 'uploads/questions/1764825416_32.jpg', 'A'),
(399, 17, 'single', 'uploads/questions/1764825416_33.jpg', 'A'),
(400, 17, 'single', 'uploads/questions/1764825416_34.jpg', 'D'),
(401, 17, 'single', 'uploads/questions/1764825416_35.jpg', 'A'),
(402, 17, 'single', 'uploads/questions/1764825416_36.jpg', 'B'),
(403, 17, 'single', 'uploads/questions/1764825416_37.jpg', 'A'),
(404, 17, 'single', 'uploads/questions/1764825416_38.jpg', 'D'),
(405, 17, 'single', 'uploads/questions/1764825416_39.jpg', 'B'),
(406, 17, 'match', 'uploads/questions/1764825416_40.jpg', 'A-1 B-2'),
(407, 17, 'match', 'uploads/questions/1764825416_41.jpg', 'A-2 B-3'),
(408, 17, 'match', 'uploads/questions/1764825416_42.jpg', 'A-3 B-4'),
(409, 17, 'match', 'uploads/questions/1764825416_43.jpg', 'A-1 B-3'),
(410, 17, 'match', 'uploads/questions/1764825416_44.jpg', 'A-3 B-1'),
(411, 17, 'multiple', 'uploads/questions/1764825416_45.jpg', 'AEF'),
(412, 17, 'multiple', 'uploads/questions/1764825416_46.jpg', 'BE'),
(413, 17, 'multiple', 'uploads/questions/1764825416_47.jpg', 'CDE'),
(414, 17, 'multiple', 'uploads/questions/1764825416_48.jpg', 'BDE'),
(415, 17, 'multiple', 'uploads/questions/1764825416_49.jpg', 'ABC'),
(426, 20, 'single', 'uploads/questions/1764826219_10.jpg', 'B'),
(427, 20, 'single', 'uploads/questions/1764826219_11.jpg', 'C'),
(428, 20, 'single', 'uploads/questions/1764826219_12.jpg', 'B'),
(429, 20, 'single', 'uploads/questions/1764826219_13.jpg', 'A'),
(430, 20, 'single', 'uploads/questions/1764826219_14.jpg', 'D'),
(431, 20, 'single', 'uploads/questions/1764826219_15.jpg', 'D'),
(432, 20, 'single', 'uploads/questions/1764826219_16.jpg', 'A'),
(433, 20, 'single', 'uploads/questions/1764826219_17.jpg', 'B'),
(434, 20, 'single', 'uploads/questions/1764826219_18.jpg', 'D'),
(435, 20, 'single', 'uploads/questions/1764826219_19.jpg', 'A'),
(436, 20, 'single', 'uploads/questions/1764826219_20.jpg', 'A'),
(437, 20, 'single', 'uploads/questions/1764826219_21.jpg', 'B'),
(438, 20, 'single', 'uploads/questions/1764826219_22.jpg', 'D'),
(439, 20, 'single', 'uploads/questions/1764826219_23.jpg', 'A'),
(440, 20, 'single', 'uploads/questions/1764826219_24.jpg', 'C'),
(441, 20, 'single', 'uploads/questions/1764826219_25.jpg', 'B'),
(442, 20, 'single', 'uploads/questions/1764826219_26.jpg', 'A'),
(443, 20, 'single', 'uploads/questions/1764826219_27.jpg', 'B'),
(444, 20, 'single', 'uploads/questions/1764826219_28.jpg', 'C'),
(445, 20, 'single', 'uploads/questions/1764826219_29.jpg', 'A'),
(446, 21, 'single', 'uploads/questions/1764826375_10.jpg', 'C'),
(447, 21, 'single', 'uploads/questions/1764826375_11.jpg', 'A'),
(448, 21, 'single', 'uploads/questions/1764826375_12.jpg', 'A'),
(449, 21, 'single', 'uploads/questions/1764826375_13.jpg', 'B'),
(450, 21, 'single', 'uploads/questions/1764826375_14.jpg', 'D'),
(451, 21, 'single', 'uploads/questions/1764826375_15.jpg', 'C'),
(452, 21, 'single', 'uploads/questions/1764826375_16.jpg', 'C'),
(453, 21, 'single', 'uploads/questions/1764826375_17.jpg', 'D'),
(454, 21, 'single', 'uploads/questions/1764826375_18.jpg', 'A'),
(455, 21, 'single', 'uploads/questions/1764826375_19.jpg', 'D'),
(456, 21, 'single', 'uploads/questions/1764826375_20.jpg', 'C'),
(457, 21, 'single', 'uploads/questions/1764826375_21.jpg', 'B'),
(458, 21, 'single', 'uploads/questions/1764826375_22.jpg', 'D'),
(459, 21, 'single', 'uploads/questions/1764826375_23.jpg', 'A'),
(460, 21, 'single', 'uploads/questions/1764826375_24.jpg', 'B'),
(461, 21, 'single', 'uploads/questions/1764826375_25.jpg', 'A'),
(462, 21, 'single', 'uploads/questions/1764826375_26.jpg', 'C'),
(463, 21, 'single', 'uploads/questions/1764826375_27.jpg', 'D'),
(464, 21, 'single', 'uploads/questions/1764826375_28.jpg', 'B'),
(465, 21, 'single', 'uploads/questions/1764826375_29.jpg', 'C'),
(466, 22, 'single', 'uploads/questions/1764826607_10.jpg', 'C'),
(467, 22, 'single', 'uploads/questions/1764826607_11.jpg', 'C'),
(468, 22, 'single', 'uploads/questions/1764826607_12.jpg', 'A'),
(469, 22, 'single', 'uploads/questions/1764826607_13.jpg', 'A'),
(470, 22, 'single', 'uploads/questions/1764826607_14.jpg', 'A'),
(471, 22, 'single', 'uploads/questions/1764826607_15.jpg', 'B'),
(472, 22, 'single', 'uploads/questions/1764826607_16.jpg', 'C'),
(473, 22, 'single', 'uploads/questions/1764826607_17.jpg', 'C'),
(474, 22, 'single', 'uploads/questions/1764826607_18.jpg', 'C'),
(475, 22, 'single', 'uploads/questions/1764826607_19.jpg', 'B'),
(476, 22, 'single', 'uploads/questions/1764826607_20.jpg', 'D'),
(477, 22, 'single', 'uploads/questions/1764826607_21.jpg', 'B'),
(478, 22, 'single', 'uploads/questions/1764826607_22.jpg', 'C'),
(479, 22, 'single', 'uploads/questions/1764826607_23.jpg', 'A'),
(480, 22, 'single', 'uploads/questions/1764826607_24.jpg', 'D'),
(481, 22, 'single', 'uploads/questions/1764826607_25.jpg', 'A'),
(482, 22, 'single', 'uploads/questions/1764826607_26.jpg', 'D'),
(483, 22, 'single', 'uploads/questions/1764826607_27.jpg', 'B'),
(484, 22, 'single', 'uploads/questions/1764826607_28.jpg', 'D'),
(485, 22, 'single', 'uploads/questions/1764826607_29.jpg', 'C'),
(486, 22, 'single', 'uploads/questions/1764826607_30.jpg', 'B'),
(487, 22, 'single', 'uploads/questions/1764826607_31.jpg', 'C'),
(488, 22, 'single', 'uploads/questions/1764826607_32.jpg', 'C'),
(489, 22, 'single', 'uploads/questions/1764826607_33.jpg', 'B'),
(490, 22, 'single', 'uploads/questions/1764826607_34.jpg', 'D'),
(491, 22, 'single', 'uploads/questions/1764826607_35.jpg', 'C'),
(492, 22, 'single', 'uploads/questions/1764826607_36.jpg', 'B'),
(493, 22, 'single', 'uploads/questions/1764826607_37.jpg', 'B'),
(494, 22, 'single', 'uploads/questions/1764826608_38.jpg', 'C'),
(495, 22, 'single', 'uploads/questions/1764826608_39.jpg', 'C'),
(496, 22, 'match', 'uploads/questions/1764826608_40.jpg', 'A-4 B-2'),
(497, 22, 'match', 'uploads/questions/1764826608_41.jpg', 'A-1 B-4'),
(498, 22, 'match', 'uploads/questions/1764826608_42.jpg', 'A-3 B-2'),
(499, 22, 'match', 'uploads/questions/1764826608_43.jpg', 'A-1 B-3'),
(500, 22, 'match', 'uploads/questions/1764826608_44.jpg', 'A-2  B-4'),
(501, 22, 'multiple', 'uploads/questions/1764826608_45.jpg', 'BEF'),
(502, 22, 'multiple', 'uploads/questions/1764826608_46.jpg', 'BE'),
(503, 22, 'multiple', 'uploads/questions/1764826608_47.jpg', 'AD'),
(504, 22, 'multiple', 'uploads/questions/1764826608_48.jpg', 'BD'),
(505, 22, 'multiple', 'uploads/questions/1764826608_49.jpg', 'CF'),
(506, 23, 'single', 'uploads/questions/1764826876_10.jpg', 'C'),
(507, 23, 'single', 'uploads/questions/1764826876_11.jpg', 'C'),
(508, 23, 'single', 'uploads/questions/1764826876_12.jpg', 'C'),
(509, 23, 'single', 'uploads/questions/1764826876_13.jpg', 'A'),
(510, 23, 'single', 'uploads/questions/1764826876_14.jpg', 'B'),
(511, 23, 'single', 'uploads/questions/1764826876_15.jpg', 'C'),
(512, 23, 'single', 'uploads/questions/1764826876_16.jpg', 'D'),
(513, 23, 'single', 'uploads/questions/1764826876_17.jpg', 'B'),
(514, 23, 'single', 'uploads/questions/1764826876_18.jpg', 'C'),
(515, 23, 'single', 'uploads/questions/1764826876_19.jpg', 'B'),
(516, 23, 'single', 'uploads/questions/1764826876_20.jpg', 'C'),
(517, 23, 'single', 'uploads/questions/1764826876_21.jpg', 'D'),
(518, 23, 'single', 'uploads/questions/1764826876_22.jpg', 'A'),
(519, 23, 'single', 'uploads/questions/1764826876_23.jpg', 'D'),
(520, 23, 'single', 'uploads/questions/1764826876_24.jpg', 'C'),
(521, 23, 'single', 'uploads/questions/1764826876_25.jpg', 'A'),
(522, 23, 'single', 'uploads/questions/1764826876_26.jpg', 'C'),
(523, 23, 'single', 'uploads/questions/1764826876_27.jpg', 'B'),
(524, 23, 'single', 'uploads/questions/1764826876_28.jpg', 'D'),
(525, 23, 'single', 'uploads/questions/1764826876_29.jpg', 'B'),
(526, 23, 'single', 'uploads/questions/1764826876_30.jpg', 'D'),
(527, 23, 'single', 'uploads/questions/1764826876_31.jpg', 'C'),
(528, 23, 'single', 'uploads/questions/1764826876_32.jpg', 'D'),
(529, 23, 'single', 'uploads/questions/1764826876_33.jpg', 'A'),
(530, 23, 'single', 'uploads/questions/1764826876_34.jpg', 'B'),
(531, 23, 'single', 'uploads/questions/1764826876_35.jpg', 'C'),
(532, 23, 'single', 'uploads/questions/1764826876_36.jpg', 'B'),
(533, 23, 'single', 'uploads/questions/1764826876_37.jpg', 'D'),
(534, 23, 'single', 'uploads/questions/1764826876_38.jpg', 'C'),
(535, 23, 'single', 'uploads/questions/1764826876_39.jpg', 'C'),
(536, 23, 'match', 'uploads/questions/1764826876_40.jpg', 'A-2 B-4'),
(537, 23, 'match', 'uploads/questions/1764826876_41.jpg', 'A-4 B-1'),
(538, 23, 'match', 'uploads/questions/1764826876_42.jpg', 'A-2 B-3'),
(539, 23, 'match', 'uploads/questions/1764826876_43.jpg', 'A-1 B-2'),
(540, 23, 'match', 'uploads/questions/1764826876_44.jpg', 'A-1 B-2'),
(541, 23, 'multiple', 'uploads/questions/1764826876_45.jpg', 'AD'),
(542, 23, 'multiple', 'uploads/questions/1764826876_46.jpg', 'C'),
(543, 23, 'multiple', 'uploads/questions/1764826876_47.jpg', 'BE'),
(544, 23, 'multiple', 'uploads/questions/1764826876_48.jpg', 'CF'),
(545, 23, 'multiple', 'uploads/questions/1764826876_49.jpg', 'AD'),
(546, 24, 'single', 'uploads/questions/1764827046_10.jpg', 'D'),
(547, 24, 'single', 'uploads/questions/1764827046_11.jpg', 'C'),
(548, 24, 'single', 'uploads/questions/1764827046_12.jpg', 'D'),
(549, 24, 'single', 'uploads/questions/1764827046_13.jpg', 'B'),
(550, 24, 'single', 'uploads/questions/1764827046_14.jpg', 'B'),
(551, 24, 'single', 'uploads/questions/1764827046_15.jpg', 'B'),
(552, 24, 'single', 'uploads/questions/1764827046_16.jpg', 'D'),
(553, 24, 'single', 'uploads/questions/1764827046_17.jpg', 'D'),
(554, 24, 'single', 'uploads/questions/1764827046_18.jpg', 'D'),
(555, 24, 'single', 'uploads/questions/1764827046_19.jpg', 'B'),
(556, 25, 'single', 'uploads/questions/1764827111_10.jpg', 'C'),
(557, 25, 'single', 'uploads/questions/1764827111_11.jpg', 'D'),
(558, 25, 'single', 'uploads/questions/1764827111_12.jpg', 'C'),
(559, 25, 'single', 'uploads/questions/1764827111_13.jpg', 'D'),
(560, 25, 'single', 'uploads/questions/1764827111_14.jpg', 'C'),
(561, 25, 'single', 'uploads/questions/1764827111_15.jpg', 'B'),
(562, 25, 'single', 'uploads/questions/1764827111_16.jpg', 'D'),
(563, 25, 'single', 'uploads/questions/1764827111_17.jpg', 'D'),
(564, 25, 'single', 'uploads/questions/1764827111_18.jpg', 'A'),
(565, 25, 'single', 'uploads/questions/1764827111_19.jpg', 'C'),
(566, 26, 'single', 'uploads/questions/1764827266_10.jpg', 'B'),
(567, 26, 'single', 'uploads/questions/1764827266_11.jpg', 'B'),
(568, 26, 'single', 'uploads/questions/1764827266_12.jpg', 'D'),
(569, 26, 'single', 'uploads/questions/1764827266_13.jpg', 'C'),
(570, 26, 'single', 'uploads/questions/1764827266_14.jpg', 'A'),
(571, 26, 'single', 'uploads/questions/1764827266_15.jpg', 'C'),
(572, 26, 'single', 'uploads/questions/1764827266_16.jpg', 'B'),
(573, 26, 'single', 'uploads/questions/1764827266_17.jpg', 'C'),
(574, 26, 'single', 'uploads/questions/1764827266_18.jpg', 'B'),
(575, 26, 'single', 'uploads/questions/1764827266_19.jpg', 'C'),
(576, 27, 'single', 'uploads/questions/1764827342_10.jpg', 'C'),
(577, 27, 'single', 'uploads/questions/1764827342_11.jpg', 'C'),
(578, 27, 'single', 'uploads/questions/1764827342_12.jpg', 'A'),
(579, 27, 'single', 'uploads/questions/1764827342_13.jpg', 'B'),
(580, 27, 'single', 'uploads/questions/1764827342_14.jpg', 'B'),
(581, 27, 'single', 'uploads/questions/1764827342_15.jpg', 'C'),
(582, 27, 'single', 'uploads/questions/1764827342_16.jpg', 'A'),
(583, 27, 'single', 'uploads/questions/1764827342_17.jpg', 'D'),
(584, 27, 'single', 'uploads/questions/1764827342_18.jpg', 'D'),
(585, 27, 'single', 'uploads/questions/1764827342_19.jpg', 'C'),
(586, 28, 'single', 'uploads/questions/1764849543_10.jpg', 'C'),
(587, 28, 'single', 'uploads/questions/1764849543_11.jpg', 'A'),
(588, 28, 'single', 'uploads/questions/1764849543_12.jpg', 'A'),
(589, 28, 'single', 'uploads/questions/1764849543_13.jpg', 'A'),
(590, 28, 'single', 'uploads/questions/1764849543_14.jpg', 'A'),
(591, 28, 'single', 'uploads/questions/1764849543_15.jpg', 'D'),
(592, 28, 'single', 'uploads/questions/1764849543_16.jpg', 'D'),
(593, 28, 'single', 'uploads/questions/1764849543_17.jpg', 'C'),
(594, 28, 'single', 'uploads/questions/1764849543_18.jpg', 'D'),
(595, 28, 'single', 'uploads/questions/1764849543_19.jpg', 'C'),
(596, 28, 'single', 'uploads/questions/1764849543_20.jpg', 'B'),
(597, 28, 'single', 'uploads/questions/1764849543_21.jpg', 'C'),
(598, 28, 'single', 'uploads/questions/1764849543_22.jpg', 'B'),
(599, 28, 'single', 'uploads/questions/1764849543_23.jpg', 'C'),
(600, 28, 'single', 'uploads/questions/1764849543_24.jpg', 'B'),
(601, 28, 'single', 'uploads/questions/1764849543_25.jpg', 'D'),
(602, 28, 'single', 'uploads/questions/1764849543_26.jpg', 'A'),
(603, 28, 'single', 'uploads/questions/1764849543_27.jpg', 'B'),
(604, 28, 'single', 'uploads/questions/1764849543_28.jpg', 'D'),
(605, 28, 'single', 'uploads/questions/1764849543_29.jpg', 'B'),
(606, 28, 'single', 'uploads/questions/1764849543_30.jpg', 'A'),
(607, 28, 'single', 'uploads/questions/1764849543_31.jpg', 'D'),
(608, 28, 'single', 'uploads/questions/1764849543_32.jpg', 'A'),
(609, 28, 'single', 'uploads/questions/1764849543_33.jpg', 'A'),
(610, 28, 'single', 'uploads/questions/1764849543_34.jpg', 'D'),
(611, 28, 'single', 'uploads/questions/1764849543_35.jpg', 'A'),
(612, 28, 'single', 'uploads/questions/1764849543_36.jpg', 'B'),
(613, 28, 'single', 'uploads/questions/1764849543_37.jpg', 'A'),
(614, 28, 'single', 'uploads/questions/1764849543_38.jpg', 'D'),
(615, 28, 'single', 'uploads/questions/1764849543_39.jpg', 'B'),
(616, 28, 'match', 'uploads/questions/1764849543_40.jpg', 'A-1 B-2'),
(617, 28, 'match', 'uploads/questions/1764849543_41.jpg', 'A-2 B-3'),
(618, 28, 'match', 'uploads/questions/1764849543_42.jpg', 'A-3 B-4'),
(619, 28, 'match', 'uploads/questions/1764849543_43.jpg', 'A-1 B-3'),
(620, 28, 'match', 'uploads/questions/1764849543_44.jpg', 'A-3 B-1'),
(621, 28, 'multiple', 'uploads/questions/1764849543_45.jpg', 'A E F'),
(622, 28, 'multiple', 'uploads/questions/1764849543_46.jpg', 'B E'),
(623, 28, 'multiple', 'uploads/questions/1764849543_47.jpg', 'C D E'),
(624, 28, 'multiple', 'uploads/questions/1764849543_48.jpg', 'B D E'),
(625, 28, 'multiple', 'uploads/questions/1764849543_49.jpg', 'A B C');

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
(4, 'Оқу Сауаттылығы'),
(5, 'Математикалық Сауаттылық'),
(6, 'Қазақстан Тарихы'),
(7, 'Шет тілі'),
(8, 'География'),
(9, 'Дүниежүзі Тарихы'),
(10, 'Қазақ Тілі'),
(11, 'Орыс Тілі'),
(12, 'Химия'),
(13, 'Физика'),
(14, 'Информатика'),
(15, 'Құқық Негіздері');

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
(16, 14, 1, 'public'),
(17, 14, 2, 'public'),
(20, 6, 1, 'public'),
(21, 6, 2, 'public'),
(22, 2, 1, 'public'),
(23, 2, 2, 'public'),
(24, 5, 1, 'public'),
(25, 5, 2, 'public'),
(26, 4, 1, 'public'),
(27, 4, 2, 'public'),
(28, 14, 3, 'public');

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
(5, 'муха бейба', '980330350847', 'gQLDZ27x8jdpccJ-7YHLvYi2TYn9H-_B', NULL),
(6, 'Муха Бейба', '980330350848', 'weuMJ_7OID0JkqFMJSdFEgXxvoRlQ8jd', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `user_question`
--

CREATE TABLE `user_question` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `user_question`
--

INSERT INTO `user_question` (`id`, `user_id`, `question_id`, `answer`) VALUES
(1, 5, 566, 'B'),
(2, 5, 498, 'A-2 B-3'),
(3, 5, 503, 'B D E'),
(4, 5, 568, 'C'),
(5, 5, 505, 'C E'),
(7, 5, 497, 'A-1 B-2'),
(10, 5, 414, 'E'),
(11, 5, 415, 'E F'),
(12, 5, 567, 'D'),
(13, 5, 569, 'C'),
(14, 5, 570, 'D'),
(15, 5, 571, 'D'),
(16, 5, 572, 'D'),
(17, 5, 573, 'D'),
(18, 5, 574, 'D'),
(19, 5, 575, 'D'),
(20, 5, 546, 'D'),
(21, 5, 547, 'D'),
(22, 5, 548, 'D'),
(23, 5, 549, 'D'),
(24, 5, 550, 'D'),
(25, 5, 551, 'D'),
(26, 5, 552, 'D'),
(27, 5, 553, 'D'),
(28, 5, 554, 'D'),
(29, 5, 555, 'D'),
(30, 5, 426, 'D'),
(31, 5, 427, 'D'),
(32, 5, 428, 'D'),
(33, 5, 429, 'D'),
(34, 5, 430, 'D'),
(35, 5, 431, 'D'),
(36, 5, 432, 'D'),
(37, 5, 433, 'D'),
(38, 5, 434, 'D'),
(39, 5, 435, 'D'),
(40, 5, 436, 'D'),
(41, 5, 437, 'D'),
(42, 5, 438, 'D'),
(43, 5, 439, 'D'),
(44, 5, 440, 'D'),
(45, 5, 441, 'D'),
(46, 5, 442, 'D'),
(47, 5, 443, 'D'),
(48, 5, 444, 'D'),
(49, 5, 445, 'D'),
(50, 5, 466, 'D'),
(51, 5, 467, 'D'),
(52, 5, 468, 'D'),
(53, 5, 469, 'D'),
(54, 5, 470, 'D'),
(55, 5, 471, 'D'),
(56, 5, 472, 'D'),
(57, 5, 473, 'D'),
(58, 5, 474, 'D'),
(59, 5, 475, 'D'),
(60, 5, 476, 'D'),
(61, 5, 477, 'D'),
(62, 5, 478, 'D'),
(63, 5, 479, 'D'),
(64, 5, 480, 'D'),
(65, 5, 481, 'D'),
(66, 5, 482, 'D'),
(67, 5, 483, 'D'),
(68, 5, 484, 'D'),
(69, 5, 485, 'D'),
(70, 5, 486, 'D'),
(71, 5, 487, 'D'),
(72, 5, 488, 'D'),
(73, 5, 489, 'D'),
(74, 5, 490, 'D'),
(75, 5, 491, 'D'),
(76, 5, 492, 'D'),
(77, 5, 493, 'D'),
(78, 5, 494, 'D'),
(79, 5, 495, 'D'),
(80, 5, 496, 'A-4 B-4'),
(81, 5, 499, 'A-4 B-4'),
(82, 5, 500, 'A-4 B-4'),
(83, 5, 501, 'E F'),
(84, 5, 502, 'E F'),
(85, 5, 504, 'E F'),
(86, 5, 376, 'D'),
(87, 5, 377, 'D'),
(88, 5, 378, 'D'),
(89, 5, 379, 'D'),
(90, 5, 380, 'D'),
(91, 5, 381, 'D'),
(92, 5, 382, 'D'),
(93, 5, 383, 'D'),
(94, 5, 384, 'D'),
(95, 5, 385, 'D'),
(96, 5, 386, 'D'),
(97, 5, 387, 'D'),
(98, 5, 388, 'D'),
(99, 5, 389, 'D'),
(100, 5, 390, 'D'),
(101, 5, 391, 'D'),
(102, 5, 392, 'D'),
(103, 5, 393, 'D'),
(104, 5, 394, 'D'),
(105, 5, 395, 'D'),
(106, 5, 396, 'D'),
(107, 5, 397, 'D'),
(108, 5, 398, 'D'),
(109, 5, 399, 'D'),
(110, 5, 400, 'D'),
(111, 5, 401, 'D'),
(112, 5, 402, 'D'),
(113, 5, 403, 'D'),
(114, 5, 404, 'D'),
(115, 5, 405, 'D'),
(116, 5, 406, 'A-4 B-4'),
(117, 5, 407, 'A-4 B-4'),
(118, 5, 408, 'A-4 B-4'),
(119, 5, 409, 'A-4 B-4'),
(120, 5, 410, 'A-4 B-4'),
(121, 5, 411, 'E F'),
(122, 5, 412, 'E F'),
(123, 5, 413, 'E F'),
(124, 6, 586, 'D'),
(125, 6, 587, 'D'),
(126, 6, 588, 'D'),
(127, 6, 589, 'D'),
(128, 6, 590, 'D'),
(129, 6, 591, 'D'),
(130, 6, 592, 'D'),
(131, 6, 593, 'D'),
(132, 6, 594, 'D'),
(133, 6, 595, 'D'),
(134, 6, 596, 'D'),
(135, 6, 597, 'D'),
(136, 6, 598, 'D'),
(137, 6, 599, 'D'),
(138, 6, 600, 'D'),
(139, 6, 601, 'D'),
(140, 6, 602, 'D'),
(141, 6, 603, 'D'),
(142, 6, 604, 'D'),
(143, 6, 605, 'D'),
(144, 6, 606, 'D'),
(145, 6, 607, 'D'),
(146, 6, 608, 'D'),
(147, 6, 609, 'D'),
(148, 6, 610, 'D'),
(149, 6, 611, 'D'),
(150, 6, 612, 'D'),
(151, 6, 613, 'D'),
(152, 6, 614, 'D'),
(153, 6, 615, 'D'),
(154, 6, 616, 'A-4 B-4'),
(155, 6, 617, 'A-4 B-4'),
(156, 6, 618, 'A-4 B-4'),
(157, 6, 619, 'A-4 B-4'),
(158, 6, 620, 'A-4 B-4'),
(164, 6, 621, 'E F'),
(165, 6, 622, 'E F'),
(166, 6, 623, 'E F'),
(167, 6, 624, 'E F'),
(169, 6, 625, 'A B C');

-- --------------------------------------------------------

--
-- Структура таблицы `user_test`
--

CREATE TABLE `user_test` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `score` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `user_test`
--

INSERT INTO `user_test` (`id`, `user_id`, `test_id`, `start_time`, `end_time`, `score`) VALUES
(94, 5, 26, '2025-12-04 14:54:58', '2025-12-04 16:50:49', 2.00),
(95, 5, 24, '2025-12-04 14:54:58', '2025-12-04 16:50:49', 5.00),
(96, 5, 20, '2025-12-04 14:54:58', '2025-12-04 16:50:49', 4.00),
(97, 5, 22, '2025-12-04 14:54:58', '2025-12-04 16:50:49', 8.00),
(98, 5, 17, '2025-12-04 14:54:58', '2025-12-04 16:50:49', 9.00),
(99, 6, 28, '2025-12-04 14:54:58', '2025-12-04 17:09:02', 15.00);

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
-- Индексы таблицы `user_question`
--
ALTER TABLE `user_question`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_user_question` (`user_id`,`question_id`),
  ADD KEY `fk_user_question_question` (`question_id`);

--
-- Индексы таблицы `user_test`
--
ALTER TABLE `user_test`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_test_user` (`user_id`),
  ADD KEY `fk_user_test_test` (`test_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=626;

--
-- AUTO_INCREMENT для таблицы `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `test`
--
ALTER TABLE `test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `user_question`
--
ALTER TABLE `user_question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;

--
-- AUTO_INCREMENT для таблицы `user_test`
--
ALTER TABLE `user_test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

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

--
-- Ограничения внешнего ключа таблицы `user_question`
--
ALTER TABLE `user_question`
  ADD CONSTRAINT `fk_user_question_question` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_question_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_test`
--
ALTER TABLE `user_test`
  ADD CONSTRAINT `fk_user_test_test` FOREIGN KEY (`test_id`) REFERENCES `test` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_test_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
