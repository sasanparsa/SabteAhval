

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sabteahval`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAmme_AmooID` (IN `iid` BIGINT, IN `jens` BIT)  BEGIN
	DROP table IF EXISTS tbl ;
    DROP table IF EXISTS m ;
    DROP table IF EXISTS f ;
    DROP table IF EXISTS relate ;
	CREATE TABLE tbl (
		id int
	);
    CREATE TABLE f
    (
        id int
    );
    CREATE TABLE m
    (
        id int
    );
        CREATE TABLE relate
    (
        id int
    );
insert into tbl (id)values(iid);
wloop:while(1=1) do
insert into relate select id from users where (fatherid in (select fatherid from users where id in (select fatherid from users where id in (select id from tbl))) or motherid in (select motherid from users where id in (select fatherid from users where id in (select id from tbl)))) and id not in (select id from relate) and jensiat = jens;
insert into m select motherid from users where id in (select id from tbl)  and motherid 

not in (select id from tbl);
insert into f select fatherid from users where id in (select id from tbl)  and fatherid not in 

(select id from tbl);
if((select count(*) from m) = 0 and (select count(*) from f) = 0)
then
LEAVE wloop;
end if;
insert into tbl select id from m;
insert into tbl select id from f;
delete from m;
delete from f;
end while;
select id from relate where id not in(select iid as id);
DROP TABLE tbl;
DROP TABLE m;
DROP TABLE f;
DROP TABLE relate;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getChildDetail` (IN `iid` BIGINT)  BEGIN
	DROP table IF EXISTS tbl ;
    DROP table IF EXISTS m ;
	CREATE TABLE tbl (
		id int
	);
    CREATE TABLE m
    (
        id int
    );
insert into tbl (id)values(iid);
wloop:while(1=1) do
insert into m select id from users where (fatherid in (select id from tbl)  or motherid in (select id from tbl)) and id not in (select id from tbl);
if((select count(*) from m) = 0)
then
LEAVE wloop;
end if;
insert into tbl select id from m;
delete from m;
end while;
select * from users where id in(select id from tbl);
DROP TABLE tbl;
DROP TABLE m;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getChildID` (IN `iid` BIGINT, IN `jens` BIT)  BEGIN
	DROP table IF EXISTS tbl ;
    DROP table IF EXISTS m ;
	CREATE TABLE tbl (
		id int
	);
    CREATE TABLE m
    (
        id int
    );
insert into tbl (id)values(iid);
wloop:while(1=1) do
insert into m select id from users where (fatherid in (select id from tbl)  or motherid in (select id from tbl)) and id not in (select id from tbl);
if((select count(*) from m) = 0)
then
LEAVE wloop;
end if;
insert into tbl select id from m;
delete from m;
end while;
select id from users where id in(select id from tbl) and jensiat = jens
and id not in(select iid as id);
DROP TABLE tbl;
DROP TABLE m;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getDaei_KhaleID` (IN `iid` BIGINT, IN `jens` BIT)  BEGIN
	DROP table IF EXISTS tbl ;
    DROP table IF EXISTS m ;
    DROP table IF EXISTS f ;
    DROP table IF EXISTS relate ;
	CREATE TABLE tbl (
		id int
	);
    CREATE TABLE f
    (
        id int
    );
    CREATE TABLE m
    (
        id int
    );
        CREATE TABLE relate
    (
        id int
    );
insert into tbl (id)values(iid);
wloop:while(1=1) do
insert into relate select id from users where (fatherid in (select fatherid from users where id in (select motherid from users where id in (select id from tbl))) or motherid in (select motherid from users where id in (select motherid from users where id in (select id from tbl)))) and id not in (select id from relate) and jensiat = jens;

insert into m select motherid from users where id in (select id from tbl)  and motherid not in (select id from tbl);
insert into f select fatherid from users where id in (select id from tbl)  and fatherid not in (select id from tbl);
if((select count(*) from m) = 0 and (select count(*) from f) = 0)
then
LEAVE wloop;
end if;
insert into tbl select id from m;
insert into tbl select id from f;
delete from m;
delete from f;
end while;
select id from relate where id not in(select iid as id);
DROP TABLE tbl;
DROP TABLE m;
DROP TABLE f;
DROP TABLE relate;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getNavadeID` (IN `iid` BIGINT, IN `nave` BIT, IN `bache` BIT)  BEGIN
	DROP table IF EXISTS tbl ;
    DROP table IF EXISTS m ;
    DROP table IF EXISTS relate;
	CREATE TABLE tbl (
		id int
	);
    CREATE TABLE m
    (
        id int
    );
     CREATE TABLE relate
    (
        id int
    );
