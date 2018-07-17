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
$MM_authorizedUsers = "";
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "sander1")) {
  $insertSQL = sprintf("INSERT INTO cancelmealdata (studentId, studentName, cancelDate) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['studentId'], "int"),
                       GetSQLValueString($_POST['studentName'], "text"),
                       GetSQLValueString($_POST['cancelDate'], "date"));

  mysql_select_db($database_memberConn, $memberConn);
  $Result1 = mysql_query($insertSQL, $memberConn) or die(mysql_error());

  $insertGoTo = "order.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "sander2")) {
  $insertSQL = sprintf("INSERT INTO cancelmealdata (studentId, studentName, cancelDate) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['studentId'], "int"),
                       GetSQLValueString($_POST['studentName'], "text"),
                       GetSQLValueString($_POST['cancelDate'], "date"));

  mysql_select_db($database_memberConn, $memberConn);
  $Result1 = mysql_query($insertSQL, $memberConn) or die(mysql_error());

  $insertGoTo = "order.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "sander3")) {
  $insertSQL = sprintf("INSERT INTO cancelmealdata (studentId, studentName, cancelDate) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['studentId'], "int"),
                       GetSQLValueString($_POST['studentName'], "text"),
                       GetSQLValueString($_POST['cancelDate'], "date"));

  mysql_select_db($database_memberConn, $memberConn);
  $Result1 = mysql_query($insertSQL, $memberConn) or die(mysql_error());

  $insertGoTo = "order.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "sander4")) {
  $insertSQL = sprintf("INSERT INTO cancelmealdata (studentId, studentName, cancelDate) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['studentId'], "int"),
                       GetSQLValueString($_POST['studentName'], "text"),
                       GetSQLValueString($_POST['cancelDate'], "date"));

  mysql_select_db($database_memberConn, $memberConn);
  $Result1 = mysql_query($insertSQL, $memberConn) or die(mysql_error());

  $insertGoTo = "order.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "sander5")) {
  $insertSQL = sprintf("INSERT INTO cancelmealdata (studentId, studentName, cancelDate) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['studentId'], "int"),
                       GetSQLValueString($_POST['studentName'], "text"),
                       GetSQLValueString($_POST['cancelDate'], "date"));

  mysql_select_db($database_memberConn, $memberConn);
  $Result1 = mysql_query($insertSQL, $memberConn) or die(mysql_error());

  $insertGoTo = "order.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "sander6")) {
  $insertSQL = sprintf("INSERT INTO cancelmealdata (studentId, studentName, cancelDate) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['studentId'], "int"),
                       GetSQLValueString($_POST['studentName'], "text"),
                       GetSQLValueString($_POST['cancelDate'], "date"));

  mysql_select_db($database_memberConn, $memberConn);
  $Result1 = mysql_query($insertSQL, $memberConn) or die(mysql_error());

  $insertGoTo = "order.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_GET['cancelmealId'])) && ($_GET['cancelmealId'] != "") && (isset($_GET['del']))) {
  $deleteSQL = sprintf("DELETE FROM cancelmealdata WHERE cancelmealId=%s",
                       GetSQLValueString($_GET['cancelmealId'], "text"));

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
$query_Recordset1 = "SELECT * FROM studentdata WHERE studentMON = 1";
$Recordset1 = mysql_query($query_Recordset1, $memberConn) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_memberConn, $memberConn);
$query_Recordset2 = "SELECT * FROM studentdata WHERE studentTUE = 1";
$Recordset2 = mysql_query($query_Recordset2, $memberConn) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_memberConn, $memberConn);
$query_Recordset3 = "SELECT * FROM studentdata WHERE studentWED = 1";
$Recordset3 = mysql_query($query_Recordset3, $memberConn) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

mysql_select_db($database_memberConn, $memberConn);
$query_Recordset4 = "SELECT * FROM studentdata WHERE studentTHU =1";
$Recordset4 = mysql_query($query_Recordset4, $memberConn) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

mysql_select_db($database_memberConn, $memberConn);
$query_Recordset5 = "SELECT * FROM studentdata WHERE studentFRI = 1";
$Recordset5 = mysql_query($query_Recordset5, $memberConn) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);

mysql_select_db($database_memberConn, $memberConn);
$query_Recordset6 = "SELECT * FROM studentdata WHERE studentSAT = 1";
$Recordset6 = mysql_query($query_Recordset6, $memberConn) or die(mysql_error());
$row_Recordset6 = mysql_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysql_num_rows($Recordset6);

