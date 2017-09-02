<?php
session_start();//세션 선언

if(!isset($_SESSION['login'])){//비 로그인사용자 방지
	header("Location:main.php?error=1");
}
$con= mysqli_connect('localhost','root','123123','pjdb'); //DB연결

$category = $_GET['category'];
$page = $_GET['page'];

$query = "SELECT * FROM users WHERE id='$_SESSION[login]'";
$result = mysqli_query($con,$query);

while($row = mysqli_fetch_array($result)){
	
?>
<html>
<style>
table{font-size:100%;background:lightgray;}
td.top0{
	background:#353535;
	height:80px;
	font-size:35;
	color:white;
}
td.top1{
	background:white;
	height:100px;
	font-size:30;
}
td.key{
	background:#EAEAEA;
	width:10%;
	height:50px;
	text-align:center;
}
td.value{
	background:white;
}
td.info{
	background:white;
	height:50px;
	font-size:25;
}
a.button{
	font-size:25px;
	color:green;
	text-decoration:none;
}a.button:hover{
	color:white;
	background:green
}
a.ipage{
	font-size:30;
	color:#0054FF;
	text-decoration:none;
}a.ipage:hover{
	color:gray;
}
a.wpage{
	font-size:30;
	color:darkgray;
	text-decoration:none;
}a.wpage:hover{
	color:gray;
}
</style>
<body>
<table border=0 width=100%>
<tr>
<td class="top0" colspan=2 >마이페이지</td>
</tr>
<tr>
<td class="top1" colspan=2 ><img src='img/bug3.jpg' width='100' height='100' style='float:right; margin:10px'>
<br>
<a class=ipage href=mypage.php>개인 정보</a> | 
<a class=wpage href=mywritten.php>나의 작성 글</a>

</td>
</tr>

<tr>
<td class=info colspan=2 >필수정보</td>
</tr>
<tr>
<td class="key">I D</td>
<td class="value"><?php echo $row[id];?></td>
</tr>
<tr>
<td class="key">Name</td>
<td class="value"><?php echo $row[name];?></td>
</tr>
<td class="key">E-mail</td>
<td class="value"><?php echo $row[email];?></td>
</tr>


<tr>
<td class=info colspan=2>선택정보</td>
</tr>
<tr>
<td class="key">Gender</td>
<td class="value"><?php echo $row['gender'];?></td>
</tr>
<tr>
<td class="key">P·H</td>
<td class="value"><?php echo $row[hp];?></td>
</tr>
<tr>
<td class="key">Adress</td>
<td class="value"><?php echo $row[adress];?></td>
</tr>
</table>
</body>
</html>

<?php

}//반복문 끝





mysqli_close($con);//DB연결 해제

echo "<a class=button href='main.php?category=$category&page=$page'>[홈]</a>　";
echo "<a class=button href='mypageupdate.php?outoid=$outoid&category=$category&page=$page&id=$id'>[개인정보수정]</a>";

?>