-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- 主機: 127.0.0.1
-- 產生時間： 2018-11-30 11:33:27
-- 伺服器版本: 10.1.31-MariaDB
-- PHP 版本： 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `nba`
--

-- --------------------------------------------------------

--
-- 資料表結構 `nba_teamname`
--

CREATE TABLE `nba_teamname` (
  `TeamID` int(21) NOT NULL,
  `Team_Name_En` varchar(200) NOT NULL,
  `Team_Name_Ch` varchar(200) NOT NULL,
  `AREA` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `nba_teamname`
--

INSERT INTO `nba_teamname` (`TeamID`, `Team_Name_En`, `Team_Name_Ch`, `AREA`) VALUES
(1610612737, 'ATL', '老鷹', 'east'),
(1610612738, 'BOS', '塞爾提克', 'east'),
(1610612739, 'CLE', '騎士', 'east'),
(1610612740, 'NOP', '水鳥、鵜鶘', 'west'),
(1610612741, 'CHI', '公牛', 'east'),
(1610612742, 'DAL', '小牛、獨行俠', 'west'),
(1610612743, 'DEN', '金塊', 'west'),
(1610612744, 'GSW', '勇士', 'west'),
(1610612745, 'HOU', '火箭', 'west'),
(1610612746, 'LAC', '快艇', 'west'),
(1610612747, 'LAL', '湖人', 'west'),
(1610612748, 'MIA', '熱火', 'east'),
(1610612749, 'MIL', '公鹿', 'east'),
(1610612750, 'MIN', '灰狼', 'west'),
(1610612751, 'BKN', '籃網', 'east'),
(1610612752, 'NYK', '尼克', 'west'),
(1610612753, 'ORL', '魔術', 'east'),
(1610612754, 'IND', '溜馬', 'east'),
(1610612755, 'PHI', '76人', 'east'),
(1610612756, 'PHX', '太陽', 'west'),
(1610612757, 'POR', '拓荒者', 'west'),
(1610612758, 'SAC', '國王', 'west'),
(1610612759, 'SAS', '馬刺', 'west'),
(1610612760, 'OKC', '雷霆', 'west'),
(1610612761, 'TOR', '暴龍', 'east'),
(1610612762, 'UTA', '爵士', 'west'),
(1610612763, 'MEM', '灰熊', 'west'),
(1610612764, 'WAS', '巫師', 'east'),
(1610612765, 'DET', '活塞', 'east'),
(1610612766, 'CHA', '黃蜂', 'east');

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `nba_teamname`
--
ALTER TABLE `nba_teamname`
  ADD PRIMARY KEY (`TeamID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
