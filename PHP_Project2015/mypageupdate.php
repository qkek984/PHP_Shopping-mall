<!DOCTYPE html>
<?php session_start();//세션 선언
if(!isset($_SESSION['login'])){//비 로그인사용자 방지
	header("Location:main.php?error=1");
}

if (isset($_POST['submit'])) {
	//유효성 검사 후 변수 할당
    $pass = input($_POST['pass']);
	$name = input($_POST['name']);
	$email = input($_POST['email']);
	$gender = input($_POST['gender']);
	$adress = input($_POST['adress']);
	$hp = input($_POST['hp']);
	
	RegistrationCheck($pass,$name,$email,$gender,$adress,$hp);//등록 가능 여부 체크 함수 호출
}
?>

<?php
/*로그인 가능여부 체크 함수*/
function RegistrationCheck($pass,$name,$email,$gender,$adress,$hp){
	$con = mysqli_connect('localhost','root','123123','pjdb');//DB연결
	$query = "SELECT id FROM users WHERE id='$id'";//이름 쿼리문
    $result = mysqli_query($con,$query);//이름 쿼리결과 할당
	
	if( empty($_POST['pass']) ||empty($_POST['email'])||empty($_POST['name'])){//항목을 전부 채우지 않을 경우
		echo "<script> alert('항목을 전부 채우세요.')</script>";
	}else{
		if(!preg_match("/^[a-zA-Z-0-9]+@(([a-zA-Z_\-])+\.)+[a-zA-Z]{2,4}$/" , $email)){//이메일 형식검사 실패
			echo "<script> alert('잘못된 이메일 형식입니다.')</script>";
		}else{
			$query = "UPDATE users SET pass='$pass',name='$name',email='$email',gender='$gender', hp='$hp',adress='$adress' WHERE id='$_SESSION[login]'";
			mysqli_query($con,$query);//이름 쿼리결과 할당
			header("Location:mypage.php");
		}
		
    }
	
	mysqli_close($con);
	
}

/*유효성 검사 함수*/
function input($arg){
	$arg = trim($arg);
	$arg = htmlspecialchars($arg);
	$arg = stripslashes($arg);
	return $arg;
}
?>


<?php
$con= mysqli_connect('localhost','root','123123','pjdb'); //DB연결
$query = "SELECT * FROM users WHERE id='$_SESSION[login]'";
$result = mysqli_query($con,$query);

while($row = mysqli_fetch_array($result)){

?>

<html>
<head>
    <title> my Page </title>
<style>
table{font-size:100%;background:lightgray;}
td.top0{
	background:#353535;
	height:80px;
	font-size:35px;
	color:white;
}
td.top1{
	background:#2F9D27;
	height:100px;
	font-size:30px;
	color:white;
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
	font-size:25px;
}
</style>
</head>
<body>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<table border=0 width=100%>
<tr>
<td class="top0" colspan=2 >마이페이지</td>
</tr>
<tr>
<td class="top1" colspan=2 >개인정보 수정</td>
</tr>

<tr>
<td class=info colspan=2 >필수정보</td>
</tr>
<tr>
<td class="key">I D</td>
<td class="value"><?php echo $row[id];?></td>
</tr>
<tr>
<td class="key">P·W</td>
<td class="value"><input type="password" name="pass" value="<?php echo $row[pass];?>"></td>
</tr>
<tr>
<td class="key">이름</td>
<td class="value"><input type="text" name="name" value="<?php echo $row[name];?>"></td>
</tr>
<td class="key">E-mail</td>
<td class="value"><input type="text" name="email" value="<?php echo $row[email];?>"></td>
</tr>


<tr>
<td class=info colspan=2>선택정보</td>
</tr>
<tr>
<td class="key">Gender</td>
<td class="value"><label><input type="radio" name="gender" value="male" />Male</label>
		<label><input type="radio" name="gender" value="female" />Female</label></td>
</tr>
<tr>
<td class="key">H·P</td>
<td class="value"><input type="text" name="hp" value="<?php echo $row[hp];?>"></td>
</tr>
<tr>
<td class="key">Adress</td>
<td class="value"><textarea cols="70" name="adress" ><?php echo $row[adress];?></textarea></td>
</tr>
<tr>
	<td class="info" colspan="2" align="center"><input type="submit" name="submit" value=" 수정 " style="font-size:18pt; color:white;background-color:green;"> </td>
</tr>
</table>
</form>
<img src='img/bug4.jpg' width='100' height='100' style='float:left; margin:10px'>
</body>
</html>
<?php
}

mysqli_close($con);//DB연결 해제
?>