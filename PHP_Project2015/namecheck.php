<?php
$q = $_GET['q'];//전달받은 인풋값

$con = mysqli_connect('localhost','root','123123','pjdb');//DB연결

mysqli_select_db($con,"ajax_demo");

$query = "SELECT id FROM users WHERE id='$q'";//이름 쿼리문

$result = mysqli_query($con,$query);

if($q !=""){
	if(!preg_match("/^[a-zA-Z-0-9]*$/" , $q)){//ID형식 검사 실패
		echo "<font size=2 color=red>잘못된 ID형식입니다.</font>";
	}else{
		if (mysqli_num_rows($result) > 0) {//중복일떄
			echo "<font size=2 color=red>중복된 ID입니다.</font>";
		}else{//사용가능
			echo "<font size=2 color=#1DDB16>ID 사용가능</font>";
		}
	}
}



mysqli_close($con);
?>