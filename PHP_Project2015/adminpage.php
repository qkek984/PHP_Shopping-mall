<?php
session_start();//세션 선언

if(!isset($_SESSION['adminlogin'])){//비 로그인사용자 방지
	header("Location:login.php");
}
$con= mysqli_connect('localhost','root','123123','pjdb'); //DB연결

/*users수정*/
if(isset($_POST['updatedone'])){
	$query = "UPDATE users SET id='$_POST[uid]',pass='$_POST[upass]',name='$_POST[uname]',email='$_POST[uemail]',gender='$_POST[ugender]',hp='$_POST[uhp]',adress='$_POST[uadress]' WHERE outoid=$_POST[uoutoid]";
	mysqli_query($con,$query);
	echo "<script> alert('변경되었습니다.')</script>";
}

/*users삭제*/
if(isset($_POST['delete'])){
	$query = "DELETE FROM users  WHERE outoid=$_POST[outoid]";//삭제 쿼리
	mysqli_query($con,$query);
	echo "<script> alert('삭제되었습니다.')</script>";
}

$query = "SELECT * FROM users";
/*검색버튼 클릭시*/
if(isset($_POST[btnsearch])){
	$query = "SELECT * FROM users WHERE $_POST[field]='$_POST[search]'";
	//$query = "SELECT * FROM users WHERE $_POST[field] LIKE '%$_POST[search]%'";

	
}

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

?>
<html>
<style>

input[type="submit"] {
    font-size: 1em;
	color:white;
	background-color:black;
}

a.item{
	font-size:15px;
	color:black;
	text-decoration:none;
}a.item:hover{
	color:white;
	background:black
}
a.linkmenu{
	color:white;
	text-decoration:none;
}a.linkmenu:hover{
	color:darkgray;
}
div.header
{
	background-color:black;
	color:green;
	WIDTH: 100%;
	HEIGHT: 80px;
	TEXT-ALIGN: left;
	border-bottom:1px solid black;
}



a.flea{color:white;text-decoration:none;font-size: 3em;font:bold;}
a.flea:hover{color:darkgray;}

table.menu{font-size:100%;background:lightgray;}
td.menu{
	background:black;
	color:white;
	font-size:200%;
	margin:30px 30px;
	text-align:center;
}
td.key{
	background:gray;
	color:white;
	font-size:150%;
	margin:30px 30px;
	text-align:center;
}
td.key2{
	background:black;
	color:white;
	font-size:170%;
	margin:30px 30px;
	text-align:center;
}
td.key3{
	background:lightblue;
	color:darkgray;
	font-size:170%;
	margin:30px 30px;
	text-align:center;
}
#header0
{
	background:black;
    WIDTH: 100%;
    HEIGHT: 15px
	
}
#header0 H1
{
    POSITION: absolute;
    TEXT-ALIGN: right;
	FONT-SIZE: 15px;
    WIDTH: 80%;
    COLOR: white;
}
a.top{color:white;text-decoration:none;text-align:center;font:bold;}
a.top:hover{color:darkgray;}

</style>
<body>


	<div style=" color:black; WIDTH: 100%; HEIGHT: 100%">
	<div id="header0">
<h1>
<?php 

	echo $_SESSION['adminlogin']."님　　";
	echo "<a class=top href=logout.php>로그아웃　　</a>";

?>

</h1>
</div>
	<div class="header">
	
	<a class="flea" href="adminpage.php">　[ Admin ] Flea Market</a>
	</div>
	<div style="background-color:white; margin: 0.5em auto; width:95%;height:auto; border-radius:10px;border:2px solid darkgray;">
	<table class="menu" width="100%" cellpadding="15">
	<tr bgcolor="black">
	<td class="menu" WIDTH=33.3%><a class="linkmenu" href=adminpage.php>Users</a></td>
	<td class="menu" WIDTH=33.3%><a class="linkmenu" href=adminpage2.php>Writes</a></td>
	<td class="menu" WIDTH=33.3%><a class="linkmenu" href=adminpage3.php>Messages</a></td>
	</tr>
	</table>
	
	</div>
	<div style="background-color:white; margin: 0.5em auto; width:90%;height:100%; border-radius:10px;border:2px solid darkgray;">
	<center>
	<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<table>
	<tr>
	<td><select name="field" ailgn=center>
	<option value="">- Field -</option>
	<option value="outoID">outoID</option>
	<option value="id">ID</option>
	<option value="pass">P·W</option>
	<option value="name">Name</option>
	<option value="email">E-mail</option>
	<option value="gender">Gender</option>
	<option value="hp">H·P</option>
	<option value="adress">Adress</option>
	</select></td>
	<td><input type="text" name="search" size="35" style="font-size:13pt; height:30px; width:300px"></td>
	<td><input type="image" name="btnsearch" value="검색" src="img/search.jpg" width="34" height="34" align="center">
	</td>
	</tr>
	</table>
	<div style="width:300px" id="txtHint" ></div>

	</form>
	<table width=90% bgcolor="black">
	<tr>
	<td class="key">outoID</td>
	<td class="key">ID</td>
	<td class="key">P·W</td>
	<td class="key">Name</td>
	<td class="key">E-mail</td>
	<td class="key">Gender</td>
	<td class="key">H·P</td>
	<td class="key">Adress</td>
	<td class="key2" colspan="2">Admin</td>
	
	</tr>
