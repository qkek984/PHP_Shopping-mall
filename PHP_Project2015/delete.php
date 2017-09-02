<?php session_start();//세션 선언
if(!isset($_SESSION['login'])){//비 로그인사용자 방지
	header("Location:login.php");
}else if($_SESSION['login']!=$_GET['id']){//피 권한자 방지
	header("Location:board.php?page=$_GET[page]&category=$_GET[category]&outoid=$_GET[outoid]&error=1");
}

if($_SESSION['login']==$_GET['id']){
$con= mysqli_connect('localhost','root','123123','pjdb'); //DB연결		
$query = "DELETE FROM writes WHERE outoID=$_GET[outoid]";//삭제 쿼리
mysqli_query($con,$query);
mysqli_close($con);
header("Location:main.php?page=$_GET[page]&category=$_GET[category]&outoid=$_GET[outoid]");
}

?>