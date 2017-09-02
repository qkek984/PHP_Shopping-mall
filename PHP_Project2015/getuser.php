<?php
$q = $_GET['q'];//intval은문자를 숫자로 변환

$con = mysqli_connect('localhost','root','123123','my_db');
if (!$con)
  {
  die('Could not connect: ' . mysqli_error($con));
  }

//mysqli_select_db($con,"ajax_demo");
$sql="SELECT * FROM users WHERE FirstName = '".$q."'";

$result = mysqli_query($con,$sql);

echo "<table border='1'>
<tr>
<th>Firstname</th>
<th>Lastname</th>
<th>Age</th>
<th>Hometown</th>
<th>Job</th>
</tr>";

while($row = mysqli_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['FirstName'] . "</td>";
  echo "<td>" . $row['LastName'] . "</td>";
  echo "<td>" . $row['Age'] . "</td>";
  echo "<td>" . $row['Hometown'] . "</td>";
  echo "<td>" . $row['Job'] . "</td>";
  echo "</tr>";
  }
echo "</table>";

mysqli_close($con);
?>