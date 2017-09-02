<!DOCTYPE html>
<?php session_start();//세션 선언

if(isset($_GET['error'])&&$_GET['error']==1){//로그인권한이 필요할때
	$_GET[error]="null";
	echo "<script> alert('로그인 후 이용하세요.')</script>";
}

if (isset($_POST['write'])) {////글쓰기 클릭
	header("Location:write.php");
}


?>
<html>
<head>
 <style type="text/css">
table{
	background-repeat:no-repeat;  
	background-size:100%;
	background-size:cover;
	background-size:contain;
	background-position:50% 50%;
}
p.soldout{
	TEXT-DECORATION: none
	text-decoration:none;
	text-align:center;
	color:red;
	font-size:400%;
}
p.noimage{
	TEXT-DECORATION: none
	text-decoration:none;
	text-align:center;
	color:lightgray;
	font-size:400%;
}
p.status{
	font-size:15px;
	color:dodgerblue;
}

a.item{
    COLOR: black;
    TEXT-DECORATION: none
}a.item:hover{
	color:gray;
}

a.sort{
	font-size:17px;
	color:#5D5D5D;
	text-decoration:none;
}a.sort:hover{
	color:white;
	background:black}
</style>

</head>
<body>







<?php
$total=0;//총 게시물 수
$view=9;//한 페이지당 보여줄 게시물 수 
$link;//전체 페이지 수 ceil(($total/$view)+0.5);
$page;//현재 머물고 있는 페이지
$category=0; //현재 카테고리
$con= mysqli_connect('localhost','root','123123','pjdb'); //DB연결

/*현재 페이지*/
if(isset($_GET['page']) && $_GET['page'] !=""){
		$page = $_GET['page'];
}else if(isset($_GET['page']) && $_GET['page'] !=""){
		$page = $_GET['page'];
}else{
	$page=1;	
}





//전체 0
//패션뷰티 12
//의류 1
//뷰티 2
//가전디지털 34
//컴퓨터/주변기기 3
//카메라 4
//생활 홈 56
//주방/욕실 5
//가구 6
//기타 7
if(isset($_GET['category'])){
	$category = $_GET['category'];
}else{
	$category = 0;
}

$query = "SELECT * FROM writes";
echo "<p class='status'>";
if($category==0){
$query;	
echo "전체";
}else if($category==12){
$query = $query." WHERE category='의류' OR category='뷰티'";
echo "전체 > 패션·뷰티";
}else if($category==1){
$query = $query." WHERE category='의류'";	
echo "전체 > 패션·뷰티 > 의류";
}else if($category==2){
$query = $query." WHERE category='뷰티'";
echo "전체 > 패션·뷰티 > 뷰티";
}else if($category==34){
$query = $query." WHERE category='컴퓨터/주변기기' OR category='카메라'";	
echo "전체 > 가전·디지털";
}else if($category==3){
$query = $query." WHERE category='컴퓨터/주변기기'";
echo "전체 > 가전·디지털 > 컴퓨터/주변기기";
}else if($category==4){
$query = $query." WHERE category='카메라'";
echo "전체 > 가전·디지털 > 카메라";
}else if($category==56){
$query = $query." WHERE category='주방/욕실' OR category='가구'";
echo "전체 > 생활 홈";
}else if($category==5){
$query = $query." WHERE category='주방/욕실'";
echo "전체 > 생활 홈 > 주방/욕실";
}else if($category==6){
$query = $query." WHERE category='가구'";
echo "전체 > 생활 홈 > 가구";
}else if($category==7){
$query = $query." WHERE category='기타'";
echo "전체 > 기타";
}
echo "</p>";
/*검색기능*/
if(isset($_SESSION['search']) != ""){
	$query = $query." WHERE subject LIKE '%$_SESSION[search]%'";
	unset($_SESSION['search']);
}

/*총 게시물 수 계산*/
$result = mysqli_query($con,$query);
while($row = mysqli_fetch_array($result)){
	$total++;
}
/*전체 페이지 수 계산*/
$link=ceil(($total/$view)+0.5);

/*next 클릭시*/
if(isset($_GET['next']) && $_GET['next'] !="" ){
	$page=$_GET['next'];
}

/*pre 클릭시*/
if(isset($_GET['pre']) && $_GET['pre'] !="" ){

	if($_GET['pre'] <= 0){
	$_GET['pre']=1;
	}
	$page=$_GET['pre'];
}

/*페이지 함수 호출*/
$pagarray = get_page($total,$view,$link,$page);

$check1 ="　";
$check2 ="　";
$check3 ="　";
$checkimgsrc = "<img src=img/check.jpg width='16' height='16'>";

