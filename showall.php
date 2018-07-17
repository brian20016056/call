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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "Counter")) {
  $insertSQL = sprintf("INSERT INTO closeddata (classId, teacherId, closedDate) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['classId'], "int"),
                       GetSQLValueString($_POST['teacherId'], "int"),
                       GetSQLValueString($_POST['closedDate'], "date"));

  mysql_select_db($database_memberConn, $memberConn);
  $Result1 = mysql_query($insertSQL, $memberConn) or die(mysql_error());

  $insertGoTo = "showall.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_GET['closeddataId'])) && ($_GET['closeddataId'] != "") && (isset($_GET['del']))) {
  $deleteSQL = sprintf("DELETE FROM closeddata WHERE closeddataId=%s",
                       GetSQLValueString($_GET['closeddataId'], "int"));

  mysql_select_db($database_memberConn, $memberConn);
  $Result1 = mysql_query($deleteSQL, $memberConn) or die(mysql_error());

  $deleteGoTo = "home.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

mysql_select_db($database_memberConn, $memberConn);
$query_Recordset1 = "SELECT * FROM classdata WHERE classMON = 1 ORDER BY classStart ASC";
$Recordset1 = mysql_query($query_Recordset1, $memberConn) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
$query_Recordset1 = "SELECT * FROM classdata WHERE classMON = 1 ORDER BY classStart ASC";
$Recordset1 = mysql_query($query_Recordset1, $memberConn) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_memberConn, $memberConn);
$query_Recordset2 = "SELECT * FROM classdata WHERE classTUE = 1 ORDER BY classStart ASC";
$Recordset2 = mysql_query($query_Recordset2, $memberConn) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_memberConn, $memberConn);
$query_Recordset3 = "SELECT * FROM classdata WHERE classWED = 1 ORDER BY classStart ASC";
$Recordset3 = mysql_query($query_Recordset3, $memberConn) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

mysql_select_db($database_memberConn, $memberConn);
$query_Recordset4 = "SELECT * FROM classdata WHERE classTHU = 1 ORDER BY classStart ASC";
$Recordset4 = mysql_query($query_Recordset4, $memberConn) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

mysql_select_db($database_memberConn, $memberConn);
$query_Recordset5 = "SELECT * FROM classdata WHERE classFRI = 1 ORDER BY classStart ASC";
$Recordset5 = mysql_query($query_Recordset5, $memberConn) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);

mysql_select_db($database_memberConn, $memberConn);
$query_Recordset6 = "SELECT * FROM classdata WHERE classSAT = 1 ORDER BY classStart ASC";
$Recordset6 = mysql_query($query_Recordset6, $memberConn) or die(mysql_error());
$row_Recordset6 = mysql_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysql_num_rows($Recordset6);

mysql_select_db($database_memberConn, $memberConn);
$query_Recordset7 = "SELECT * FROM closeddata INNER JOIN classData ON closeddata.classId=classData.classId WHERE DATE_SUB(CURDATE(), INTERVAL 14 DAY) <= date(closedDate)";
$Recordset7 = mysql_query($query_Recordset7, $memberConn) or die(mysql_error());
$row_Recordset7 = mysql_fetch_assoc($Recordset7);
$totalRows_Recordset7 = mysql_num_rows($Recordset7);

mysql_query("SET NAMES 'UTF8'");

if (date('w')==1){
	

}
else if (date('w')==2){
		

}
else if (date('w')==3){
		

}
else if (date('w')==4){
		

}
elseif (date('w')==5){
		

}
else if (date('w')==6){
		

}
else if (date('w')==0){
		

}