<?php
	$query = $query." ORDER BY outoID DESC";
	$result = mysqli_query($con,$query);
	$item=0;
	while($row = mysqli_fetch_array($result)){
	if($item >= (($mpage*9)-9)){
?>
	
	<tr bgcolor="white">
	<form method='post' action="<?php echo $_SERVER['PHP_SELF'];?>">
	<td style="text-align:center;"><?php echo $row[outoID];?></td>
	<td><?php echo $row[id];?></td>
	<td><?php echo $row[pass];?></td>
	<td><?php echo $row[name];?></td>
	<td><?php echo $row[email];?></td>
	<td style="text-align:center;"><?php echo $row[gender];?></td>
	<td style="text-align:center;"><?php echo $row[hp];?></td>
	<td><?php echo $row[adress];?></td>
	
	<input type="hidden" name="outoid" value="<?php echo $row[outoID];?>">
	<input type="hidden" name="id" value="<?php echo $row[id];?>">
	<input type="hidden" name="pass" value="<?php echo $row[pass];?>">
	<input type="hidden" name="name" value="<?php echo $row[name];?>">
	<input type="hidden" name="email" value="<?php echo $row[email];?>">
	<input type="hidden" name="gender" value="<?php echo $row[gender];?>">
	<input type="hidden" name="hp" value="<?php echo $row[hp];?>">
	<input type="hidden" name="adress" value="<?php echo $row[adress];?>">
	<td bgcolor=lightblue style="text-align:center;"><input type="submit" name="update" value="Update"></td>
	<td bgcolor=red style="text-align:center;"><input type="submit" name="delete" value="Delete"></td>
	</form>
	</tr>

<?php
	
	}
	$item++;
	if($item == $mpage*9){//전부 게시물을 출력했을경우 반복문 빠져나감
		break;
	}

}//반복문 끝
echo "</table><hr/>";

if(isset($_POST['update'])){
	$_POST['update']==null;
?>

	<table width=80% bgcolor="black">
		<tr bgcolor="#D9E5FF">
	<td class="key3">outoID</td>
	<td class="key3">ID</td>
	<td class="key3">P·W</td>
	<td class="key3">Name</td>
	<td class="key3">E-mail</td>
	<td class="key3">Gender</td>
	<td class="key3">H·P</td>
	<td class="key3">Adress</td>
	
	</tr>
	<tr bgcolor="white">
	<form method='post' action="<?php echo $_SERVER['PHP_SELF'];?>">
	<td style="text-align:center;"><?php echo $_POST['outoid']?></td>
	<td><input type=text name=uid value="<?php echo $_POST['id']?>"></td>
	<td><input type=text name=upass value="<?php echo $_POST['pass']?>"></td>
	<td><input type=text name=uname value="<?php echo $_POST['name']?>"></td>
	<td><input type=text name=uemail value="<?php echo $_POST['email']?>"></td>
	<td><input type=text name=ugender value="<?php echo $_POST['gender']?>"></td>
	<td><input type=text name=uhp value="<?php echo $_POST['hp']?>"></td>
	<td><input type=text name=uadress value="<?php echo $_POST['adress']?>"></td>
	<input type=hidden name=uoutoid value="<?php echo $_POST['outoid']?>">
	</tr>
	
	</tr>
	</table>
	<input type=submit name="updatedone" value="Update Done">
	</form>
<?php
}


?>	
	
	</center>
<?php
echo "<hr/><center>";
echo "<form method='post' action='".$_SERVER['PHP_SELF']."'>";
echo "<a class='item' href=adminpage.php?mpagearray=$pagarray[prev]> [◀이전]　</a>";
for($i=$pagarray[srt]; $i<=$pagarray[end]; $i++) {
	
	if($page==$i){
			echo "<a class='item' href=adminpage.php?mpage=$i><b> [ ".$i." ] </b></a>";
	}else{
		echo "<a class='item' href=adminpage.php?mpage=$i> [ ".$i." ] </a>";
	}
	
}
echo "<a class='item' href=adminpage.php?mpage=$i&mpagearray=$pagarray[next]>　[다음▶] </a>";
echo "</form>";
echo "<br/><hr/>";
echo "</center>";
?>
	
	</div>
	
</div>
</body>
</html>