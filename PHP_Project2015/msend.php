<?php
session_start();//세션 선언

if(!isset($_SESSION['login'])){//비 로그인사용자 방지
	header("Location:main.php?error=1");
}
$con = mysqli_connect('localhost','root','123123','pjdb');

if(isset($_POST['send'])){//보내기버튼 글릭시

	$mfrom = $_SESSION['login'];
	$date = date("Y-m-d　h:i:sa");
	$mto = $_POST['mto'];
	$query = "SELECT id FROM users WHERE id='$mto'";//사용자 존재유무 쿼리문
	$result = mysqli_query($con,$query);//이름 쿼리결과 할당
	if (mysqli_num_rows($result) > 0) {//동일 이용자가 존재하여 등록 불가능할때
		$query = "INSERT INTO messages (mfrom,mto,messages,mode,date) VALUES ('$mfrom','$mto','$_POST[message]','$_POST[mode]','$date')";
		mysqli_query($con,$query);
		mysqli_close($con);//DB연결 해제
		header("Location:mbox.php");	
	}else{
		echo "<script> alert('받는이를 다시 확인해주세요.')</script>";
	}
	
	
}

if(isset($_GET['mto'])){//답장 전달받을 아이디
	$mto = $_GET['mto'];
	$_GET['mto'] = null;
}
?>
<html>
<style>
table{font-size:100%;background:lightgray;}
td.top0{
	background:#000030;
	height:50px;
	color:white;
}
td.top1{
	background:green;
	height:50px;
	color:white;
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
a.mtohref{
	font-size:24;
	color:gray;
	text-decoration:none;
}
a.mtohref:hover{
	color:darkgray;
	background:#000000
}
a.mfromhref{
	font-size:24;
	color:gray;
	text-decoration:none;
}
a.mfromhref:hover{
	color:darkgray;
	background:#000000
}

input[type="submit"] {
    font-size: 1.5em;
    width: 15%;
	height: 110%;
	background-color:green;
	color:white;
	align:center;
}
</style>
<body>
<table border=0 width=100%>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<tr>
<td class="top0" colspan=5 ><a class= mfromhref href=mboxfrom.php>받은 메시지함</a>　|　<a class= mtohref href=mbox.php>보낸 메시지함</a>

</tr>
<tr>
<td class="top1" colspan=2 >　새 메시지 작성</td>
</tr>

<tr>
<td class="key"><b>Type</b></td>
<td class="value"  colspan=2><b>

<select name="mode" style="font-size:11pt; height:30px; width:30%">
						<option value="">(Select)</option>
						<option value="거래">거래메시지</option>
						<option value="일반메시지">일반메시지</option>
				</select>

</b></td>
</tr>

<tr>
<td class="key"><b>To</b></td>
<td class="value"><input type="text" name="mto" value="<?php echo $mto;?>" style="font-size:11pt; height:20px; width:100%"></td>
</tr>

<tr>
<td class="key"><b>내용</b></td>
<td class="value">


<textarea name="message" size="50" style="font-size:11pt; height:400px; width:100%"></textarea>
</td>
</tr>

<tr>
<td class="value" colspan=2 align="center">
<input type="submit" name="send" value="Send"></td>
</tr>
</table>
</form>

<img src='img/bug2.jpg' width='200' height='200' style='float:left; margin:10px'>
</body>
</html>
