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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "sander2")) {
  $updateSQL = sprintf("UPDATE studentdata SET studentNumber=%s, studentGrade=%s, studentJoindate=%s WHERE studentId=%s",
                       GetSQLValueString($_POST['studentNumber'], "int"),
                       GetSQLValueString($_POST['studentGrade'], "int"),
                       GetSQLValueString($_POST['studentJoindate'], "date"),
                       GetSQLValueString($_POST['studentId'], "int"));

  mysql_select_db($database_memberConn, $memberConn);
  $Result1 = mysql_query($updateSQL, $memberConn) or die(mysql_error());

  $updateGoTo = "studentInClass.php?Succ=yes";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['studentName'])) {
  $colname_Recordset1 = $_GET['studentName'];
}
mysql_select_db($database_memberConn, $memberConn);
$query_Recordset1 = sprintf("SELECT * FROM studentdata WHERE studentName = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $memberConn) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
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
<title>學生入班</title>
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
  <form action="studentInClass.php" method="get" name="search2">
   <label for="bookdate">輸入學生姓名：</label>
   <br>
<input name="studentName" type="text" id="studentName">
<input type="submit" name="search1" value="搜尋">
 <?php 
		  $_GET["Succ"] = (isset($_GET["Succ"]) ? $_GET["Succ"] : 'no');
		  if($_GET["Succ"]=="yes") {
          ?>
          <table width="300" border="1" align="center" cellpadding="1" cellspacing="1">
              <tr>
                <td align="center"><span class="style2">已成功入班!</span></td>
              </tr>
  </table>
  <br>
   <?php }?>
</form>
    <div align="center" class="課程資訊";>學生資料<br>
              <table width="70%" border="1" cellpadding="1" cellspacing="0" bordercolor="#A4BAE0">
                <tr>
                <td width="200" align="center" valign="middle">學號</td>
                  <td width="200" align="center" valign="middle">學生姓名</td>
                  <td width="200" align="center" valign="middle">聯絡人姓名</td>
                  <td width="200" align="center" valign="middle">聯絡信箱</td>
                  <td width="180" align="center" valign="middle">連絡電話</td>
                  <td width="200" align="center" valign="middle">選擇年級</td>
                  <td width="150" align="center" valign="middle"></td>
                </tr>
                <?php do { ?>
                <tr>
                <td align="center"><?php echo $row_Recordset1['studentNumber']; ?></td>
                  <td align="center"><?php echo $row_Recordset1['studentName']; ?></td>
                  <td align="center"><?php echo $row_Recordset1['studentParents']; ?></td>
                  <td align="center"><?php echo $row_Recordset1['studentEmail']; ?></td>
                  <td align="center"><?php echo $row_Recordset1['studentTel']; ?></td>
                   <form action="<?php echo $editFormAction; ?>" method="POST" name="sander2" id="rollcall">
                   <td align="center">
                   <select name="studentGrade">
                   <option value="0">未達一年級</option>
　<option value="1">一年級</option>
　<option value="2">二年級</option>
<option value="3">三年級</option>
<option value="4">四年級</option>
<option value="5">五年級</option>
<option value="6">六年級</option>
<option value="7">七年級</option>
<option value="8">八年級</option>
<option value="9">九年級</option>
<option value="10">十年級</option>
<option value="11">十一年級</option>
<option value="12">十二年級</option>
</select></td>
                   <input type="hidden" name="studentId" id="studentId" value="<?php echo $row_Recordset1['studentId']; ?>">
                  <input type="hidden" name="studentJoindate" id="studentJoindate" value="<?php echo date('Y-m-j')?>">
                  <input type="hidden" name="studentNumber" id="studentNumber" value="<?php echo (date('Y')-1911)*1000+$row_Recordset1['studentId']?>">
                  <td align="center"><input  type="submit" value="確認入班" name="sure"></td>
                  <input type="hidden" name="MM_update" value="sander2">
                  </form>
                </tr>
                  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>

              </table>
             
     
    </table></td>
</div>
              <p>
              <div align="center"><a href="home.php"><input type="button" name="home" id="按鈕" value="返回"></a></td></div>
              
             
        </tr>
    </table></td>
</div>
<br>
</div>
</div>

</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);

?>
