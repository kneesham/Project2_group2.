
DROP DATABASE IF EXISTS `project2`; 
-- needed to add this to re-run the sql otherwise you will get an error if the database exists already.
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
INSERT INTO `has_friends` VALUES 
    (987654321, 314596728),
    (987654321, 123456789),
    (314596728, 987654321),
    (314596728, 123456789),
    (123456789, 987654321),
    (123456789, 314596728);

DROP TABLE IF EXISTS `competes`;
CREATE TABLE IF NOT EXISTS `competes` (
	`user_id` int(10) NOT NULL,
    `event_id` int(10) NOT NULL
);

INSERT INTO `competes` VALUES 
	(987654321,782234222 ),
	(987654321,782100000 ),
	(987654321,782169051 ),
   	(314596728,782234222 ),
	(314596728,782100000 ),
	(314596728,782169051 ),
    	(123456789,782234222 ),
	(123456789,782100000 ),
	(123456789,782169051 );
-- ************************************************************

-- SECTION FOR THE 'EVENT' TABLE TO BE CREATED AND INSERTED INTO.

DROP TABLE IF EXISTS `event`;
CREATE TABLE IF NOT EXISTS `event` (
  `Event_id` int(10) NOT NULL,
  `Race_Name` varchar(50) NOT NULL CHECK (`Race_Name` LIKE '_%'), 
    -- makeing sure there is at least a single character
  `Race_Location` varchar(20) NOT NULL,
  `Race_Date` date NOT NULL,
  `Race_Type` varchar(20) NOT NULL CHECK (`Race_Type` in ('5K', 'Marathon', 'Half-Marathon')),
  `Distance` numeric(5,2) NOT NULL
    
)  DEFAULT CHARSET=utf8;

INSERT INTO `event` (`Event_id`,`Race_Name`,`Race_Location`,`Race_Date`,`Race_Type`, `Distance` ) VALUES
(782169051,'Foam_Glow','St. Louis', '2020-08-29','5K', 3.1),
(782169512, 'Go!_St.Louis_Marathon','St. Louis', '2020-05-28','Marathon',26.2),
(782234513, 'Go!_St.Louis_Half_Marathon','St. Louis', '2020-09-28','Half-Marathon',13.1),
(782169033,'Foam_Glow','St. Louis', '2020-04-29','5K', 3.1),
(782169500, 'Go!_KansasCity_Marathon','Kansas City', '2020-03-28','Marathon', 26.2),
(782234000, 'Go!_St.Peters_Half_Marathon','St. Peters', '2020-03-28','Half-Marathon', 13.1),
(782160000,'Foam_Glow','St. Louis', '2020-03-29','5K', 3.1),
(782100000, 'Go!_St.Louis_Marathon','St. Louis', '2020-10-29','Marathon', 26.2),
(782234222, 'Go!_St.Louis_Half_Marathon','St. Louis', '2020-09-29','Half-Marathon', 13.1);

-- ************************************************************

-- SECTION FOR THE 'EVENT_RESULTS' TABLE TO BE CREATED AND INSERTED INTO.

DROP TABLE IF EXISTS `event_results`;
CREATE TABLE IF NOT EXISTS `event_results` (
-- TO DO: add constraint to check the date is in the past.
  `Result_id` int(10) NOT NULL, -- this should be a fk because we can't have an event result for an event that does not exist.
  `Runner_id` int(10) NOT NULL, -- PRIMary key(result_id, runner_id) each pair will be unique because
  `Runner_Time` TIME DEFAULT NULL,
  `Finish_Position` int(3)
)  DEFAULT CHARSET = utf8;

 INSERT INTO `event_results` VALUES 
	(782169051, 987654321, '00:39:22.45', 3),
    (782234222, 987654321, '02:45:20.33', 3),
    (782100000, 987654321, '05:39:27.42', 3),
    (782169051, 314596728, '00:32:02.45', 2),
    (782234222, 314596728, '02:40:21.33', 2),
    (782100000, 314596728, '05:00:22.42', 2),
    (782169051, 123456789, '00:30:02.47', 1),
    (782234222, 123456789, '02:30:20.30', 1),
    (782100000, 123456789, '04:57:22.44', 1);