switch(date("l")){
case 'Monday':
$today=2;
$monday = date('Y-m-d');
$tuesday = date('Y-m-d', strtotime("+1 days"));
$wednsday = date('Y-m-d', strtotime("+2 days"));
$thursday = date('Y-m-d', strtotime("+3 days"));
$friday = date('Y-m-d', strtotime("+4 days"));
$saturday = date('Y-m-d', strtotime("+5 days"));
break;	
case 'Tuesday':
$today=3;
$monday = date('Y-m-d', strtotime("-1 days"));
$tuesday = date('Y-m-d');
$wednsday = date('Y-m-d', strtotime("+1 days"));
$thursday = date('Y-m-d', strtotime("+2 days"));
$friday = date('Y-m-d', strtotime("+3 days"));
$saturday = date('Y-m-d', strtotime("+4 days"));
break;	
case 'Wednsday':
$today=4;
$monday = date('Y-m-d', strtotime("-2 days"));
$tuesday = date('Y-m-d', strtotime("-1 days"));
$wednsday = date('Y-m-d');
$thursday = date('Y-m-d', strtotime("+1 days"));
$friday = date('Y-m-d', strtotime("+2 days"));
$saturday = date('Y-m-d', strtotime("+3 days"));
break;	
case 'Thursday':
$today=5;
$monday = date('Y-m-d', strtotime("-3 days"));
$tuesday = date('Y-m-d', strtotime("-2 days"));
$wednsday = date('Y-m-d', strtotime("-1 days"));
$thursday = date('Y-m-d');
$friday = date('Y-m-d', strtotime("+1 days"));
$saturday = date('Y-m-d', strtotime("+2 days"));
break;	
case 'Friday':
$today=6;
$monday = date('Y-m-d', strtotime("-4 days"));
$tuesday = date('Y-m-d', strtotime("-3 days"));
$wednsday = date('Y-m-d', strtotime("-2 days"));
$thursday = date('Y-m-d', strtotime("-1 days"));
$friday = date('Y-m-d');
$saturday = date('Y-m-d', strtotime("+1 days"));
break;	
case 'Saturday':
$today=7;
$monday = date('Y-m-d', strtotime("-5 days"));
$tuesday = date('Y-m-d', strtotime("-4 days"));
$wednsday = date('Y-m-d', strtotime("-3 days"));
$thursday = date('Y-m-d', strtotime("-2 days"));
$friday = date('Y-m-d', strtotime("-1 days"));
$saturday = date('Y-m-d');
break;	
case 'Sunday':
$today=7;
$monday = date('Y-m-d', strtotime("-6 days"));
$tuesday = date('Y-m-d', strtotime("-5 days"));
$wednsday = date('Y-m-d', strtotime("-4 days"));
$thursday = date('Y-m-d', strtotime("-3 days"));
$friday = date('Y-m-d', strtotime("-2 days"));
$saturday = date('Y-m-d', strtotime("-1 days"));
break;	
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>雙周總覽</title>
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
	font-family: "微軟正黑體 Light";
	font-weight: bold;
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
        <p><a href="allstudent.php">
          <input type="button" name="按鈕" id="按鈕" value="出缺席">
        </a></p>
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
  雙周停課紀錄
    <table width="500" border="1" cellpadding="1" cellspacing="0" bordercolor="#A4BAE0" >
                <tr>
                  <td width="150" align="center" valign="middle">課程名稱</td>
                  <td width="150" align="center" valign="middle">起始時間</td>
                  <td width="150" align="center" valign="middle">停課日期</td>
                  <td width="50" align="center" valign="middle"></td>
                </tr>
                <?php do { ?>
  <tr>
    <td width="150" align="center" valign="middle"><?php echo $row_Recordset7['calssName']; ?></td>
    <td width="150" align="center" valign="middle"><?php echo substr($row_Recordset7['classStart'],0,-3); ?></td>
    <td width="150" align="center" valign="middle"><?php echo $row_Recordset7['closedDate']; ?></td>
    <td width="50" align="center" valign="middle"><a href="showall.php?del=true&amp;closeddataId=<?php echo $row_Recordset7['closeddataId']; ?>">刪除</a></td>
  </tr>
  <?php } while ($row_Recordset7 = mysql_fetch_assoc($Recordset7)); ?>
    </table>
  <br><table width="150" border="1" cellpadding="1" cellspacing="0" bordercolor="#A4BAE0" align="left">
                <tr>
                  <td width="150" align="center" valign="middle">星期一(<?php echo substr($monday,-5); ?>)</td>
                </tr>
                <?php do { ?>
                  <tr>
                    <td align="center"><?php echo substr($row_Recordset1['classStart'],0,-3); ?><br>
					<a href="rollcall.php?new=<?php echo $row_Recordset1['classId']; ?>"><?php echo $row_Recordset1['calssName']; ?></a>
                    <form action="<?php echo $editFormAction; ?>" method="POST" name="Counter" id="Counter">
      <input type="hidden" name="classId" value="<?php echo $row_Recordset1['classId']; ?>">
      <input type="hidden" name="teacherId" value="<?php echo $row_Recordset1['teacherId']; ?>">
      <input type="hidden" name="closedDate" value="<?php echo $monday ?>">
                    <input type="submit" name="home" id="按鈕" value="停課">
                    <input type="hidden" name="MM_insert" value="Counter">
                    </form></td>
                  </tr>
                  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
                
              </table>
              <table width="150" border="1" cellpadding="1" cellspacing="0" bordercolor="#A4BAE0" align="left">
                <tr>
                  <td width="150" align="center" valign="middle">星期二(<?php echo substr($tuesday,-5); ?>)</td>
                </tr>
                <?php do { ?>
                  <tr>
                    <td align="center"><?php echo substr($row_Recordset2['classStart'],0,-3); ?><br><a href="rollcall.php?new=<?php echo $row_Recordset2['classId']; ?>"><?php echo $row_Recordset2['calssName']; ?></a>    
                    <form action="<?php echo $editFormAction; ?>" method="POST" name="Counter" id="Counter">
      <input type="hidden" name="classId" value="<?php echo $row_Recordset2['classId']; ?>">
      <input type="hidden" name="teacherId" value="<?php echo $row_Recordset2['teacherId']; ?>">
      <input type="hidden" name="closedDate" value="<?php echo $tuesday; ?>">
                    <input type="submit" name="home" id="按鈕" value="停課">
                    <input type="hidden" name="MM_insert" value="Counter">
                    </form></td>
                  </tr>
                  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
                
              </table>
               <table width="150" border="1" cellpadding="1" cellspacing="0" bordercolor="#A4BAE0" align="left">
                <tr>
                  <td width="150" align="center" valign="middle">星期三(<?php echo substr($wednsday,-5); ?>)</td>
                </tr>
               <?php do { ?>
                  <tr>
                    <td align="center"><?php echo substr($row_Recordset3['classStart'],0,-3); ?><br><a href="rollcall.php?new=<?php echo $row_Recordset3['classId']; ?>"><?php echo $row_Recordset3['calssName']; ?></a>    
                    <form action="<?php echo $editFormAction; ?>" method="POST" name="Counter" id="Counter">
      <input type="hidden" name="classId" value="<?php echo $row_Recordset3['classId']; ?>">
      <input type="hidden" name="teacherId" value="<?php echo $row_Recordset3['teacherId']; ?>">
      <input type="hidden" name="closedDate" value="<?php echo $wednsday; ?>">
                    <input type="submit" name="home" id="按鈕" value="停課">
                    <input type="hidden" name="MM_insert" value="Counter">
                    </form></td>
                  </tr>
                  <?php } while ($row_Recordset3 = mysql_fetch_assoc($Recordset3)); ?>
                
              </table>
               <table width="150" border="1" cellpadding="1" cellspacing="0" bordercolor="#A4BAE0" align="left">
                <tr>
                  <td width="150" align="center" valign="middle">星期四(<?php echo substr($thursday,-5); ?>)</td>
                </tr>
                <?php do { ?>
                  <tr>
                    <td align="center"><?php echo substr($row_Recordset4['classStart'],0,-3); ?><br><a href="rollcall.php?new=<?php echo $row_Recordset4['classId']; ?>"><?php echo $row_Recordset4['calssName']; ?></a>    
                    <form action="<?php echo $editFormAction; ?>" method="POST" name="Counter" id="Counter">
      <input type="hidden" name="classId" value="<?php echo $row_Recordset4['classId']; ?>">
      <input type="hidden" name="teacherId" value="<?php echo $row_Recordset4['teacherId']; ?>">
      <input type="hidden" name="closedDate" value="<?php echo $thursday; ?>">
                    <input type="submit" name="home" id="按鈕" value="停課">
                    <input type="hidden" name="MM_insert" value="Counter">
                    </form></td>
                  </tr>
                  <?php } while ($row_Recordset4 = mysql_fetch_assoc($Recordset4)); ?>
                
              </table>
               <table width="150" border="1" cellpadding="1" cellspacing="0" bordercolor="#A4BAE0" align="left">
                <tr>
                  <td width="150" align="center" valign="middle">星期五(<?php echo substr($friday,-5); ?>)</td>
                </tr>
                <?php do { ?>
                  <tr>
                    <td align="center"><?php echo substr($row_Recordset5['classStart'],0,-3); ?><br><a href="rollcall.php?new=<?php echo $row_Recordset5['classId']; ?>"><?php echo $row_Recordset5['calssName']; ?></a>   
                    <form action="<?php echo $editFormAction; ?>" method="POST" name="Counter" id="Counter">
      <input type="hidden" name="classId" value="<?php echo $row_Recordset5['classId']; ?>">
      <input type="hidden" name="teacherId" value="<?php echo $row_Recordset5['teacherId']; ?>">
      <input type="hidden" name="closedDate" value="<?php echo $friday; ?>">
                    <input type="submit" name="home" id="按鈕" value="停課">
                    <input type="hidden" name="MM_insert" value="Counter">
                    </form></td>
                  </tr>
                  <?php } while ($row_Recordset5= mysql_fetch_assoc($Recordset5)); ?>
                
              </table>
               <table width="150" border="1" cellpadding="1" cellspacing="0" bordercolor="#A4BAE0" align="left">
                <tr>
                  <td width="150" align="center" valign="middle">星期六(<?php echo substr($saturday,-5); ?>)</td>
                </tr>
               <?php do { ?>
                  <tr>
                    <td align="center"><?php echo substr($row_Recordset6['classStart'],0,-3); ?><br>    
                      <a href="rollcall.php?new=<?php echo $row_Recordset6['classId']; ?>"><?php echo $row_Recordset6['calssName']; ?></a>
                      <form action="<?php echo $editFormAction; ?>" method="POST" name="Counter" id="Counter">
      <input type="hidden" name="classId" value="<?php echo $row_Recordset6['classId']; ?>">
      <input type="hidden" name="teacherId" value="<?php echo $row_Recordset6['teacherId']; ?>">
      <input type="hidden" name="closedDate" value="<?php echo $saturday; ?>">
                    <input type="submit" name="home" id="按鈕" value="停課">
                    <input type="hidden" name="MM_insert" value="Counter">
                    </form></td>
                  </tr>
                  <?php } while ($row_Recordset6 = mysql_fetch_assoc($Recordset6)); ?>
                
              </table>
<br>


 </div>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset4);

mysql_free_result($Recordset5);

mysql_free_result($Recordset6);

mysql_free_result($Recordset7);
?>
