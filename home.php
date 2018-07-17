<?php require_once('Connections/memberConn.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "login.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "teacherLevel";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_query("SET NAMES 'UTF8'");

mysql_select_db($database_memberConn, $memberConn);
$query_Recordset3 = "SELECT * FROM historyclassdata INNER JOIN classdata ON historyclassdata.classId=classdata.classId WHERE historyclassDate=CURDATE()";
$Recordset3 = mysql_query($query_Recordset3, $memberConn) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

if (date('w')==1){
	mysql_select_db($database_memberConn, $memberConn);
$query_Recordset2 = "SELECT classdata.calssName, classdata.classMON, teacherdata.teacherName, classdata.classTime, classdata.classId, classdata.classStart FROM classdata INNER JOIN teacherdata ON classdata.teacherId = teacherdata.teacherId WHERE classMON = 1";
$Recordset2 = mysql_query($query_Recordset2, $memberConn) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
}
else if (date('w')==2){
		mysql_select_db($database_memberConn, $memberConn);
$query_Recordset2 = "SELECT classdata.calssName, classdata.classTUE, teacherdata.teacherName, classdata.classTime, classdata.classId, classdata.classStart FROM classdata INNER JOIN teacherdata ON classdata.teacherId = teacherdata.teacherId WHERE classTUE = 1";
$Recordset2 = mysql_query($query_Recordset2, $memberConn) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
}
else if (date('w')==3){
		mysql_select_db($database_memberConn, $memberConn);
$query_Recordset2 = "SELECT classdata.calssName, classdata.classWED, teacherdata.teacherName, classdata.classTime, classdata.classId, classdata.classStart FROM classdata INNER JOIN teacherdata ON classdata.teacherId = teacherdata.teacherId WHERE classWED = 1";
$Recordset2 = mysql_query($query_Recordset2, $memberConn) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
}
else if (date('w')==4){
		mysql_select_db($database_memberConn, $memberConn);
$query_Recordset2 = "SELECT classdata.calssName, classdata.classTHU, teacherdata.teacherName, classdata.classTime, classdata.classId, classdata.classStart FROM classdata INNER JOIN teacherdata ON classdata.teacherId = teacherdata.teacherId WHERE classTHU = 1";
$Recordset2 = mysql_query($query_Recordset2, $memberConn) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
}
elseif (date('w')==5){
		mysql_select_db($database_memberConn, $memberConn);
$query_Recordset2 = "SELECT classdata.calssName, classdata.classFRI, teacherdata.teacherName, classdata.classTime, classdata.classId, classdata.classStart FROM classdata INNER JOIN teacherdata ON classdata.teacherId = teacherdata.teacherId WHERE classFRI = 1";
$Recordset2 = mysql_query($query_Recordset2, $memberConn) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
}
else if (date('w')==6){
		mysql_select_db($database_memberConn, $memberConn);
$query_Recordset2 = "SELECT classdata.calssName, classdata.classSAT, teacherdata.teacherName, classdata.classTime, classdata.classId, classdata.classStart FROM classdata INNER JOIN teacherdata ON classdata.teacherId = teacherdata.teacherId WHERE classSAT = 1";
$Recordset2 = mysql_query($query_Recordset2, $memberConn) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
}
else if (date('w')==0){
		mysql_select_db($database_memberConn, $memberConn);
$query_Recordset2 = "SELECT classdata.calssName, classdata.classSAT, teacherdata.teacherName, classdata.classTime, classdata.classId, classdata.classStart FROM classdata INNER JOIN teacherdata ON classdata.teacherId = teacherdata.teacherId WHERE classId = 999999";
$Recordset2 = mysql_query($query_Recordset2, $memberConn) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

}

switch(date("l")){
case 'Monday':
$today=2;
break;	
case 'Tuesday':
$today=3;
break;	
case 'Wednsday':
$today=4;
break;	
case 'Thursday':
$today=5;
break;	
case 'Friday':
$today=6;
break;	
case 'Saturday':
$today=7;
break;	
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>首頁</title>
<style type="text/css">
.banner {
	height: 150px;
	width:1250px;
	background-color: #FF6;
	margin-right: auto;
	margin-left: auto;
    font-family: "微軟正黑體 Light";
	font-size: 30px;
	color: #000;
}
.navlist {
	height: 700px;
	width: 250px;
	background-color: #FC3;
	float: left;
	position: absolute;
	left: 17.5%;
	
}
.content {
	background-color: #FFC;
	height: 700px;
	width: 1000px;
	float: right;
	position: absolute;
	left: 30.5%;
	
}
.wrapper {
	height: auto;
	width: 1100px;
	margin-right: auto;
	margin-left: auto;
}
#按鈕 {
	font-size: 18px;
	color: #000;
	height: 30px;
	width: 100px;
	font-family: "微軟正黑體 Light";
	font-style: normal;
	text-transform: none;
	font-weight: bolder;
}
#置中{
	position: absolute;
	right: 60%;
	top: 5%;
	font-family: "微軟正黑體 Light";
	font-size: 25px;
	font-weight: bold;
	color: #000;
    right:0%;
}
.表格 {
	background-color: #000;
}
</style>
</head>
<body>
<div id="wrapper">
  <div class="banner" id="banner">
    <p>現在時間:
      <?php
  date_default_timezone_set('Asia/Taipei');
  echo date('Y,m,j  AH:i l');
  ?>
    </p>
    
    育碩文理補習班
  </div>
  <div class="navlist" id="navlist">
      <div align="center">
    <br>
     <a href="<?php echo $logoutAction ?>"><input type="button" name="登出" id="按鈕" value="登出"></a>
        <p>
          <a href="home.php"><input type="button" name="home" id="按鈕" value="首頁"></a>
        </p>
        <p>
          <a href="showall.php"><input type="button" name="home" id="按鈕" value="雙周總覽"></a>
        </p>
        <p>
          <a href="historyclosed.php"><input type="button" name="home" id="按鈕" value="停課紀錄"></a>
        </p>
        <p>
        <a href="allstudent.php"><input type="button" name="按鈕" id="按鈕" value="出缺席"></a>
        </p>
         <p>
          <a href="search_class.php?classDate=<?php echo $today?>"><input type="button" name="查詢課程" id="按鈕" value="查詢課程"></a>
        </p>
        <p>
          <a href="search_student.php"><input type="button" name="查詢學生" id="按鈕" value="查詢學生"></a>
        </p>
     <p>
          <a href="addclass.php"><input type="button" name="新增課程" id="按鈕" value="新增課程"></a>
        </p>
         <p>
         <a href="addstudent.php"><input type="button" name="新增學生" id="按鈕" value="新增學生"></a>
        </p>
        <p>
         <a href="studentInClass.php"><input type="button" name="學生入班" id="按鈕" value="學生入班"></a>
        </p>
 <p>
 <form action="order.php" method="get">
 <input type="hidden" value="<?php echo date('l') ?>" name="classDate" id="classDate">
         <input type="submit" name="今日訂餐" id="按鈕" value="今日訂餐">
        </form>
        </p>
         <p>
         <a href="historystudent.php"><input type="button" name="缺席統計" id="按鈕" value="缺席統計"></a>
        </p>
                 <p>
         <a href="historyclass.php?searchdate=<?php echo date('Y/m/j') ?>"><input type="button" name="缺席統計" id="按鈕" value="教師統計"></a>
        </p>
        <p>
         <a href="historyorder.php?year=<?php echo date('Y') ?>&amp;month=<?php echo date('m') ?>"><input type="button" name="退訂統計" id="按鈕" value="退訂統計"></a>
        </p>
 <p>
          <a href="addteacher.php"><input type="button" name="新增教師" id="按鈕" value="新增教師"></a>
        </p>
          <p>
          <a href="search_teacher.php"><input type="button" name="查詢教師" id="按鈕" value="查詢教師"></a>
        </p>
    </div>
  </div>
  <div class="content" id="content">
    <div id="置中">今日課程：
  <br><table width="90%" border="1" cellpadding="1" cellspacing="0" bordercolor="#A4BAE0">
                <tr>
                  <td width="200" align="center" valign="middle">課程名稱</td>
                  <td width="200" align="center" valign="middle">上課時間</td>
                  <td width="180" align="center" valign="middle">課程時間(時)</td>
                  <td width="200" align="center" valign="middle">授課教師</td>
                  <td width="100" align="center" valign="middle"></td>
                </tr>
                 <?php do { ?>
                <tr>
                  <td align="center"><?php echo $row_Recordset2['calssName']; ?></td>
                  <td align="center"><?php echo substr($row_Recordset2['classStart'], 0, -3); ?></td>
                  <td align="center"><?php echo $row_Recordset2['classTime']; ?></td>
                  <td align="center"><?php echo $row_Recordset2['teacherName']; ?></td>
                  <td align="center"><a href="<?php echo "rollcall.php?new=".$row_Recordset2['classId'] ?>">點名</a></td>
                 </tr>
                 <?php } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); ?>
              </table>
<br>

已點名：
  <br><table width="90%" border="1" cellpadding="1" cellspacing="0" bordercolor="#A4BAE0">
      <tr>
                  <td width="200" align="center" valign="middle">課程名稱</td>
                  <td width="200" align="center" valign="middle">上課時間</td>
                  <td width="180" align="center" valign="middle">課程時間(時)</td>
                  <td width="200" align="center" valign="middle">授課教師</td>
                </tr>
                
                <?php do { ?>
                  <tr>
                    <td align="center"><?php echo $row_Recordset3['calssName']; ?></td>
                    <td align="center"><?php echo substr($row_Recordset3['classStart'], 0, -3); ?></td>
                    <td align="center"><?php echo $row_Recordset3['classTime']; ?></td>
                    <td align="center"><?php echo $row_Recordset3['teacherName']; ?></td>
                  </tr>
                  <?php } while ($row_Recordset3 = mysql_fetch_assoc($Recordset3)); ?>
                 
              </table>
              <br>

</div>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset3);
mysql_free_result($Recordset2);
?>
