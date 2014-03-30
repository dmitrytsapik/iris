-- phpMyAdmin SQL Dump
-- version 4.0.6deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Мар 30 2014 г., 17:05
-- Версия сервера: 5.5.35-0ubuntu0.13.10.2
-- Версия PHP: 5.5.3-1ubuntu2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `journal`
--

-- --------------------------------------------------------

--
-- Структура таблицы `access_level`
--

CREATE TABLE IF NOT EXISTS `access_level` (
  `caption` char(50) CHARACTER SET utf8 NOT NULL,
  `levels` text NOT NULL,
  UNIQUE KEY `caption` (`caption`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `access_level`
--

INSERT INTO `access_level` (`caption`, `levels`) VALUES
('Admin', 'users,schedule'),
('BioChem', ''),
('Geo', ''),
('PhysDep', ''),
('Pupils', 'diary');

-- --------------------------------------------------------

--
-- Структура таблицы `classes`
--

CREATE TABLE IF NOT EXISTS `classes` (
  `login` text,
  `class` text,
  `group_` text,
  `year` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `curriculum_courses`
--

CREATE TABLE IF NOT EXISTS `curriculum_courses` (
  `caption` text NOT NULL,
  `author` text NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `date_change` date NOT NULL,
  `comment` text NOT NULL,
  `approval` text NOT NULL,
  `curriculum_course_sign` int(20) NOT NULL,
  PRIMARY KEY (`curriculum_course_sign`),
  UNIQUE KEY `curriculum_course_sign` (`curriculum_course_sign`),
  UNIQUE KEY `curriculum_course_sign_2` (`curriculum_course_sign`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `curriculum_courses`
--

INSERT INTO `curriculum_courses` (`caption`, `author`, `date_start`, `date_end`, `date_change`, `comment`, `approval`, `curriculum_course_sign`) VALUES
('English', 'admin', '0000-00-00', '0000-00-00', '0000-00-00', 'no', 'English for Dummies', 1379876162),
('Math', 'admin', '0000-00-00', '0000-00-00', '0000-00-00', 'no', 'none', 1380539782),
('1?', '', '0000-00-00', '0000-00-00', '0000-00-00', 'no', '??????????????', 1381002370),
('?????????? ? ??????????', 'admin', '0000-00-00', '0000-00-00', '0000-00-00', 'no', '', 1384858044);

-- --------------------------------------------------------

--
-- Структура таблицы `curriculum_lesson`
--

CREATE TABLE IF NOT EXISTS `curriculum_lesson` (
  `curriculum_theme_sign` int(20) NOT NULL,
  `curriculum_lesson_sign` int(20) NOT NULL,
  `caption` text NOT NULL,
  `homework` text NOT NULL,
  `date` date NOT NULL,
  `type` text NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`curriculum_lesson_sign`),
  UNIQUE KEY `curriculum_lesson_sign` (`curriculum_lesson_sign`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `curriculum_lesson`
--

INSERT INTO `curriculum_lesson` (`curriculum_theme_sign`, `curriculum_lesson_sign`, `caption`, `homework`, `date`, `type`, `comment`) VALUES
(1379876229, 1379879805, '11', '22', '2013-09-02', 'C', '1'),
(1379876229, 1379971423, 'tetsttsts', 'eeee', '2013-09-02', 'KP', 'eeeeeeeeeeee');

-- --------------------------------------------------------

--
-- Структура таблицы `curriculum_theme`
--

CREATE TABLE IF NOT EXISTS `curriculum_theme` (
  `curriculum_course_sign` int(20) NOT NULL,
  `curriculum_theme_sign` int(20) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `caption` text NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`curriculum_theme_sign`),
  UNIQUE KEY `curriculum_theme_sign` (`curriculum_theme_sign`),
  UNIQUE KEY `curriculum_theme_sign_2` (`curriculum_theme_sign`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `curriculum_theme`
--

INSERT INTO `curriculum_theme` (`curriculum_course_sign`, `curriculum_theme_sign`, `date_start`, `date_end`, `caption`, `comment`) VALUES
(1379876162, 1379876204, '0000-00-00', '0000-00-00', 'Subject #1', 'test'),
(1379876162, 1379876229, '0000-00-00', '0000-00-00', 'test', 'test'),
(1380539782, 1380539801, '0000-00-00', '0000-00-00', 'ALGEBRA', 'none');

-- --------------------------------------------------------

--
-- Структура таблицы `curriculum_type_of_work`
--

CREATE TABLE IF NOT EXISTS `curriculum_type_of_work` (
  `caption` text CHARACTER SET utf8 NOT NULL,
  `abbr` varchar(10) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`abbr`),
  UNIQUE KEY `abbr` (`abbr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `curriculum_type_of_work`
--

INSERT INTO `curriculum_type_of_work` (`caption`, `abbr`) VALUES
('Семинар', 'C'),
('Контрольная работа', 'KP');

-- --------------------------------------------------------

--
-- Структура таблицы `duration`
--

CREATE TABLE IF NOT EXISTS `duration` (
  `order_lesson` int(11) NOT NULL,
  `start` time NOT NULL,
  `end` time NOT NULL,
  PRIMARY KEY (`order_lesson`),
  UNIQUE KEY `order_lesson` (`order_lesson`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `duration`
--

INSERT INTO `duration` (`order_lesson`, `start`, `end`) VALUES
(1, '08:00:00', '08:45:00'),
(2, '09:00:00', '09:45:00');

-- --------------------------------------------------------

--
-- Структура таблицы `grades`
--

CREATE TABLE IF NOT EXISTS `grades` (
  `login` text,
  `date` date DEFAULT NULL,
  `class` text,
  `subject` text,
  `grade` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `gid` int(20) NOT NULL,
  `caption` text NOT NULL,
  `admin` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reg_date` date NOT NULL,
  `spec` text NOT NULL,
  `qualification` text NOT NULL,
  `foe` text NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`gid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`gid`, `caption`, `admin`, `start_date`, `end_date`, `reg_date`, `spec`, `qualification`, `foe`, `comment`) VALUES
(1385410141, 'РФ-211', 'admin', '2013-09-01', '2018-09-01', '2013-11-25', '', '', '', 'Бакалавр'),
(1395179192, 'ПФ-111', 'admin', '0000-00-00', '0000-00-00', '2014-03-18', 'Прикл. физ.', 'Бакалавр', 'Дневная', 'БЕЗ КОММЕНТ.');

-- --------------------------------------------------------

--
-- Структура таблицы `journals`
--

CREATE TABLE IF NOT EXISTS `journals` (
  `login` text,
  `date` text,
  `class` text,
  `subject` text,
  `theme` text,
  `homework` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `pupils`
--

CREATE TABLE IF NOT EXISTS `pupils` (
  `uniq_id` int(20) NOT NULL,
  `login` text NOT NULL,
  `group` int(11) NOT NULL,
  UNIQUE KEY `uniq_id` (`uniq_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `pupils`
--

INSERT INTO `pupils` (`uniq_id`, `login`, `group`) VALUES
(11224234, 'vladsuprun', 1385410141),
(31314143, 'dmitrytsapik', 1385410141),
(123454534, 'alexasmolov', 1385410141),
(1395345249, 'romanlyashenkov', 1395179192),
(1395345321, 'suleimanovismail', 1395179192),
(1395345492, 'valeriapanenko', 1395179192),
(1395349643, 'vladtishenko', 1395179192),
(1395350092, 'ernestfedosov', 1395179192),
(1395924595, 'denisyakovlev', 1395179192),
(1395935559, 'vadimefremenko', 1395179192);

-- --------------------------------------------------------

--
-- Структура таблицы `schedule`
--

CREATE TABLE IF NOT EXISTS `schedule` (
  `order_lesson` int(11) NOT NULL,
  `date` date NOT NULL,
  `caption` text CHARACTER SET utf8 NOT NULL,
  `login` text NOT NULL,
  `uniq_id` int(20) NOT NULL,
  PRIMARY KEY (`uniq_id`),
  UNIQUE KEY `uniq_id` (`uniq_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `schedule`
--

INSERT INTO `schedule` (`order_lesson`, `date`, `caption`, `login`, `uniq_id`) VALUES
(1, '2013-07-09', 'Русский язык', 'ivanov', 87678);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `surname` varchar(50) CHARACTER SET utf8 NOT NULL,
  `patronymic` text CHARACTER SET utf8 NOT NULL,
  `login` varchar(20) CHARACTER SET utf8 NOT NULL,
  `pass` text,
  `type` text,
  `birthday` text,
  `other` text,
  PRIMARY KEY (`login`),
  UNIQUE KEY `login` (`login`),
  UNIQUE KEY `login_2` (`login`),
  KEY `login_3` (`login`),
  FULLTEXT KEY `login_4` (`login`),
  FULLTEXT KEY `name` (`name`),
  FULLTEXT KEY `name_2` (`name`),
  FULLTEXT KEY `surname` (`surname`),
  FULLTEXT KEY `patronymic` (`patronymic`),
  FULLTEXT KEY `login_5` (`login`),
  FULLTEXT KEY `name_3` (`name`),
  FULLTEXT KEY `surname_2` (`surname`),
  FULLTEXT KEY `patronymic_2` (`patronymic`),
  FULLTEXT KEY `name_4` (`name`),
  FULLTEXT KEY `surname_3` (`surname`),
  FULLTEXT KEY `name_5` (`name`),
  FULLTEXT KEY `surname_4` (`surname`),
  FULLTEXT KEY `surname_5` (`surname`),
  FULLTEXT KEY `login_6` (`login`,`name`),
  FULLTEXT KEY `login_7` (`login`,`name`),
  FULLTEXT KEY `login_8` (`login`,`name`),
  FULLTEXT KEY `surname_6` (`surname`,`name`),
  FULLTEXT KEY `surname_7` (`surname`,`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`name`, `surname`, `patronymic`, `login`, `pass`, `type`, `birthday`, `other`) VALUES
('Root', '', '', 'admin', 'cdd3f50c32a5fd62a9d1ebf8336899ed', 'Admin', '00-00-00', 'Administrator'),
('Сулейманов', 'Исмаил', 'Изет оглы', 'suleimanovismail', 'bba2efb42b6ddaf7fcb985d59e6ed202', 'PhysDep', '2014-03-17', ''),
('Маркин', 'Артём', '', 'artemmarkin', '21941195ab347c563b933347d8af231f', 'PhysDep', '', ''),
('Яковлев', 'Денис', '', 'denisyakovlev', '21941195ab347c563b933347d8af231f', 'PhysDep', '', ''),
('Цапик', 'Дмитрий', 'Константинович', 'dmitrytsapik', '21941195ab347c563b933347d8af231f', 'PhysDep', '1994-10-11', ''),
('Федосов', 'Эрнест', '', 'ernestfedosov', '21941195ab347c563b933347d8af231f', 'PhysDep', '', ''),
('Асмолов', 'Александр', 'Александрович', 'alexasmolov', '87601351dc9655cb62817ca6fb7b2ec2', 'PhysDep', '2014-03-04', '????'),
('Лященков', 'Роман', '', 'romanlyashenkov', NULL, 'PhysDep', NULL, NULL),
('Ефременко', 'Вадим', '', 'vadimefremenko', '21941195ab347c563b933347d8af231f', 'PhysDep', '', ''),
('Паненко', 'Валерия', '', 'valeriapanenko', '21941195ab347c563b933347d8af231f', 'PhysDep', '', ''),
('Гурченко', 'Владимир', '', 'vladimirgurchenko', '21941195ab347c563b933347d8af231f', 'PhysDep', '', ''),
('Супрун', 'Владислав', 'null', 'vladsuprun', NULL, 'PhysDep', '1996-01-01', ''),
('Тищенко', 'Владислав', '', 'vladtishenko', '21941195ab347c563b933347d8af231f', 'PhysDep', '', ''),
('Иванов', 'Иван', 'Иванович', 'ivanovii', '9db9ed60d0d8270fd0c98c4f84b245aa', 'Pupils', '2014-03-03', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
