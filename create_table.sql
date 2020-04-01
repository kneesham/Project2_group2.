CREATE DATABASE IF NOT EXISTS `project2` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `project2`;

-- SECTION FOR THE 'USERS' TABLE TO BE CREATED AND INSERTED INTO.

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `Id` int(10) NOT NULL,
  `Name` varchar(20) NOT NULL,
  `Num_races` int(3) DEFAULT NULL,
  `City` varchar(30),
  `email` varchar(30),
  `password` varchar(25)
) DEFAULT CHARSET=utf8;


INSERT INTO `users` (`Id`,`Name`,`Num_races`,`City`, `email`, `password`) VALUES
(123456789,'Zach M', 0,'St. Louis','zach@mail.com', 'password'),
(987654321, 'Ted N', 1,'Kansas City','ted@gmail.com', 'password'),
(314596728, 'Yang P', 10,'St. Charles','yang@mail.com', 'password'),
(122356789,'George M', 4,'St. Louis','George@mail.com', 'password'),
(987656351, 'Greg N', 1,'St. Louis','Greg@gmail.com', 'password'),
(345396728, 'Jim P', 10,'St. Louis','Jim@mail.com', 'password'),
(123456793,'Doug M', 3,'St. Peters','Doug@mail.com', 'password'),
(987324321, 'Frederick N', 1,'St. Louis','Frederick@gmail.com', 'password'),
(301016728, 'Sam P', 10,'St. Peters','Sam@mail.com', 'password'),
(123400000,'Kindrid M', 20,'St. Charles','Kindrid@mail.com', 'password'),
(987652324, 'Jacob N', 13,'St. Louis','Jacob@gmail.com', 'password'),
(310033002, 'Dillion P', 12,'St. Louis','Dillion@mail.com', 'password');

-- ************************************************************

-- SECTION FOR THE N-M RELATIONSHIPS 'HAS_FRIENDS' AND 'COMPETES' TABLE TO BE CREATED AND INSERTED INTO.

DROP TABLE IF EXISTS `has_friends`;
CREATE TABLE IF NOT EXISTS `has_friends` (
	`user_id` int(10) NOT NULL,
    `friend_id` int(10) NOT NULL
);

DROP TABLE IF EXISTS `competes`;
CREATE TABLE IF NOT EXISTS `competes` (
	`user_id` int(10) NOT NULL,
    `event_id` int(10) NOT NULL
);
-- ************************************************************

-- SECTION FOR THE 'EVENT' TABLE TO BE CREATED AND INSERTED INTO.

DROP TABLE IF EXISTS `event`;
CREATE TABLE IF NOT EXISTS `event` (
  `Event_id` int(10) NOT NULL,
  `Race_Name` varchar(50) NOT NULL,
  `Race_Location` varchar(20) NOT NULL,
  `Race_Date` date NOT NULL,
  `Race_Type` varchar(20) NOT NULL CHECK (`Race_Type` in ('5K', 'Marathon', 'Half-Marathon')),
  `Distance` numeric(5,2) NOT NULL
)  DEFAULT CHARSET=utf8;

INSERT INTO `event` (`Event_id`,`Race_Name`,`Race_Location`,`Race_Date`,`Race_Type`, `Distance` ) VALUES
(782169051,'Foam_Glow','St. Louis', '2020-08-29','5K','3.1'),
(782169512, 'Go!_St.Louis_Marathon','St. Louis', '2020-05-28','Marathon','26.2'),
(782234513, 'Go!_St.Louis_Half_Marathon','St. Louis', '2020-09-28','Half-Marathon','13.1'),
(782169033,'Foam_Glow','St. Louis', '2020-04-29','5K','3.1'),
(782169500, 'Go!_KansasCity_Marathon','Kansas City', '2020-03-28','Marathon','26.2'),
(782234000, 'Go!_St.Peters_Half_Marathon','St. Peters', '2020-03-28','Half-Marathon','13.1'),
(782160000,'Foam_Glow','St. Louis', '2020-03-29','5K','3.1'),
(782100000, 'Go!_St.Louis_Marathon','St. Louis', '2020-01-28','Marathon','26.2'),
(782234222, 'Go!_St.Louis_Half_Marathon','St. Louis', '2020-08-28','Half-Marathon','13.1');

-- ************************************************************

-- SECTION FOR THE 'EVENT_RESULTS' TABLE TO BE CREATED AND INSERTED INTO.

DROP TABLE IF EXISTS `event_results`;
CREATE TABLE IF NOT EXISTS `event_results` (
  `Result_id` int(10) NOT NULL,
  `Race_Name` varchar(50) NOT NULL,
  `Race_Type` varchar(20) NOT NULL CHECK (`Race_Type` in ('5K', 'Marathon', 'Half-Marathon')),
  `Race_Date` date NOT NULL,
  `Race_Time` numeric(4,2),
  `Finish_Position` int(3)
)  DEFAULT CHARSET=utf8;

-- ************************************************************

-- SECTION FOR THE 'PERSONAL_RECORDS' TABLE TO BE CREATED AND INSERTED INTO.

DROP TABLE IF EXISTS `personal_records`;
CREATE TABLE IF NOT EXISTS `personal_records` (
    -- weak entities don't have primary keys.
  `Distance` numeric(4,2),
  `Time` TIME NOT NULL,
  `Date` DATE NOT NULL
)  DEFAULT CHARSET=utf8;

-- ************************************************************

-- ALTER TABLE STATEMENTS

ALTER TABLE `users` ADD PRIMARY KEY (`Id`);
ALTER TABLE `event` ADD PRIMARY KEY (`Event_id`);
ALTER TABLE `event_results` ADD PRIMARY KEY (`Result_id`);
ALTER TABLE `has_friends` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`Id`);
ALTER TABLE `has_friends` ADD FOREIGN KEY (`friend_id`) REFERENCES `users` (`Id`);
ALTER TABLE `has_friends` ADD PRIMARY KEY (`user_id`, `friend_id`);
ALTER TABLE `competes` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
ALTER TABLE `competes` ADD FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`);
ALTER TABLE `competes` ADD PRIMARY KEY (`user_id`, `event_id`);
