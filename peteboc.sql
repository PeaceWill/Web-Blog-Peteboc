-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 03, 2021 at 01:40 AM
-- Server version: 8.0.21
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `peteboc`
--

-- --------------------------------------------------------

--
-- Table structure for table `about`
--

DROP TABLE IF EXISTS `about`;
CREATE TABLE IF NOT EXISTS `about` (
  `id` tinyint NOT NULL AUTO_INCREMENT,
  `content` varchar(3500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `about`
--

INSERT INTO `about` (`id`, `content`) VALUES
(1, '<p style=\"box-sizing: border-box; -webkit-tap-highlight-color: transparent; margin: 0px 0px 15px; font-size: 20px; line-height: 1.618; color: #3c4858; font-family: Roboto; background-color: #ffffff;\">P&ecirc; t&ecirc; b&oacute;c l&agrave; mạng x&atilde; hội &hellip;.0 (bốn chấm v&agrave; số kh&ocirc;ng) được x&acirc;y dựng tr&ecirc;n hệ thống điện to&aacute;n đ&aacute;m m&acirc;y ảo v&agrave; sắp được c&aacute;c chuy&ecirc;n gia c&ocirc;ng nghệ th&ocirc;ng tin h&agrave;ng đầu thế giới thổi bay về Việt Nam.</p>\n<p style=\"box-sizing: border-box; -webkit-tap-highlight-color: transparent; margin: 0px 0px 15px; font-size: 20px; line-height: 1.618; color: #3c4858; font-family: Roboto; background-color: #ffffff;\">V&igrave; l&agrave; của người Việt, cho người Việt v&agrave; chất lượng qu&aacute; tuyệt vời, P&ecirc; t&ecirc; b&oacute;c đ&atilde; được ưu &aacute;i nhắc đ&iacute;ch danh trong buổi tường tr&igrave;nh th&ocirc;ng qua luật an ninh mạng trước quốc hội vừa qua.</p>\n<p style=\"box-sizing: border-box; -webkit-tap-highlight-color: transparent; margin: 0px 0px 15px; font-size: 20px; line-height: 1.618; color: #3c4858; font-family: Roboto; background-color: #ffffff;\"><iframe style=\"box-sizing: border-box; -webkit-tap-highlight-color: transparent; max-width: 100%;\" src=\"https://www.youtube-nocookie.com/embed/e-oUEZ0FYts?rel=0\" width=\"560\" height=\"315\" frameborder=\"0\" allowfullscreen=\"allowfullscreen\" loading=\"lazy\"></iframe></p>\n<p style=\"box-sizing: border-box; -webkit-tap-highlight-color: transparent; margin: 0px 0px 15px; font-size: 20px; line-height: 1.618; color: #3c4858; font-family: Roboto; background-color: #ffffff;\">Sắp tới, P&ecirc; t&ecirc; b&oacute;c định hướng ph&aacute;t triển th&agrave;nh mạng x&atilde; hội v&agrave; s&acirc;n chơi tự do cho c&aacute;c t&aacute;c giả th&iacute;ch ch&acirc;m biếm c&aacute;c c&aacute;i xấu trong x&atilde; hội v&agrave; cười với nhau</p>');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` smallint NOT NULL AUTO_INCREMENT,
  `post_id` smallint NOT NULL,
  `username` varchar(20) NOT NULL,
  `message` varchar(2000) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `post_id`, `username`, `message`, `datetime`) VALUES
(1, 1, 'dolphin', 'Điện thoại đẹp quá <3', '2021-07-01 16:22:33'),
(2, 1, 'smallfish', 'Lâu quá không gặp ông ...', '2021-07-01 16:23:21'),
(3, 2, 'shark', 'Điện thoại giá nhiêu shop ?', '2021-07-01 19:02:59'),
(9, 7, 'shark', 'ok', '2021-07-02 16:45:10'),
(10, 2, 'shark', 'hohoooo !!!!', '2021-07-02 17:27:19'),
(11, 8, 'shark', '&lt;a href=&quot;www.google.com&quot;&gt;click&lt;/a&gt;', '2021-07-02 23:26:14');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` smallint NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `mode` tinyint NOT NULL,
  `content` varchar(2000) NOT NULL,
  `image` varchar(100) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comments` smallint NOT NULL DEFAULT '0',
  `shares` smallint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `username`, `mode`, `content`, `image`, `datetime`, `comments`, `shares`) VALUES
(2, 'shark', 1, 'iPhone 12 tiếp tục có khả năng chống nước và chống bụi chuẩn IP68, nhưng giờ đây bạn đã có thể ngâm nước ở độ sâu tới 6m trong vòng 30 phút thay vì 1,5m như trước kia. Tha hồ sử dụng mà không còn bất cứ nỗi lo nào về hư hại từ nước.', 'pixel-slide1.jpg', '2021-07-01 10:26:36', 0, 0),
(7, 'smallfish', 1, 'Thời tiết hôm nay đẹp nhỉ anh Cá mập', '162519301060de7a32484e7.jpg', '2021-07-02 09:30:10', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `share`
--

DROP TABLE IF EXISTS `share`;
CREATE TABLE IF NOT EXISTS `share` (
  `id` smallint NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `post_id` smallint NOT NULL,
  `mode` tinyint NOT NULL,
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `level` tinyint(1) DEFAULT '0',
  `state` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `level`, `state`) VALUES
('admin', '7fe65a75760f1e44dcff254d9ab286571f05d9bacf9934582318d8dbef3387c9', 2, 0),
('dinasour', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 0, 0),
('dolphin', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 0, 0),
('Falcon', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 1, 0),
('gaughegom02', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 0, 0),
('shark', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 0, 1),
('smallfish', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 0, 1),
('user123', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

DROP TABLE IF EXISTS `user_info`;
CREATE TABLE IF NOT EXISTS `user_info` (
  `username` varchar(20) NOT NULL,
  `realname` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `gender` tinyint NOT NULL,
  `phone` varchar(13) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `link` varchar(100) DEFAULT NULL,
  `description` varchar(2000) DEFAULT NULL,
  `avatar` varchar(100) NOT NULL DEFAULT 'default.jpg',
  `date_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`username`, `realname`, `email`, `gender`, `phone`, `address`, `link`, `description`, `avatar`, `date_create`) VALUES
('admin', 'Hưng Nguyễn', 'gaughegomth01@gmail.com', 1, '0774447897', 'From UIT', 'admin', 'This is admin account', 'admin.jpg', '2021-06-29 22:33:58'),
('dinasour', 'Khủng long', 'diansour@gmail.com', -1, '', '', 'dinasour', '', 'default.jpg', '2021-07-01 08:52:19'),
('dolphin', 'Cá Heo', 'dolphin@gmail.com', 1, '09343654333', 'From ocean', 'dolphin', 'Ở nhà là cá heo', 'default.jpg', '2021-06-30 00:00:00'),
('Falcon', 'Đại bàng', 'falcon@mail.com', 1, '0321424442', 'From sky', 'Falcon', 'Ai nhanh hơn ta', 'Falcon.jpg', '2021-06-30 23:06:13'),
('gaughegom02', 'Gấu 02', 'gaughegom02@gmail.com', 1, '', '', 'gaughegom02', '', 'default.jpg', '2021-07-01 08:53:46'),
('shark', 'Cá mập', 'shark@gmail.com', 0, '0554664123', 'From ocean', 'shark', 'Ra đường là cá mập &lt;3', 'shark.jpg', '2021-06-30 10:39:44'),
('smallfish', 'Cá con', 'cacon@gmail.com', 1, '032141114', 'From ocean', 'smallfish', 'Khi ở nhà là cá con ^^', 'smallfish.jpg', '2021-06-30 00:00:00'),
('user123', 'User 123', 'testuser123@gmail.com', 1, '', '', 'user123', '', 'default.jpg', '2021-07-03 01:31:02');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