insert into tbl (id)values(iid);
wloop:while(1=1) do
insert into relate select id from users where (fatherid in (select id from tbl)  or motherid in (select id from tbl)) and id not in (select id from relate) and Jensiat =nave;

insert into m select id from users where (fatherid in (select id from tbl)  or motherid in (select id from tbl)) and id not in (select id from tbl) and Jensiat =bache;

if((select count(*) from m) = 0)
then
LEAVE wloop;
end if;
insert into tbl select id from m;
delete from m;
end while;
select id from relate where id not in(select iid as id);
DROP TABLE tbl;
DROP TABLE m;
DROP TABLE relate;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getParentsDetail` (IN `iid` BIGINT)  BEGIN
	DROP table IF EXISTS tbl ;
    DROP table IF EXISTS m ;
    DROP table IF EXISTS f ;
	CREATE TABLE tbl (
		id int
	);
    CREATE TABLE f
    (
        id int
    );
    CREATE TABLE m
    (
        id int
    );
insert into tbl (id)values(iid);
wloop:while(1=1) do
insert into m select motherid from users where id in (select id from tbl)  and motherid 

not in (select id from tbl);
insert into f select fatherid from users where id in (select id from tbl)  and fatherid not in 

(select id from tbl);
if((select count(*) from m) = 0 and (select count(*) from f) = 0)
then
LEAVE wloop;
end if;
insert into tbl select id from m;
insert into tbl select id from f;
delete from m;
delete from f;
end while;
select * from users where id in(select id from tbl);
DROP TABLE tbl;
DROP TABLE m;
DROP TABLE f;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getParentsID` (IN `iid` BIGINT, IN `jens` BIT)  BEGIN
	DROP table IF EXISTS tbl ;
    DROP table IF EXISTS m ;
    DROP table IF EXISTS f ;
	CREATE TABLE tbl (
		id int
	);
    CREATE TABLE f
    (
        id int
    );
    CREATE TABLE m
    (
        id int
    );
insert into tbl (id)values(iid);
wloop:while(1=1) do
insert into m select motherid from users where id in (select id from tbl)  and motherid 

not in (select id from tbl);
insert into f select fatherid from users where id in (select id from tbl)  and fatherid not in 

(select id from tbl);
if((select count(*) from m) = 0 and (select count(*) from f) = 0)
then
LEAVE wloop;
end if;
insert into tbl select id from m;
insert into tbl select id from f;
delete from m;
delete from f;
end while;
select id from users where id in(select id from tbl) and jensiat = jens and id not in(select iid as id);
DROP TABLE tbl;
DROP TABLE m;
DROP TABLE f;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `marryinfo`
--