-- ************************************************************

-- SECTION FOR THE WEAK ENTITY 'PERSONAL_RECORDS' TABLE TO BE CREATED AND INSERTED INTO.

DROP TABLE IF EXISTS `personal_records`;
CREATE TABLE IF NOT EXISTS `personal_records` (
  `user_id` int(10) NOT NULL, -- DONT MAKE UNIQUE.
  `Distance` numeric(4,2) NOT NULL,
  `Time` TIME DEFAULT NULL,   -- BY DEFAULT NULL IF A USER HAS NOT COMPETED IN ANYTHING.
  `Date` DATE DEFAULT NULL    -- BY DEFAULT NULL IF A USER HAS NOT COMPETED IN ANYTHING.
)  DEFAULT CHARSET=utf8;

INSERT INTO `personal_records` VALUES
	(987654321, 3.1, '00:39:22.45', '2020-08-29'),
    (987654321, 13.1, '02:45:20.33', '2020-09-29'),
    (987654321, 26.2, '05:39:27.42', '2020-10-29'),
    (314596728, 3.1, '00:32:02.45', '2020-08-29'),
    (314596728, 13.1, '02:40:21.33', '2020-09-29'),
    (314596728, 26.2, '05:00:22.42', '2020-10-29'),
    (123456789, 3.1, '00:30:02.47', '2020-08-29'),
    (123456789, 13.1, '02:30:20.30', '2020-09-29'),
    (123456789, 26.2, '04:57:22.44', '2020-10-29'),
    (122356789, 3.1, null, null),
    (122356789, 13.1, null, null),
    (122356789, 26.2, null, null),
    (987656351, 3.1, null, null),
    (987656351, 13.1, null, null),
    (987656351, 26.2, null, null),
    (345396728, 3.1, null, null),
    (345396728, 13.1, null, null),
    (345396728, 26.2, null, null),
    (123456793, 3.1, null, null),
    (123456793, 13.1, null, null),
    (123456793, 26.2, null, null),
    (987324321, 3.1, null, null),
    (987324321, 13.1, null, null),
    (987324321, 26.2, null, null),
    (301016728, 3.1, null, null),
    (301016728, 13.1, null, null),
    (301016728, 26.2, null, null),
    (123400000, 3.1, null, null),
    (123400000, 13.1, null, null),
    (123400000, 26.2, null, null),
    (987652324, 3.1, null, null),
    (987652324, 13.1, null, null),
    (987652324, 26.2, null, null),
    (310033002, 3.1, null, null),
    (310033002, 13.1, null, null),
    (310033002, 26.2, null, null);

-- ************************************************************

-- ALTER TABLE STATEMENTS

ALTER TABLE `users` ADD PRIMARY KEY (`Id`);
ALTER TABLE `event` ADD PRIMARY KEY (`Event_id`);
ALTER TABLE `personal_records` 
	ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`Id`) ON DELETE CASCADE;
    
ALTER TABLE `event_results` 
	ADD FOREIGN KEY (`Runner_id`) REFERENCES `users` (`Id`) ON DELETE CASCADE;
ALTER TABLE `event_results` 
	ADD FOREIGN KEY (`Result_id`) REFERENCES `event` (`Event_id`) ON DELETE CASCADE;
ALTER TABLE `event_results`
	ADD PRIMARY KEY (`Result_id`, `Runner_id`);

ALTER TABLE `has_friends` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`Id`);
ALTER TABLE `has_friends` ADD FOREIGN KEY (`friend_id`) REFERENCES `users` (`Id`);
ALTER TABLE `has_friends` ADD PRIMARY KEY (`user_id`, `friend_id`);
ALTER TABLE `competes` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
ALTER TABLE `competes` ADD FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`);
ALTER TABLE `competes` ADD PRIMARY KEY (`user_id`, `event_id`);
