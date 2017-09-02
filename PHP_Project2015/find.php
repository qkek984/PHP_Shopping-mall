<!DOCTYPE html>
<?php
session_start();

?>

<?php
/*정보찾기 함수*/
function find($name,$email){
	$con = mysqli_connect('localhost','root','123123','pjdb');//DB연결
	$query = "SELECT * FROM users WHERE name='$name' AND email='$email' ";//쿼리문
    $result = mysqli_query($con,$query);//쿼리결과 할당
	
	if(empty($_POST['name']) ||empty($_POST['email'])){//항목을 전부 채우지 않을 경우
		echo "<script> alert('Please enter your Name or Email')</script>";
	}else{
		if ( mysqli_num_rows($result) > 0 ) {//쿼리 결과 일치
			while($row = mysqli_fetch_array($result))
				{
					echo "찾으신 ID 와 P·W는<br/><hr/>";
					echo "<b>I D</b> : ".$row['id']."<br/><br/>";
					echo "<b>P·W</b> : ".$row['pass']."<br/><br/>";
					$row['name'];
					$row['email'];
					$row['gender'];
					$row['hp'];
					$row['adress'];
					echo "<a href='login.php'>[ login ] 화면으로 돌아가기</a>";
				}
			
		}else if (!mysqli_num_rows($result) > 0) {//동일 이용자가 존재하여 등록 불가능할때
			echo "<script> alert('Wrong Name or Email !')</script>";
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

<html>
<head>
    <title>  ID / Password 찾기 </title>
	<link href="registration.css" type="text/css" rel="stylesheet" />
</head>
<body>

<div style="background-color:ghostwhite; color:black; WIDTH: 100%; HEIGHT: 100%">
	
	<div class="header">
	<img src="img/bug.jpg" style="width:30px;height:30px;"><a class="flea" href="content.php">Flea Market</a>
	</div>
	<div style="background-color:white; margin: 3em auto; width:600px; border-radius:10px;border:2px solid darkgray;">
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<table border="0" width="600">
<tr>
<td colspan="3" align="center" height="200"> 
<p style="font-size:40px; color:green"><img src="img/bug.jpg" style="width:50px;height:50px;"><b>FleaMarket</b></p>
<b> [ ID / Password 찾기 ]　</b>
<?php
if (isset($_POST['submit'])) {
	//유효성 검사 후 변수 할당
	$name = input($_POST['name']);
	$email = input($_POST['email']);
	
	find($name,$email);//정보찾기 함수 호출
}
?>

 </td>
</td>
</tr>


<tr>
	<td height="150">
	<div class="item"><b>Name　</b></div> <input type="text" name="name" style="font-size:13pt; height:25px; width:300px">
	<br/><br/>
	<div class="item"><b>Email　</b></div><input type="text" name="email" style="font-size:13pt; height:25px; width:300px"> 
	</td>
</tr>
<tr>
	<td align="center" height="50"><input type="submit" name="submit" value=" Find " style=font-size:15pt; background-color:gray; </td>
</tr>

</table>
</form>
	</div>
</div>


</body>
</html>