CREATE TABLE `marryinfo` (
  `id` bigint(20) NOT NULL,
  `manpersonid` bigint(20) DEFAULT NULL,
  `womanpersonid` bigint(20) DEFAULT NULL,
  `marrydate` varchar(10) COLLATE utf8_persian_ci NOT NULL,
  `talaghdate` varchar(10) COLLATE utf8_persian_ci DEFAULT NULL,
  `Employeeid` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `marryinfo`
--

INSERT INTO `marryinfo` (`id`, `manpersonid`, `womanpersonid`, `marrydate`, `talaghdate`, `Employeeid`) VALUES
(1, 1, 3, '1370/01/01', '1309/09/12', 1),
(42, 2, 4, '1390/01/01', NULL, 1),
(43, 5, 6, '1399/01/01', NULL, 1),
(44, 46, 20, '1390/01/01', NULL, 1),
(45, 47, 19, '1390/01/01', NULL, 1),
(46, 16, 48, '1390/01/01', NULL, 1),
(47, 15, 49, '1390/01/01', NULL, 1),
(48, 24, 23, '1390/01/01', NULL, 1),
(49, 22, 21, '1390/01/01', NULL, 1),
(50, 64, 65, '1390/01/01', NULL, 1),
(51, 66, 67, '1390/01/01', NULL, 1),
(52, 68, 69, '1390/01/01', '1350/07/13', 1),
(53, 39, 33, '1390/01/01', NULL, 1),
(54, 11, 29, '1390/01/01', NULL, 1),
(55, 30, 14, '1390/01/01', NULL, 1),
(56, 10, 31, '1390/01/01', NULL, 1),
(57, 38, 45, '1390/01/01', NULL, 1),
(58, 42, 37, '1390/01/01', NULL, 1),
(59, 75, 76, '1390/01/01', NULL, 1),
(60, 71, 70, '1390/01/01', NULL, 1),
(61, 28, 27, '1390/01/01', NULL, 1),
(62, 26, 25, '1390/01/01', NULL, 1),
(63, 87, 9, '1388/08/08', NULL, 1),
(64, 89, 34, '1390/03/04', NULL, 1),
(65, 90, 8, '1392/04/12', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `systemroles`
--

CREATE TABLE `systemroles` (
  `id` bigint(20) NOT NULL,
  `RoleName` varchar(50) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `systemroles`
--

INSERT INTO `systemroles` (`id`, `RoleName`) VALUES
(1, 'کاربر عادی'),
(2, 'کارمند'),
(3, 'ادمین');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `fname` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `lname` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `natCode` varchar(10) COLLATE utf8_persian_ci NOT NULL,
  `motherid` bigint(20) DEFAULT NULL,
  `fatherid` bigint(20) DEFAULT NULL,
  `isAlive` bit(1) NOT NULL,
  `password` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `BirthDate` varchar(10) COLLATE utf8_persian_ci NOT NULL,
  `DeathDate` varchar(10) COLLATE utf8_persian_ci DEFAULT NULL,
  `Sadereh` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `picture` text COLLATE utf8_persian_ci,
  `Roleid` bigint(20) NOT NULL,
  `Jensiat` bit(1) NOT NULL,
  `shomareShenasname` varchar(10) COLLATE utf8_persian_ci NOT NULL,
  `Employeeid` bigint(20) DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `Tel` varchar(15) COLLATE utf8_persian_ci DEFAULT NULL,
  `Address` varchar(500) COLLATE utf8_persian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `natCode`, `motherid`, `fatherid`, `isAlive`, `password`, `BirthDate`, `DeathDate`, `Sadereh`, `picture`, `Roleid`, `Jensiat`, `shomareShenasname`, `Employeeid`, `email`, `Tel`, `Address`) VALUES
(1, 'گل آقا', 'نوروزی', '2080987665', 27, 28, b'0', '1010101010', '1328/03/12', '1355/05/22', 'ساری', '2018121916043279139109103449118.jpg', 3, b'1', '2354245423', 1, 's@s.o', '8978789789', 'ساری تجن'),
(2, 'خلیل', 'کاظمی', '1234567890', 23, 24, b'0', '1010101010', '1327/03/12', '1374/05/22', 'بهشهر', NULL, 2, b'1', '22', 1, 'gmail2@gmail.com', '09111111111', 'یزد'),
(3, 'خورشید', 'صادقی', '1234567899', 25, 26, b'0', '1010101010', '1346/03/12', '1373/05/22', 'نکا', NULL, 1, b'0', '234242342', 1, 'gmail3@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(4, 'حوا', 'واحدی', '3123123456', 21, 22, b'0', '1010101010', '1339/03/12', '1370/05/22', 'بهشهر', NULL, 2, b'0', '432', 1, 'gmail4@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(5, 'مصطفی', 'نوروزی', '1937834892', 3, 1, b'0', '1010101010', '1362/03/12', '1385/05/22', 'نکا', NULL, 1, b'1', '254', 1, 'gmail5@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(6, 'فاطمه', 'کاظمی', '9999431234', 4, 2, b'0', '1010101010', '1351/03/12', '1361/05/22', 'ساری', NULL, 1, b'0', '56463243', 1, 'gmail6@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(7, 'مهدی', 'نوروزی', '3345912343', 6, 5, b'0', '1010101010', '1334/03/12', '1355/05/22', 'بابل', NULL, 1, b'1', '436434224', 1, 'gmail7@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(8, 'سحر', 'نوروزی', '2983478290', 6, 5, b'0', '1010101010', '1333/03/12', '1369/05/22', 'گلوگاه', NULL, 1, b'0', '453323', 1, 'gmail8@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(9, 'سپیده', 'نوروزی', '5463445432', 6, 5, b'0', '101010101010', '1343/03/12', '1383/05/22', 'ساری', NULL, 1, b'0', '423432', 1, 'gmail9@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(10, 'ابراهیم', 'کاظمی', '8289827642', 4, 2, b'0', '1010101010', '1379/03/12', '1392/05/22', 'ساری', NULL, 1, b'1', '44766', 1, 'gmail10@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(11, 'حسین', 'کاظمی', '3234929209', 4, 2, b'0', '1010101010', '1302/03/12', '1323/05/22', 'ساری', NULL, 1, b'1', '8667868688', 1, 'gmail11@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(12, 'رمضان', 'کاظمی', '2308378879', 4, 2, b'0', '1010101010', '1350/03/12', '1362/05/22', 'ساری', NULL, 2, b'1', '5435353534', 1, 'gmail12@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(13, 'غفار', 'کاظمی', '2090893878', 4, 2, b'0', '2090893878', '1369/03/12', '1411/05/22', 'ساری', NULL, 2, b'1', '4534535353', 1, 'gmail13@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(14, 'زری', 'کاظمی', '2983787656', 4, 2, b'0', '2983787656', '1350/03/12', '1378/05/22', 'نکا', NULL, 1, b'0', '4242424234', 1, 'gmail14@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(15, 'یوسف', 'نوروزی', '4234524323', 3, 1, b'0', '4234524323', '1341/03/12', '1389/05/22', 'تهران', NULL, 1, b'1', '424323', 1, 'gmail15@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(16, 'یونس', 'نوروزی', '2983787657', 3, 1, b'0', '2983787657', '1354/03/12', '1367/05/22', 'نکا', NULL, 2, b'1', '543535', 1, 'gmail16@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(17, 'اصغر', 'نوروزی', '9283782374', 3, 1, b'0', '1010101010', '1343/03/12', '1387/05/22', 'ساری', NULL, 1, b'1', '4324242423', 1, 'gmail17@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(18, 'اکبر', 'نوروزی', '9283782375', 3, 1, b'0', '1010101010', '1345/03/12', '1380/05/22', 'ساری', NULL, 1, b'1', '4324242424', 1, 'gmail18@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(19, 'مریم', 'نوروزی', '9283782376', 3, 1, b'0', '1010101010', '1346/03/12', '1373/05/22', 'ساری', NULL, 1, b'0', '4324242425', 1, 'gmail19@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(20, 'مرضیه', 'نوروزی', '9283782377', 3, 1, b'0', '1010101010', '1348/03/12', '1370/05/22', 'ساری', NULL, 1, b'0', '4324242426', 1, 'gmail20@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(21, 'بانو', 'صادقی', '9283782378', 65, 64, b'0', '1010101010', '1349/03/12', '1397/05/22', 'ساری', NULL, 1, b'0', '4324242426', 1, 'gmail21@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(22, 'علی', 'واحدی', '9283782379', NULL, NULL, b'0', '1010101010', '1351/03/12', '1376/05/22', 'ساری', NULL, 1, b'1', '4324242426', 1, 'gmail22@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(23, 'لیلا', 'نوروزی', '9283782380', NULL, NULL, b'0', '1010101010', '1351/03/12', '1351/05/22', 'ساری', NULL, 1, b'0', '4324242426', 1, 'gmail23@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(24, 'حسین', 'کاظمی', '9283782381', 76, 75, b'0', '1010101010', '1353/03/12', '1380/05/22', 'ساری', NULL, 1, b'1', '4324242426', 1, 'gmail24@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(25, 'طاووس', 'توکلی', '9283782382', 67, 66, b'0', '1010101010', '1353/03/12', '1355/05/22', 'ساری', NULL, 1, b'0', '4324242426', 1, 'gmail25@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(26, 'آقا بابا', 'صادقی', '9283782383', NULL, NULL, b'0', '1010101010', '1355/03/12', '1384/05/22', 'ساری', NULL, 1, b'1', '4324242426', 1, 'gmail26@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(27, 'صغری', 'اصغری', '9283782384', NULL, NULL, b'0', '1010101010', '1355/03/12', '1359/05/22', 'ساری', NULL, 1, b'0', '4324242426', 1, 'gmail27@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(28, 'یونس', 'نوروزی', '9283782385', NULL, NULL, b'0', '1010101010', '1357/03/12', '1388/05/22', 'ساری', NULL, 1, b'1', '4324242426', 1, 'gmail28@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(29, 'هنده', 'مختارپور', '9283782386', NULL, NULL, b'0', '1010101010', '1357/03/12', '1363/05/22', 'ساری', NULL, 1, b'0', '4324242426', 1, 'gmail29@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(30, 'خلیل', 'قربانی', '9283782387', NULL, NULL, b'0', '1010101010', '1359/03/12', '1392/05/22', 'ساری', NULL, 1, b'1', '4324242426', 1, 'gmail30@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(31, 'مریم', 'کاظمی', '9283782388', 70, 71, b'0', '1010101010', '1359/03/12', '1367/05/22', 'ساری', NULL, 1, b'0', '4324242426', 1, 'gmail31@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(32, 'عارف', 'کاظمی', '9283782389', 29, 11, b'0', '1010101010', '1361/03/12', '1396/05/22', 'ساری', NULL, 1, b'1', '4324242426', 1, 'gmail32@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(33, 'رقیه', 'کاظمی', '9283782390', 29, 11, b'0', '1010101010', '1361/03/12', '1371/05/22', 'ساری', NULL, 1, b'0', '4324242426', 1, 'gmail33@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(34, 'محبوبه', 'کاظمی', '1098309097', 29, 11, b'0', '1010101010', '1380/03/12', '1411/05/22', 'سمنان', NULL, 1, b'0', '445', 1, NULL, '4234242343', 'GDSFGGSDGDSGDGDDGFD'),
(35, 'نیلوفر', 'قربانی', '9283782392', 14, 30, b'0', '1010101010', '1363/03/12', '1375/05/22', 'ساری', NULL, 1, b'0', '4324242426', 1, 'gmail35@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(36, 'نیما', 'قربانی', '9283782393', 14, 30, b'0', '1010101010', '1365/03/12', '1404/05/22', 'ساری', NULL, 1, b'1', '4324242426', 1, 'gmail36@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(37, 'عادله', 'کاظمی', '9283782394', 31, 10, b'0', '1010101010', '1365/03/12', '1379/05/22', 'ساری', NULL, 1, b'0', '4324242426', 1, 'gmail37@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(38, 'عادل', 'کاظمی', '9283782395', 31, 10, b'0', '1010101010', '1367/03/12', '1408/05/22', 'ساری', NULL, 1, b'1', '4324242426', 1, 'gmail38@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(39, 'علی', 'نوروزی', '9283782396', NULL, NULL, b'0', '1010101010', '1368/03/12', '1385/05/22', 'ساری', NULL, 1, b'1', '4324242426', 1, 'gmail39@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(40, 'ادریس', 'نوروزی', '9283782397', 33, 39, b'0', '1010101010', '1369/03/12', '1412/05/22', 'ساری', NULL, 1, b'1', '4324242426', 1, 'gmail40@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(41, 'امیر محمد', 'نوروزی', '9283782398', 33, 39, b'0', '1010101010', '1370/03/12', '1389/05/22', 'ساری', NULL, 1, b'1', '4324242426', 1, 'gmail41@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(42, 'کمیل', 'اسماعیلی', '9283782399', NULL, NULL, b'0', '1010101010', '1371/03/12', '1416/05/22', 'ساری', NULL, 1, b'1', '4324242426', 1, 'gmail42@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(43, 'صدف', 'اسماعیلی', '9283782400', 37, 42, b'0', '1010101010', '1371/03/12', '1391/05/22', 'ساری', NULL, 1, b'0', '4324242426', 1, 'gmail43@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(44, 'آرتا', 'کاظمی', '9283782401', 45, 38, b'0', '1010101010', '1373/03/12', '1420/05/22', 'ساری', NULL, 1, b'1', '4324242426', 1, 'gmail44@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(45, 'سایان', 'مقدم', '9283782402', NULL, NULL, b'0', '1010101010', '1373/03/12', '1395/05/22', 'ساری', NULL, 1, b'0', '4324242426', 1, 'gmail45@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(46, 'داوود', 'صادقیان', '9283782403', NULL, NULL, b'0', '1010101010', '1375/03/12', '1424/05/22', 'ساری', NULL, 1, b'1', '4324242426', 1, 'gmail46@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(47, 'ابراهیم', 'خرم', '9283782404', NULL, NULL, b'0', '1010101010', '1376/03/12', '1401/05/22', 'ساری', NULL, 1, b'1', '4324242426', 1, 'gmail47@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(48, 'فاطمه', 'صادقی', '9283782405', NULL, NULL, b'0', '1010101010', '1376/03/12', '1376/05/22', 'ساری', NULL, 1, b'0', '4324242426', 1, 'gmail48@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(49, 'لیلا', 'فیروز روز', '9283782406', NULL, NULL, b'0', '1010101010', '1377/03/12', '1403/05/22', 'ساری', NULL, 1, b'0', '4324242426', 1, 'gmail49@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(50, 'انسیه', 'صادقیان', '9283782407', 20, 46, b'0', '1010101010', '1378/03/12', '1380/05/22', 'ساری', NULL, 1, b'0', '4324242426', 1, 'gmail50@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(51, 'ملیحه', 'صادقیان', '9283782408', 20, 46, b'0', '1010101010', '1379/03/12', '1407/05/22', 'ساری', NULL, 1, b'0', '4324242426', 1, 'gmail51@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(52, 'رضا', 'صادقیان', '9283782409', 20, 46, b'0', '1010101010', '1381/03/12', '1386/05/22', 'ساری', NULL, 1, b'1', '4324242426', 1, 'gmail52@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(53, 'حسن', 'خرم', '9283782410', 19, 47, b'0', '1010101010', '1382/03/12', '1413/05/22', 'ساری', NULL, 1, b'1', '4324242426', 1, 'gmail53@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(54, 'حسین', 'خرم', '9283782411', 19, 47, b'0', '1010101010', '1383/03/12', '1390/05/22', 'ساری', NULL, 1, b'1', '4324242426', 1, 'gmail54@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(55, 'زمرد', 'خرم', '9283782412', 19, 47, b'0', '1010101010', '1383/03/12', '1415/05/22', 'ساری', NULL, 1, b'0', '4324242426', 1, 'gmail55@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(56, 'حسن', 'نوروزی', '9283782413', 48, 16, b'0', '1010101010', '1385/03/12', '1394/05/22', 'ساری', NULL, 1, b'1', '4324242426', 1, 'gmail56@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(57, 'حسین', 'نوروزی', '9283782414', 48, 16, b'0', '1010101010', '1386/03/12', '1421/05/22', 'ساری', NULL, 1, b'1', '4324242426', 1, 'gmail57@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(58, 'رضا', 'نوروزی', '9283782415', 48, 16, b'0', '1010101010', '1387/03/12', '1398/05/22', 'ساری', NULL, 1, b'1', '4324242426', 1, 'gmail58@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(59, 'احسان', 'نوروزی', '9283782416', 49, 15, b'0', '1010101010', '1388/03/12', '1425/05/22', 'ساری', NULL, 1, b'1', '4324242426', 1, 'gmail59@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(60, 'نرگس', 'نوروزی', '9283782417', 49, 15, b'0', '1010101010', '1388/03/12', '1400/05/22', 'ساری', NULL, 1, b'0', '4324242426', 1, 'gmail60@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(61, 'رقیه', 'نوروزی', '9283782418', 49, 15, b'0', '1010101010', '1389/03/12', '1427/05/22', 'ساری', NULL, 1, b'0', '4324242426', 1, 'gmail61@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(64, 'محمد', 'صادقی', '9283782419', NULL, NULL, b'0', '1010101010', '1393/03/12', '1410/05/22', 'ساری', NULL, 1, b'1', '4324242426', 1, 'gmail64@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(65, 'مریم', 'توکلی', '9283782420', 69, 68, b'0', '1010101010', '1393/03/12', '1435/05/22', 'ساری', NULL, 1, b'0', '4324242426', 1, 'gmail65@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(66, 'علی', 'توکلی', '9283782421', 69, 68, b'0', '1010101010', '1395/03/12', '1414/05/22', 'ساری', NULL, 1, b'1', '4324242426', 1, 'gmail66@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(67, 'طوبی', 'نظری', '9283782422', NULL, NULL, b'0', '1010101010', '1395/03/12', '1439/05/22', 'ساری', NULL, 1, b'0', '4324242426', 1, 'gmail67@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(68, 'قنبر', 'توکلی', '9283782423', NULL, NULL, b'0', '1010101010', '1397/03/12', '1418/05/22', 'ساری', NULL, 1, b'1', '4324242426', 1, 'gmail68@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(69, 'کبری', 'حسنی', '9283782424', NULL, NULL, b'0', '1010101010', '1397/03/12', '1443/05/22', 'ساری', NULL, 1, b'0', '4324242426', 1, 'gmail69@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(70, 'لیلا', 'مرتضوی', '9283782425', NULL, NULL, b'0', '1010101010', '1398/03/12', '1420/05/22', 'ساری', NULL, 1, b'0', '4324242426', 1, 'gmail70@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(71, 'محمد', 'کاظمی', '9283782426', NULL, 72, b'0', '1010101010', '1300/03/12', '1349/05/22', 'ساری', NULL, 1, b'1', '4324242426', 1, 'gmail71@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(72, 'ذکریا', 'کاظمی', '9283782427', 76, 75, b'0', '1010101010', '1301/03/12', '1326/05/22', 'ساری', NULL, 1, b'1', '4324242426', 1, 'gmail72@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(75, 'صمد', 'کاظمی', '9283782430', NULL, NULL, b'0', '1010101010', '1304/03/12', '1307/05/22', 'ساری', NULL, 1, b'1', '4324242426', 1, 'gmail75@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(76, 'خدیجه', 'رمضانی', '9283782431', NULL, NULL, b'0', '1010101010', '1305/03/12', '1334/05/22', 'ساری', NULL, 1, b'1', '4324242426', 1, 'gmail76@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(77, 'w', 'ww', '9000000001', 27, 28, b'0', '9000000001', '1310/03/12', '1349/05/22', 'ساری', NULL, 1, b'0', '2131', 1, 'gmail77@gmail.com', '09111111111', 'ساری میدان ساعت خیابان انقلاب بعد از استانداری'),
(87, 'میلاد', 'دارابی', '9090808034', NULL, NULL, b'0', '9090808034', '1321/03/12', '1321/05/22', 'ساری', NULL, 1, b'1', '2131', 1, NULL, '09128929989', NULL),
(88, 'رز', 'دارابی', '2020908078', 9, 87, b'0', '2020908078', '1368/03/12', '1384/05/22', 'ساری', NULL, 1, b'0', '2020908078', 1, 'rose.darabi@yahoo.com', NULL, NULL),
(89, 'اسماعیل', 'مختارپور', '2090902080', NULL, NULL, b'0', '2090902080', '1335/03/12', '1365/05/22', 'ساری', '20181217171509152914801001010404.jpg', 1, b'1', '2343', 1, NULL, NULL, NULL),
(90, 'مجتبی', 'آهنچ', '2090394538', NULL, NULL, b'1', '1010101010', '1363/03/23', NULL, 'ساری', NULL, 1, b'1', '5464', 1, 'a.e@g.v', NULL, NULL),
(91, 'کسری', 'مختارپور', '6456464666', 34, 89, b'0', '1010101010', '1380/04/23', '1390/04/23', 'ساری', '201812191711326037244106253592.jpg', 1, b'1', '5', 1, 'kasra.mokh@hotmail.com', '09112345432', 'ساری خیابان معلم بعد از خیابان امام هادی'),
(92, 'آهو', 'صادقی', '2984590345', 65, 64, b'0', '1010101010', '1340/04/02', '1367/04/23', 'نکا', NULL, 1, b'0', '33', 1, NULL, NULL, NULL),
(93, 'مهتاب', 'صادقی', '8745893423', 25, 26, b'0', '1010101010', '1340/02/23', '1380/12/12', 'شهمیرزاد', NULL, 1, b'0', '4', 1, 'a.eeee@gggg.ffff', '89345093456', 'شهمیرزاد');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `marryinfo`
--
ALTER TABLE `marryinfo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`Employeeid`),
  ADD KEY `manperson_fk` (`manpersonid`),
  ADD KEY `womanperson_fk` (`womanpersonid`);

--
-- Indexes for table `systemroles`
--
ALTER TABLE `systemroles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `natCode` (`natCode`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `father_fk` (`fatherid`),
  ADD KEY `mother_fk` (`motherid`),
  ADD KEY `employee_fk` (`Employeeid`),
  ADD KEY `role_fk` (`Roleid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `marryinfo`
--
ALTER TABLE `marryinfo`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `systemroles`
--
ALTER TABLE `systemroles`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `marryinfo`
--
ALTER TABLE `marryinfo`
  ADD CONSTRAINT `employee_id` FOREIGN KEY (`Employeeid`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `manperson_fk` FOREIGN KEY (`manpersonid`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `womanperson_fk` FOREIGN KEY (`womanpersonid`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `employee_fk` FOREIGN KEY (`Employeeid`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `father_fk` FOREIGN KEY (`fatherid`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `mother_fk` FOREIGN KEY (`motherid`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `role_fk` FOREIGN KEY (`Roleid`) REFERENCES `systemroles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
