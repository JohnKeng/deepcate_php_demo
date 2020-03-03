<?

$link = mysqli_connect("127.0.0.1","root","myroot","world") or die("Connet Error: " . mysqli_connect_error());
$link->query("SET NAMES utf8"); 
   

/* 範例 db `world` table `deepcate`

CREATE TABLE `world`.`deepcate` ( 

`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
`pid` INT UNSIGNED NOT NULL , 
`path` VARCHAR(300) NOT NULL 
`catename` VARCHAR(30) NOT NULL , 
`cateorder` INT UNSIGNED NOT NULL ) ENGINE = InnoDB;

INSERT INTO `deepcate`(`id`,`pid`,`path`,`catename`,`cateorder`)VALUES
(1,'','全部新聞',0),
(2,'','全部圖片',0),
(3,'1','國內新聞',0),
(4,'1','國際新聞',0),
(5,'1,3','台北新聞',0),
(6,'1,4','日本新聞',0),
(7,'2','美女圖片',0),
(8,'2','風景圖片',0),
(9,'2,7','日韓明星',0),
(10,'2,7,9','韓劇女主',0);


*/