mysql_select_db($database_memberConn, $memberConn);
$query_Recordset7 = "SELECT * FROM cancelmealdata WHERE cancelDate=CURDATE() AND DAYOFWEEK(CURDATE())=2";
$Recordset7 = mysql_query($query_Recordset7, $memberConn) or die(mysql_error());
$row_Recordset7 = mysql_fetch_assoc($Recordset7);
$totalRows_Recordset7 = mysql_num_rows($Recordset7);

mysql_select_db($database_memberConn, $memberConn);
$query_Recordset8 = "SELECT * FROM cancelmealdata WHERE cancelDate=CURDATE() AND DAYOFWEEK(CURDATE())=3";
$Recordset8 = mysql_query($query_Recordset8, $memberConn) or die(mysql_error());
$row_Recordset8 = mysql_fetch_assoc($Recordset8);
$totalRows_Recordset8 = mysql_num_rows($Recordset8);

mysql_select_db($database_memberConn, $memberConn);
$query_Recordset9 = "SELECT * FROM cancelmealdata WHERE cancelDate=CURDATE() AND DAYOFWEEK(CURDATE())=4";
$Recordset9 = mysql_query($query_Recordset9, $memberConn) or die(mysql_error());
$row_Recordset9 = mysql_fetch_assoc($Recordset9);
$totalRows_Recordset9 = mysql_num_rows($Recordset9);

mysql_select_db($database_memberConn, $memberConn);
$query_Recordset10 = "SELECT * FROM cancelmealdata WHERE cancelDate=CURDATE() AND DAYOFWEEK(CURDATE())=5";
$Recordset10 = mysql_query($query_Recordset10, $memberConn) or die(mysql_error());
$row_Recordset10 = mysql_fetch_assoc($Recordset10);
$totalRows_Recordset10 = mysql_num_rows($Recordset10);

mysql_select_db($database_memberConn, $memberConn);
$query_Recordset11 = "SELECT * FROM cancelmealdata WHERE cancelDate=CURDATE() AND DAYOFWEEK(CURDATE())=6";
$Recordset11 = mysql_query($query_Recordset11, $memberConn) or die(mysql_error());
$row_Recordset11 = mysql_fetch_assoc($Recordset11);
$totalRows_Recordset11 = mysql_num_rows($Recordset11);

mysql_select_db($database_memberConn, $memberConn);
$query_Recordset12 = "SELECT * FROM cancelmealdata WHERE cancelDate=CURDATE() AND DAYOFWEEK(CURDATE())=7";
$Recordset12 = mysql_query($query_Recordset12, $memberConn) or die(mysql_error());
$row_Recordset12 = mysql_fetch_assoc($Recordset12);
$totalRows_Recordset12 = mysql_num_rows($Recordset12);

mysql_select_db($database_memberConn, $memberConn);
$query_Recordset13 = "SELECT * FROM cancelmealdata WHERE to_days(cancelmealdata.cancelDate) = to_days(now())";
$Recordset13 = mysql_query($query_Recordset13, $memberConn) or die(mysql_error());
$row_Recordset13 = mysql_fetch_assoc($Recordset13);
$totalRows_Recordset13 = mysql_num_rows($Recordset13);
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
<?php require_once('Connections/memberConn.php'); 


