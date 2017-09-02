<?php
// Fill up array with names
$a[]="패션";
$a[]="뷰티";
$a[]="패션 뷰티";
$a[]="의류";
$a[]="가전 디지털";
$a[]="컴퓨터";
$a[]="주변기기";
$a[]="카메라";
$a[]="생활 홈";
$a[]="주방";
$a[]="욕실";
$a[]="가구";
$a[]="기타";
$a[]="패딩";
$a[]="식탁";
$a[]="쇼파";
$a[]="트리";
$a[]="모니터";
$a[]="램";
$a[]="코트";
$a[]="청바지";
$a[]="공유기";
$a[]="전자레인지";
$a[]="아이패드";
$a[]="문화상품권";


// get the q parameter from URL
$q=$_REQUEST["q"]; $hint="";

// lookup all hints from array if $q is different from "" 
if ($q !== "")
  { $q=strtolower($q); $len=strlen($q);
    foreach($a as $name)
    { if (stristr($q, substr($name,0,$len)))
      { if ($hint==="")
        { $hint="<a href=content.php?search=$name><font size=4 color=red><b>".$name."</b></font></a><br/>"; }
        else
        { $hint .= "<a href=content.php?search=$name><font size=3 color=#FF5A5A><b>$name</b></font></a><br/>"; }
      }
    }
  }

// Output "no suggestion" if no hint were found
// or output the correct values 
echo $hint==="" ? "<font size=4 color=#FFDC7E>No Suggestion</font>" : $hint;
?>