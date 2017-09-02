<!DOCTYPE html>
<?php session_start();//세션 선언
if(!isset($_SESSION['login'])){//비 로그인사용자 방지
	header("Location:login.php");
}else if($_SESSION['login']!=$_GET['id'] && $_SESSION['login']!=$_POST['id']){//피 권한자 방지
	header("Location:board.php?page=$_GET[page]&category=$_GET[category]&outoid=$_GET[outoid]&error=1");
}

if(isset($_GET[error]) && $_GET[error]==1){//오류날시
	$_GET[error]=NULL;
	echo "<script> alert('입력 항목을 확인하세요.')</script>";	
}
?>
<style>
div.giude{
	 font-weight:bold;
}
</style>
<?php
/*수정 버튼 클릭시*/
if(isset($_POST['submit'])){
	/*제목과 내용이 존재*/
	if(isset($_POST['subject']) && isset($_POST['content']) && $_POST['subject']!="" && $_POST['content']!="" &&
		isset($_POST['category']) && $_POST['category'] !="" && $_POST['price']!="" && $_POST['price']!=""&&
		isset($_POST['deal']) && $_POST['deal']!=""){
		$con= mysqli_connect('localhost','root','123123','pjdb'); //DB연결
		
		$subject = nohtml($_POST['subject']);
		$id = $_SESSION['login'];
		$category = $_POST['category'];
		$deal = $_POST['deal'];
		$price = $_POST['price'];
		$outoid = $_POST['outoid'];
		
		if(isset($_POST['html'])){//html허용
			
			$content = $_POST['content'];
			$query = "UPDATE writes SET subject='$subject',category='$category',deal='$deal',price='$price',content='$content' WHERE outoID='$outoid'";
			mysqli_query($con,$query);
			mysqli_close($con);
			header("Location:main.php");
			
		}else{//html불허
			$content = nohtml($_POST['content']);
			$query = "UPDATE writes SET subject='$subject',category='$category',deal='$deal',price='$price',content='$content' WHERE outoID='$outoid'";
			mysqli_query($con,$query);
			mysqli_close($con);
			header("Location:main.php");
			
		}
		
	}else{/*제목과 내용이 존재하지 않을 때*/
		$outoid = $_POST['outoid'];
		$PREcategory = $_POST['category0'];
		$PREpage = $_POST['page0'];
		//스크립트를 띄우기 위해 에러코드와 함께 보냄.
		header("Location:update.php?page=$PREpage&category=$PREcategory&outoid=$outoid&id=$_SESSION[login]&error=1");
		
	}
}else if(isset($_POST['cencel'])){
	/*취소 버튼 입력시*/
	$outoid = $_POST['outoid'];
	$PREcategory = $_POST['category0'];
	$PREpage = $_POST['page0'];
	header("Location:board.php?page=$PREpage&category=$PREcategory&outoid=$outoid");
}

function nohtml($arg){
	$arg = htmlspecialchars($arg);
	return $arg;
}
?>

<?php

?>

<html>
<body>
<?php



$con= mysqli_connect('localhost','root','123123','pjdb'); //DB연결

$query = "SELECT * FROM writes WHERE outoID='$_GET[outoid]'";
$result = mysqli_query($con,$query);

while($row = mysqli_fetch_array($result)){
	
?>	


<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">

<div class="giude">제목</div>
<div><input type="text" name="subject" size="25" value="<?php echo $row['subject'];?>" style="font-size:13pt; width:50%; height:25px"></div><br/>
<div class="giude">카테고리
<select name="category">
	<option value="">- 카테고리 선택 -</option>
	<option value="의류">의류</option>
	<option value="뷰티">뷰티</option>
	<option value="컴퓨터/주변기기">컴퓨터/주변기기</option>
	<option value="카메라">카메라</option>
	<option value="주방/욕실">주방/욕실</option>
	<option value="가구">가구</option>
	<option value="기타">기타</option>
</select>　/　거래방식
<select name="deal">
	<option value="">- 거래방식 선택 -</option>
	<option value="안전거래">안전거래</option>
	<option value="택배거래">택배거래</option>
	<option value="직거래">직거래</option>
	<option value="기타">기 타</option>
</select>
</div>

<div class="giude">가격
<input type="text" name="price" size="10" value="<?php echo $row['price'];?>">원</div>
<div class="giude">내용　<input type="checkbox" name="html" value="html"> HTML 허용</div>
<div><textarea rows="20%" cols="100%" name="content"><?php echo $row['content'];?></textarea></div>
<div class="giude">이미지업로드</div>
<div><input type="file" name="upfile[]"></div>
<div><input type="hidden" name="id" value="<?php echo $_GET['id'];//id를 post로 전달 ?>"></div>
<div><input type="hidden" name="outoid" value="<?php echo $_GET['outoid'];//outoid를 post로 전달 ?>"></div>
<div><input type="hidden" name="PREcategory" value="<?php echo $_GET['category'];//outoid를 post로 전달 ?>"></div>
<div><input type="hidden" name="PREpage" value="<?php echo $_GET['page'];//outoid를 post로 전달 ?>"></div>
<div>
<center>
<input type="submit" name="submit" value="수정" style="font-size:15pt; color:white;background-color:green;">
<input type="submit" name="cencel" value="취소" style="font-size:15pt; color:white;background-color:gray;">
<img src="img/bug.jpg" width="200" height="200" style="float:right; margin:10px">
</center>
</div>

</form>
<?php
}
mysqli_close($con);//DB연결 해제
?>
</body>
<html>