/*게시물 출력*/
if (isset($_GET['sort'])) {
	if($_GET['sort'] == 0){
		$sort = $_GET['sort'];
		$query = $query." ORDER BY outoID DESC";//정렬방식
		$check1 = $checkimgsrc;//체크이미지
	}else if($_GET['sort'] == 1){
		$sort = $_GET['sort'];
		$query = $query." ORDER BY price ASC";
		$check2 = $checkimgsrc;
	}else if($_GET['sort'] == 2){
		$sort = $_GET['sort'];
		$query = $query." ORDER BY price DESC";
		$check3 = $checkimgsrc;
	}
}else{
	$sort = 0;
	$query = $query." ORDER BY outoID DESC";
	$check1 = $checkimgsrc;
}

$result = mysqli_query($con,$query);


/*정렬방식*/
echo "<p align=right>";
echo "|<a class='sort' href=main.php?category=$category&page=$page&sort=0>".$check1."최신순　</a>|";
echo "<a class='sort' href=main.php?category=$category&page=$page&sort=1>".$check2."낮은가격순　</a>|";
echo "<a class='sort' href=main.php?category=$category&page=$page&sort=2>".$check3."높은가격순　</a>|　　<hr/>";
echo "</p>";




	$tr=0;
	$item=0;
	echo "<center>";
echo "<table border=1> ";
	while($row = mysqli_fetch_array($result)){
		if($item >= (($page*9)-9)){//현재 페이지 게시물부터 출력 조건
			if($tr==0 ||$tr==3 ||$tr==6){//3x3 테이블형태로 게시물 출력
				echo "<tr bgcolor=white>";
			}
			echo "<td width='300' height='400'>";
			/*=============================*/
			echo "<a class='item' href='board.php?page=$page&category=$category&outoid=".$row['outoID']."'>";
			
			if($row['data'] != null){
				echo "<table width='300' height='300' background='data:$row/jpeg;base64," . base64_encode($row['data']) . "'>";
				
			}else{
				echo "<table width='300' height='300'>";	
				
			}
			
			echo "<tr><td>";
			if($row['soldout'] == 1){
				echo "<p class=soldout><b>Sold Out</b></p>";
			}else if($row['soldout'] != 1 && $row['data'] == null){
				echo "<p class=noimage>No Image</p>";
			}
			echo "";
			echo "</td></tr>";
			echo "</table>";

			echo "<table  width='300' height='100'>";
			echo "<tr><td><hr/>";
			echo "<font size='2' color='gray'>[".$row['category']."]</font>";
			echo "</td></tr>";
			echo "<tr><td height='50'>";
			echo "<div><font size='3'><b>[".$row['deal']."]</b></font>
			<font size='4'><b>". $row['subject'] ."</b></font></div>";
			echo "</td></tr>";
			echo "<tr><td>";
			echo "<div><font size='2' color='green'>플리마켓가　</font><font size='4'><b>". $row['price'] ."</b></font> 원</div>";
			echo "<div align='right'><font size='2' color='deepskyblue'>".$row['id']."</font></a></div>";
			echo "</td></tr>";
			echo "</a>";
			echo "</td></tr>";
			echo "</table>";

			/*=============================*/
			echo "</a>";
			echo "</td>";
			if($tr==2 ||$tr==5 ||$tr==8){
				echo "</tr>";
			}
			$tr++;
		}
		$item++;
		if($item == $page*9){//전부 게시물을 출력했을경우 반복문 빠져나감
			break;
		}
	}
echo "</table>";
echo "</center>";
?>

<?php 
echo "<hr/><br/><center>";
echo "<form method='post' action='".$_SERVER['PHP_SELF']."'>";
echo "<a class='item' href=main.php?category=$category&page=$i&pagearray=$pagarray[prev]&sort=$sort> [◀이전]　</a>";
for($i=$pagarray[srt]; $i<=$pagarray[end]; $i++) {
	
	if($page==$i){
			echo "<a class='item' href=main.php?category=$category&page=$i&sort=$sort><b> [ ".$i." ] </b></a>";
	}else{
		echo "<a class='item' href=main.php?category=$category&page=$i&sort=$sort> [ ".$i." ] </a>";
	}
	
}
echo "<a class='item' href=main.php?category=$category&page=$i&pagearray=$pagarray[next]&sort=$sort>　[다음▶] </a>";
echo "</form>";
echo "<br/><hr/>";
echo "</center>";
echo "<form method=post action=".$_SERVER[PHP_SELF].">
<input type=image name=write value=글쓰기 src=img/write.jpg width=230 height=90>
</form><hr/>";
?>
<?php
function get_page($total,$view,$link,$page) {
  $p[total] = ceil($total / $view);
  $p[srt] = floor(($page -1) / $link) * $link +1;
  $p[end] = ($p[srt] + $link -1 > $p[total]) ? $p[total] : $p[srt] + $link -1;
  $p[prev] = ($page < $link) ? $p[srt] : $p[srt] -1;
  $p[next] = ($p[end] +1 > $p[total]) ? $p[end] : $p[end] +1;
  return $p;
}
?>

<?php mysqli_close($con);//DB연결 해제?>

</body>
<html>