mysql_query("SET NAMES 'UTF8'");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>查詢訂餐</title>
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
#red {
	color: #C03;
}
#置中{
	position: absolute;
	right: 60%;
	top: 15%;
	font-family: "微軟正黑體 Light";
	font-size: 25px;
	font-weight: bold;
	color: #000;
    right:0%;
}
.表格 {
	background-color: #000;
}
.課程資訊 {
font-family: "微軟正黑體 Light";
font-weight: bold;
align:center;
top: 20%;
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

<br>
  
<div class="課程資訊">
  <div align="center">
訂餐查詢<br>
<br>
<?php if (date('w')==1){ ?>
<div align="center">    
        <table width="12%" border="1" cellpadding="1" cellspacing="0" bordercolor="#A4BAE0"  align="center">
            <tr>
              <td width="50" align="center" valign="middle">星期一</td>
            </tr>
            <tr>  
               <td width="50" height="30" align="center" valign="middle"><?php echo ($totalRows_Recordset1)-($totalRows_Recordset7) ?>人</td>
               </tr>
                <?php do { ?>
                <form action="<?php echo $editFormAction; ?>" method="POST" name="sander1">
                  <input type="hidden" value="<?php echo $row_Recordset1['studentId']; ?>" name="studentId" id="studentId">
                  <input type="hidden" value="<?php echo $row_Recordset1['studentName']; ?>" name="studentName" id="studentName">
                  <input type="hidden" value="<?php echo date('Y-m-j') ?>" name="cancelDate" id="cancelDate">
                  <tr>
                  <td width="50" height="30" align="center" valign="middle"><?php echo $row_Recordset1['studentName']; ?><input  type="submit" value="退訂" name="set">
                    <input type="hidden" name="MM_insert" value="sander1">
              </form>
                </td>
                </tr>
                <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
              <tr>
              </table>
              <?php }
			  else if (date('w')==2){ ?>
              <table width="12%" border="1" cellpadding="1" cellspacing="0" bordercolor="#A4BAE0"  align="center">
            <tr>
              <td width="50" align="center" valign="middle">星期二</td>
            </tr>
            <tr>  
               <td width="50" height="30" align="center" valign="middle"><?php echo ($totalRows_Recordset2)-($totalRows_Recordset8) ?>人</td>
               </tr>
                <?php do { ?>
                <form action="<?php echo $editFormAction; ?>" method="POST" name="sander1">
                  <input type="hidden" value="<?php echo $row_Recordset2['studentId']; ?>" name="studentId" id="studentId">
                  <input type="hidden" value="<?php echo $row_Recordset2['studentName']; ?>" name="studentName" id="studentName">
                  <input type="hidden" value="<?php echo date('Y-m-j') ?>" name="cancelDate" id="cancelDate">
                   <tr>
                  <td width="50" height="30" align="center" valign="middle"><?php echo $row_Recordset2['studentName']; ?><input  type="submit" value="退訂" name="set">
                    <input type="hidden" name="MM_insert" value="sander1">
              </form>
                </td>
                 </tr>
                <?php } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); ?>
              <tr>
              </table>
              <?php }
			  else if (date('w')==3){ ?>
              <table width="12%" border="1" cellpadding="1" cellspacing="0" bordercolor="#A4BAE0" align="center">
            <tr>
              <td width="50" align="center" valign="middle">星期三</td>
            </tr>
            <tr>  
               <td width="50" height="30" align="center" valign="middle"><?php echo ($totalRows_Recordset3)-($totalRows_Recordset9) ?>人</td>
               </tr>
                <?php do { ?>
                <form action="<?php echo $editFormAction; ?>" method="POST" name="sander1">
                  <input type="hidden" value="<?php echo $row_Recordset3['studentId']; ?>" name="studentId" id="studentId">
                  <input type="hidden" value="<?php echo $row_Recordset3['studentName']; ?>" name="studentName" id="studentName">
                  <input type="hidden" value="<?php echo date('Y-m-j') ?>" name="cancelDate" id="cancelDate">
                   <tr>
                  <td width="50" height="30" align="center" valign="middle"><?php echo $row_Recordset3['studentName']; ?><input  type="submit" value="退訂" name="set">
                    <input type="hidden" name="MM_insert" value="sander1">
              </form>
                </td>
                 </tr>
                <?php } while ($row_Recordset3 = mysql_fetch_assoc($Recordset3)); ?>
              <tr>
              </table>
              <?php }
			  else if (date('w')==4){ ?>
              <table width="12%" border="1" cellpadding="1" cellspacing="0" bordercolor="#A4BAE0" align="center">
            <tr>
              <td width="50" align="center" valign="middle">星期四</td>
            </tr>
            <tr>  
               <td width="50" height="30" align="center" valign="middle"><?php echo ($totalRows_Recordset4)-($totalRows_Recordset10) ?>人</td>
               </tr>
                <?php do { ?>
                <form action="<?php echo $editFormAction; ?>" method="POST" name="sander1">
                  <input type="hidden" value="<?php echo $row_Recordset4['studentId']; ?>" name="studentId" id="studentId">
                  <input type="hidden" value="<?php echo $row_Recordset4['studentName']; ?>" name="studentName" id="studentName">
                  <input type="hidden" value="<?php echo date('Y-m-j') ?>" name="cancelDate" id="cancelDate">
                   <tr>
                  <td width="50" height="30" align="center" valign="middle"><?php echo $row_Recordset4['studentName']; ?><input  type="submit" value="退訂" name="set">
                    <input type="hidden" name="MM_insert" value="sander1">
              </form>
                </td>
                 </tr>
                <?php } while ($row_Recordset4 = mysql_fetch_assoc($Recordset4)); ?>
              <tr>
              </table>
              <?php }
			  else if (date('w')==5){ ?>
              <table width="12%" border="1" cellpadding="1" cellspacing="0" bordercolor="#A4BAE0" align="center">
            <tr>
              <td width="50" align="center" valign="middle">星期五</td>
            </tr>
            <tr>  
               <td width="50" height="30" align="center" valign="middle"><?php echo ($totalRows_Recordset5)-($totalRows_Recordset11) ?>人</td>
               </tr>
                <?php do { ?>
                <form action="<?php echo $editFormAction; ?>" method="POST" name="sander1">
                  <input type="hidden" value="<?php echo $row_Recordset5['studentId']; ?>" name="studentId" id="studentId">
                  <input type="hidden" value="<?php echo $row_Recordset5['studentName']; ?>" name="studentName" id="studentName">
                  <input type="hidden" value="<?php echo date('Y-m-j') ?>" name="cancelDate" id="cancelDate">
                   <tr>
                  <td width="50" height="30" align="center" valign="middle"><?php echo $row_Recordset5['studentName']; ?><input  type="submit" value="退訂" name="set">
                    <input type="hidden" name="MM_insert" value="sander1">
              </form>
                </td>
                 </tr>
                <?php } while ($row_Recordset5 = mysql_fetch_assoc($Recordset5)); ?>
              <tr>
              </table>
              <?php }
			  else if (date('w')==6){ ?>
              <table width="12%" border="1" cellpadding="1" cellspacing="0" bordercolor="#A4BAE0" align="center">
            <tr>
              <td width="50" align="center" valign="middle">星期六</td>
            </tr>
            <tr>  
               <td width="50" height="30" align="center" valign="middle"><?php echo ($totalRows_Recordset6)-($totalRows_Recordset12) ?>人</td>
               </tr>
                <?php do { ?>
                <form action="<?php echo $editFormAction; ?>" method="POST" name="sander1">
                  <input type="hidden" value="<?php echo $row_Recordset6['studentId']; ?>" name="studentId" id="studentId">
                  <input type="hidden" value="<?php echo $row_Recordset6['studentName']; ?>" name="studentName" id="studentName">
                  <input type="hidden" value="<?php echo date('Y-m-j') ?>" name="cancelDate" id="cancelDate">
                   <tr>
                  <td width="50" height="30" align="center" valign="middle"><?php echo $row_Recordset6['studentName']; ?><input  type="submit" value="退訂" name="set">
                    <input type="hidden" name="MM_insert" value="sander1">
              </form>
                </td>
                 </tr>
                <?php } while ($row_Recordset6 = mysql_fetch_assoc($Recordset6)); ?>
              <tr>
              </table>
              <?php } ?>
</div>
<div align="center">  
<p>今日退訂紀錄 </p>
<table width="440px" border="1" cellpadding="1" cellspacing="0" bordercolor="#A4BAE0">
      <tr>
        <td width="117" align="center" valign="middle">學生姓名</td>
        <td width="89" align="center" valign="middle">學生編號</td>
        <td width="130" align="center" valign="middle">退訂日期</td>
        <td width="90" align="center" valign="middle"></td>
      </tr>
                <?php do { ?>
        <tr>
<td width="117" height="30" align="center" valign="middle"><?php echo $row_Recordset13['studentName']; ?></td>
          <td width="89" align="center" valign="middle"><?php echo $row_Recordset13['studentId']; ?></td>
          <td width="130" align="center" valign="middle"><?php echo $row_Recordset13['cancelDate']; ?></td> 
          <td width="90" align="center" valign="middle"><a href="order.php?del=true&amp;cancelmealId=<?php echo $row_Recordset13['cancelmealId']; ?>">刪除</td>
        </tr>
        <?php } while ($row_Recordset13 = mysql_fetch_assoc($Recordset13)); ?>
    </table>
<br>
  <a href="home.php">
    <input type="button" name="home" id="按鈕" value="確認">
  </a></p>
  </div>
</div>

</div>
</body>

<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset4);

mysql_free_result($Recordset5);

mysql_free_result($Recordset6);

mysql_free_result($Recordset7);

mysql_free_result($Recordset8);

mysql_free_result($Recordset9);

mysql_free_result($Recordset10);

mysql_free_result($Recordset11);

mysql_free_result($Recordset12);

mysql_free_result($Recordset13);
?>
