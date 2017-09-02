<?php
$con = mysqli_connect('localhost','root','123123','pjdb');

/*유저 TABLE생성*/
$query = "CREATE TABLE users
(
outoID int not null auto_increment,
PRIMARY KEY(outoID),
id varchar(40),
pass varchar(40),
name varchar(40),
email varchar(40),
gender varchar(10),
hp varchar(20),
adress varchar(100)
)";
mysqli_query($con,$query);

/*테스트유저추가*/
//$query = "INSERT INTO users (id, pass,name, email) VALUES ('kim','123123','bada','a@a.com')";
//mysqli_query($con,$query);

mysqli_close($con);
echo "CREATE!<br>";
?>

<?php
$con = mysqli_connect('localhost','root','123123','pjdb');

/*관리자 TABLE생성*/
$query = "CREATE TABLE admin 
(
outoID int not null auto_increment,
PRIMARY KEY(outoID),
adminid varchar(40),
adminpass int(20)
)";
mysqli_query($con,$query);

/*관리자 추가*/
$query = "INSERT INTO admin (adminid, adminpass) VALUES ('admin','123123')";
mysqli_query($con,$query);

mysqli_close($con);

echo "CREATE!<br>";
?>

<?php
$con = mysqli_connect('localhost','root','123123','pjdb');

/*메시지 TABLE생성*/
$query = "CREATE TABLE messages
(
outoID int not null auto_increment,
PRIMARY KEY(outoID),
mfrom varchar(40),
mto varchar(40),
messages varchar(100),
mode varchar(11),
date varchar(30),
deletenum int
)";

mysqli_query($con,$query);

mysqli_close($con);

echo "CREATE!<br>";
?>

<?php
$con = mysqli_connect('localhost','root','123123','pjdb');

/*게시글 테이블 생성*/
$query = "CREATE TABLE writes
(
outoID int not null auto_increment,
PRIMARY KEY(outoID),
id varchar(40)  not null,
subject varchar(50) not null,
category varchar(20) not null,
deal varchar(10),
price int(20),
content text not null,
imgname varchar(100),
data MEDIUMBLOB,
soldout int
)";
mysqli_query($con,$query);

mysqli_close($con);

echo "CREATE!<br>";
?>