<!DOCTYPE html>
<script type="text/javascript">
/*ID중복검사이벤트*/
function showHint(str)
{
if (str.length==0)
  { 
  document.getElementById("txtHint").innerHTML="";
  document.getElementById("txtHint").style.border="0px solid red";
  return;
  }
var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
	document.getElementById("txtHint").style.border="0px solid black";
    }
  }
xmlhttp.open("GET","namecheck.php?q="+str,true);
xmlhttp.send();
}
</script>
<?php
session_start();



if (isset($_POST['submit'])) {
	//유효성 검사 후 변수 할당
    $id = input($_POST['id']);
    $pass = input($_POST['pass']);
	$name = input($_POST['name']);
	$email = input($_POST['email']);
	$gender = input($_POST['gender']);
	$adress = input($_POST['adress']);
	$hp = input($_POST['hp']);
	
	RegistrationCheck($id,$pass,$name,$email,$gender,$adress,$hp);//등록 가능 여부 체크 함수 호출
}
?>

<?php
/*로그인 가능여부 체크 함수*/
function RegistrationCheck($id,$pass,$name,$email,$gender,$adress,$hp){
	$con = mysqli_connect('localhost','root','123123','pjdb');//DB연결
	$query = "SELECT id FROM users WHERE id='$id'";//이름 쿼리문
    $result = mysqli_query($con,$query);//이름 쿼리결과 할당
	
	if(empty($_POST['id']) || empty($_POST['pass']) ||empty($_POST['email'])){//항목을 전부 채우지 않을 경우
		echo "<script> alert('필수항목을 전부 입력하세요.')</script>";
	}else{
		if(!preg_match("/^[a-zA-Z-0-9]*$/" , $id)){//ID형식 검사 실패
				echo "<script> alert('잘못된 ID 형식입니다.')</script>";
		}else if(!preg_match("/^[a-zA-Z-0-9]+@(([a-zA-Z_\-])+\.)+[a-zA-Z]{2,4}$/" , $email)){//이메일 형식검사 실패
				echo "<script> alert('잘못된 이메일 형식입니다.')</script>";
		}else if ( !mysqli_num_rows($result) > 0 ) {//동일 이용자가 존재하지 않아 등록 가능할때
			$query = "INSERT INTO users (id, pass,name, email, gender, adress, hp) VALUES ('$id','$pass','$name','$email','$gender','$adress','$hp')";
			mysqli_query($con,$query);//이름 쿼리결과 할당
			$_SESSION['login']=$id;//세션에 사용자 이름 할당
            header("Location: content.php?registration=1");//콘텐트 페이지로 이동
		}else if (mysqli_num_rows($result) > 0) {//동일 이용자가 존재하여 등록 불가능할때
			echo "<script> alert('이미 등록된 사용자가 있습니다.')</script>";
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
    <title> Registration Page </title>
	<link href="registration.css" type="text/css" rel="stylesheet" />
</head>
<body>
<div style="background-color:ghostwhite; color:black; WIDTH: 100%; HEIGHT: 100%">
	
	<div class="header">
	<img src="img/bug.jpg" style="width:30px;height:30px;"><a class="flea" href="content.php">Flea Market</a>
	</div>
	<div style="background-color:white; margin: 3em auto; width:600px; border-radius:10px;border:2px solid darkgray;">
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<table border="0" width="600" >
	
<tr>
	<td colspan="3">  <p style="font-size:40px; color:green"><img src="img/bug.jpg" style="width:50px;height:50px;"><b>FleaMarket</b></p>
	<p style="font-size:20px; color:Blue">[ Registration ]</p> <hr/></td>
</tr>
<tr>
	<td align="center" height="200"> <p style="font-size:20px" color="red"><i>필수 입력</i></p> </td>
	<td colspan="2">
	<div class="item"><b>ID : </b></div><input type="text" name="id" onkeyup="showHint(this.value)"> <a id="txtHint"></a>
	<br/><br/>
	<div class="item"><b>Password : </b></div> <input type="password" name="pass" >
	<br/><br/>
	<div class="item"><b>Name : </b></div> <input type="text" name="name" >
	<br/><br/>
	<div class="item"><b>Email : </b></div><input type="text" name="email" > <hr/>
	</td>
</tr>

<tr>
	<td align="center" height="200"> <p style="font-size:20px" color="red"><i>선택 입력</i></p> </td>
	<td colspan="2">
	<div class="item"> Gender </div>
		<label><input type="radio" name="gender" value="male" />Male</label>
		<label><input type="radio" name="gender" value="female" />Female</label>
	<br/><br/>

	<div class="item"><b>Phone Number : </b> </div> <input type="text" name="hp" >
	<br/><br/>
	<div class="item"><b>Adress : </b> </div> <textarea cols="30" name="adress" ></textarea>
	</td>
	</tr>

<tr>
	<td colspan="3" align="center" height="100">
	<hr/><input type="submit" name="submit" value=" Registration " style=font-size:15pt; background-color:gray;>
	</td>
</tr>

</table>
</form>
	</div>
</div>

</body>
</html>