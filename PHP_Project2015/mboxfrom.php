<?php
session_start();//세션 선언

if(!isset($_SESSION['login'])){//비 로그인사용자 방지
	header("Location:main.php?error=1");
}

$con = mysqli_connect('localhost','root','123123','pjdb');//DB연결


$mtotal=0;//총 게시물 수
$mview=9;//한 페이지당 보여줄 게시물 수 
$mlink;//전체 페이지 수 ceil(($mtotal/$mview)+0.5);
$mpage;//현재 머물고 있는 페이지


/*현재 페이지*/
if(isset($_GET['mpage']) && $_GET['mpage'] !=""){
		$mpage = $_GET['mpage'];
}else{
	$mpage=1;	
}

/*총 게시물 수 계산*/
$query = "SELECT * FROM messages WHERE mto='$_SESSION[login]'";
$result = mysqli_query($con,$query);
while($row = mysqli_fetch_array($result)){
	$mtotal++;
}
/*전체 페이지 수 계산*/
$mlink=ceil(($mtotal/$mview)+0.5);

/*next 클릭시*/
if(isset($_GET['mnext']) && $_GET['mnext'] !="" ){
	$mpage=$_GET['mnext'];
}

/*pre 클릭시*/
if(isset($_GET['mpre']) && $_GET['mpre'] !="" ){

	if($_GET['mpre'] <= 0){
	$_GET['mpre']=1;
	}
	$mpage=$_GET['mpre'];
}

/*페이지 함수 호출*/
$pagarray = get_page($mtotal,$mview,$mlink,$mpage);

function get_page($mtotal,$mview,$mlink,$mpage) {//함수정의
  $p[total] = ceil($mtotal / $mview);
  $p[srt] = floor(($mpage -1) / $mlink) * $mlink +1;
  $p[end] = ($p[srt] + $mlink -1 > $p[total]) ? $p[total] : $p[srt] + $mlink -1;
  $p[prev] = ($mpage < $mlink) ? $p[srt] : $p[srt] -1;
  $p[next] = ($p[end] +1 > $p[total]) ? $p[end] : $p[end] +1;
  return $p;
}

/*삭제버튼 클릭시*/
if(isset($_POST[btndelete]) && $_POST[btndelete] !=""){
	$query = "SELECT * FROM messages WHERE outoID=$_POST[outoID]";
	$result = mysqli_query($con,$query);
	while($row = mysqli_fetch_array($result)){		
		$tmp = $row[deletenum];
	}

	if($tmp == 0 || $tmp ==1){//새로고침으로인한 삭제버그 방지
		if($tmp+2 == 3){//DB자체삭제
			$query = "DELETE FROM messages WHERE outoID=$_POST[outoID]";//삭제 쿼리
		}else{//삭제 (숨김상태)
			$query = "UPDATE messages SET deletenum = $tmp+2 WHERE outoID=$_POST[outoID]";
		}
	}
	mysqli_query($con,$query);
	header("Location:mboxfrom.php");
}

/*답장버튼 클릭시*/
if(isset($_POST[resend]) && $_POST[resend] !=""){
	echo $_POST[outoID];
	$query = "SELECT * FROM messages WHERE outoID=$_POST[outoID]";
	$result = mysqli_query($con,$query);
	while($row = mysqli_fetch_array($result)){		
		$tmp = $row[mfrom];
	}
	header("Location:msend.php?mto=$tmp");
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
	background:white;
	height:100px;
	font-size:30;
}
td.key{
	background:#EAEAEA;
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
a.item{
	font-size:15px;
	color:black;
	text-decoration:none;
}a.item:hover{
	color:white;
	background:black
}	
a.send{
	font-size:19px;
	color:white;
	text-decoration:none;
	background:green;
}a.send:hover{
	color:white;
	background:darkgreen
}
a.mtohref{
	font-size:24;
	color:darkgray;
	text-decoration:none;
}
a.mtohref:hover{
	color:darkgray;
	background:#000000
}
a.mfromhref{
	font-size:26;
	color:white;
	text-decoration:none;
}
a.mfromhref:hover{
	color:gray;
	background:#000000
}
input[type="submit"] {
    font-size: 1em;
    width: 7%;
	height: 4%;
	background-color:green;
	color:white;
	align:center;
}
</style>
<body>
<table border=0 width=100%>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<tr>
<td class="top0" colspan=5 >
<a class= mfromhref href=mboxfrom.php>받은 메시지함</a>　|　<a class= mtohref href=mbox.php>보낸 메시지함</a>

</td>
</tr>

<tr>
<td class="key" width=5%><b></b></td>
<td class="key" width=10%><b>From</b></td>
<td class="key" width=10%><b>Type</b></td>
<td class="key" width=55%><b>messges</b></td>
<td class="key" width=20%><b>date</b></td>
</tr>

<?php
$query = "SELECT * FROM messages WHERE mto='$_SESSION[login]' ORDER BY outoID DESC";
$result = mysqli_query($con,$query);
echo "<form method=post action=".$_SERVER[PHP_SELF].">";
$item=0;
while($row = mysqli_fetch_array($result)){
		if($item >= (($mpage*9)-9) && ($row[deletenum]==0 || $row[deletenum]==1)){//현재 페이지 게시물부터 출력 조건
			echo "<tr>";
			echo "<td class=value width=5% align=center><input type='radio' name='outoID' value='".$row[outoID]."' /></td>";
			echo "<td class=value width=10%>".$row[mfrom]."</td>";
			echo "<td class=value width=10% align=center>".$row[mode]."</td>";
			echo "<td class=value width=60%>".$row[messages]."</td>";
			echo "<td class=value width=20% align=center>".$row[date]."</td>";
			
			echo "</tr>";
		}
		$item++;
		if($item == $mpage*9){//전부 게시물을 출력했을경우 반복문 빠져나감
			break;
		}
	}
	

?>

</table>

<?php //페이지 이동
echo "<input type='submit' name='btndelete' value='삭제'>";
echo "<input type='submit' name='resend' value='답장'>";

echo "</form>";
echo "<hr/><center>";
echo "<form method='post' action='".$_SERVER['PHP_SELF']."'>";
echo "<a class='item' href=mbox.php?category=$category&mpage=$i&mpagearray=$pagarray[prev]&sort=$sort> [◀이전]　</a>";
for($i=$pagarray[srt]; $i<=$pagarray[end]; $i++) {
	
	if($page==$i){
			echo "<a class='item' href=mbox.php?category=$category&mpage=$i&sort=$sort><b> [ ".$i." ] </b></a>";
	}else{
		echo "<a class='item' href=mbox.php?category=$category&mpage=$i&sort=$sort> [ ".$i." ] </a>";
	}
	
}
echo "<a class='item' href=mbox.php?category=$category&mpage=$i&mpagearray=$pagarray[next]&sort=$sort>　[다음▶] </a>";
echo "</form>";
echo "<br/><hr/>";
echo "</center>";
echo "<a class='send' href='msend.php'>　새 메시지 작성　</a><hr/>";
echo "<img src='img/bug.jpg' width='200' height='200' style='float:right; margin:10px'>";
mysqli_close($con);//DB연결 해제
?>


</body>
</html>
