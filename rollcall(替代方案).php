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

if ((isset($_GET['callrollId'])) && ($_GET['callrollId'] != "") && (isset($_GET['del2']))) {
  $deleteSQL = sprintf("DELETE FROM rollcalldata WHERE callrollId=%s",
                       GetSQLValueString($_GET['callrollId'], "int"));

  mysql_select_db($database_memberConn, $memberConn);
  $Result1 = mysql_query($deleteSQL, $memberConn) or die(mysql_error());

  $deleteGoTo = "home.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

if ((isset($_GET['classId'])) && ($_GET['classId'] != "") && (isset($_GET['del1']))) {
  $deleteSQL = sprintf("DELETE FROM classdata WHERE classId=%s",
                       GetSQLValueString($_GET['classId'], "int"));

  mysql_select_db($database_memberConn, $memberConn);
  $Result1 = mysql_query($deleteSQL, $memberConn) or die(mysql_error());

  $deleteGoTo = "home.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "sander2")) {
  $insertSQL = sprintf("INSERT INTO absencedata (classId, studentId, classCount, absenceDate) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['classId'], "int"),
                       GetSQLValueString($_POST['studentId'], "int"),
                       GetSQLValueString($_POST['classCount'], "int"),
                       GetSQLValueString($_POST['absenceDate'], "date"));

  mysql_select_db($database_memberConn, $memberConn);
  $Result1 = mysql_query($insertSQL, $memberConn) or die(mysql_error());

  $insertGoTo = "rollcall.php?tag=yes";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "Counter")) {
  $insertSQL = sprintf("INSERT INTO historyclassdata (classId, teacherId, teacherName, historyclassDate, historyCount) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['classId'], "int"),
                       GetSQLValueString($_POST['teacherId'], "int"),
                       GetSQLValueString($_POST['teacherName'], "text"),
                       GetSQLValueString($_POST['historyclassDate'], "date"),
                       GetSQLValueString($_POST['hitoryCount'], "int"));

  mysql_select_db($database_memberConn, $memberConn);
  $Result1 = mysql_query($insertSQL, $memberConn) or die(mysql_error());

  $insertGoTo = "home.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['new'])) {
  $colname_Recordset1 = $_GET['new'];
}
mysql_select_db($database_memberConn, $memberConn);
$query_Recordset1 = sprintf("SELECT * FROM classdata WHERE classId = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $memberConn) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_GET['new'])) {
  $colname_Recordset2 = $_GET['new'];
}
mysql_select_db($database_memberConn, $memberConn);
$query_Recordset2 = sprintf("SELECT * FROM absencedata INNER JOIN (rollcalldata INNER JOIN studentdata ON rollcalldata.studentId = studentdata.studentId) ON absencedata.studentId = studentdata.studentId WHERE rollcalldata.classId = %s ", GetSQLValueString($colname_Recordset2, "text"));
$Recordset2 = mysql_query($query_Recordset2, $memberConn) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_Recordset3 = "-1";
if (isset($_GET['new'])) {
  $colname_Recordset3 = $_GET['new'];
}
mysql_select_db($database_memberConn, $memberConn);
$query_Recordset3 = sprintf("SELECT teacherdata.teacherName ,teacherdata.teacherLevel ,teacherdata.teacherId FROM classdata INNER JOIN teacherdata ON classdata.teacherId = teacherdata.teacherId WHERE classdata.classId = %s", GetSQLValueString($colname_Recordset3, "text"));
$Recordset3 = mysql_query($query_Recordset3, $memberConn) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

mysql_select_db($database_memberConn, $memberConn);
$query_Recordset4 = "SELECT teacherLevel FROM teacherdata";
$Recordset4 = mysql_query($query_Recordset4, $memberConn) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

$colname_Recordset5 = "-1";
if (isset($_GET['new'])) {
  $colname_Recordset5 = $_GET['new'];
}
mysql_select_db($database_memberConn, $memberConn);
$query_Recordset5 = sprintf("SELECT * FROM historyclassdata WHERE classId = %s", GetSQLValueString($colname_Recordset5, "int"));
$Recordset5 = mysql_query($query_Recordset5, $memberConn) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);

mysql_select_db($database_memberConn, $memberConn);
$query_Recordset6 = "SELECT * FROM absencedata";
$Recordset6 = mysql_query($query_Recordset6, $memberConn) or die(mysql_error());
$row_Recordset6 = mysql_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysql_num_rows($Recordset6);

mysql_query("SET NAMES 'UTF8'");
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
  echo date('Y,m,j  AH:i');
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
          <a href="search_class.php"><input type="button" name="查詢課程" id="按鈕" value="查詢課程"></a>
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
        <?php if ($row_Recordset1['teacherLevel']=='admin'){ ?>
 <p>
          <a href="addteacher.php"><input type="button" name="新增教師" id="按鈕" value="新增教師"></a>
        </p>
          <p>
          <a href="search_teacher.php"><input type="button" name="查詢教師" id="按鈕" value="查詢教師"></a>
        </p>
        <?php }
		else
		{    ?>    
		<?php } ?>
        
    </div>
  </div>
  <div class="content" id="content">
    <div align="center" class="課程資訊";>課程資料<br>
              <table width="70%" border="1" cellpadding="1" cellspacing="0" bordercolor="#A4BAE0">
                <tr>
                  <td width="180" align="center" valign="middle">課程名稱</td>
                  <td width="180" align="center" valign="middle">上課時間</td>
                  <td width="180" align="center" valign="middle">課程時間(時)</td>
                  <td width="180" align="center" valign="middle">授課教師</td>
                  <td width="200" align="center" valign="middle">此次上課次數</td>
                  <td width="150" align="center" valign="middle"></td>
                </tr>
                <tr>
                  <td align="center"><?php echo $row_Recordset1['calssName']; ?></td>
                  <td align="center"><?php echo substr($row_Recordset1['classStart'], 0, -3); ?></td>
                  <td align="center"><?php echo $row_Recordset1['classTime']; ?></td>
                  <td align="center"><?php echo $row_Recordset3['teacherName']; ?></td>
                  <?php if($totalRows_Recordset5==$row_Recordset1['classCount']){ ?>
                  <td align="center">課程已結束</td>
                  <?php }
					  else{ ?>
                  <td align="center">第<?php echo ($totalRows_Recordset5)+1?>次</td>
                  <?php }　?>
                  <td align="center"><a href="rollcall.php?del1=true&amp;classId=<?php echo $row_Recordset1['classId']; ?>">刪除課程</a></td>
                </tr>

              </table>
             
     
    </table></td>
</div>
 <?php 
		  $_GET["tag"] = (isset($_GET["tag"]) ? $_GET["tag"] : 'no');
		  if($_GET["tag"]=="yes") {
          ?>
  <table width="300" border="1" align="center" cellpadding="1" cellspacing="1">
              <tr>
                <td align="center" bgcolor="#FFF" ><span class="style2">缺席已標記!</span></td>
              </tr>
  </table>
  
   <?php }?>
<br>
<div class="課程資訊"><div align="center">學生資料<div>
      <table width="300px" border="1" cellpadding="1" cellspacing="0" bordercolor="#A4BAE0">
                <tr>
                  <td width="50" align="center" valign="middle">學生姓名</td>
                  <td width="30" align="center" valign="middle">點名</td>
                 
                </tr>
                 <?php do { ?>
                 <?php if($row_Recordset2['absenceDate']==date('Y-m-j')){ ?>
        <tr>
          <td width="50" height="30" align="center" valign="middle"><?php echo $row_Recordset2['studentName']; ?></td>
          <td width="30" align="center" valign="middle">
             已標記缺席
             </td>
             <?php }
          else { ?>
          <tr>
          <td width="50" height="30" align="center" valign="middle"><?php echo $row_Recordset2['studentName']; ?></td>
             <form action="<?php echo $editFormAction; ?>" method="POST" name="sander2" id="rollcall">
             <input type="hidden" value="<?php echo $row_Recordset2['classId']; ?>" name="classId" id="classId">
             <input type="hidden" value="<?php echo $row_Recordset2['studentId']; ?>" name="studentId" id="studentId">
             <input type="hidden" value="<?php echo ($totalRows_Recordset5)+1?>" name="classCount" id="classCount">
             <input type="hidden" value="<?php echo date('Y-m-j')?>" name="absenceDate" id="absenceDate">
              <td width="30" align="center" valign="middle">
             <input  type="submit" value="標記缺席" name="set">
             </td>
              <?php } ?>

              <input type="hidden" name="MM_insert" value="sander2">
             </form>
        </tr>
         <?php } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); ?>
      </table>
              <p>
              <?php if($totalRows_Recordset5==$row_Recordset1['classCount']){ ?>
              <a href="home.php"><input type="submit" name="home" id="按鈕" value="確認"></a>
              <?php }
			  else { ?>
        <form action="<?php echo $editFormAction; ?>" method="POST" name="Counter" id="Counter">
              <input type="hidden" name="classId" value="<?php echo $row_Recordset1['classId']; ?>">
          <input type="hidden" name="teacherId" value="<?php echo $row_Recordset3['teacherId']; ?>">
              <input type="hidden" name="teacherName" value="<?php echo $row_Recordset3['teacherName']; ?>">
          <input type="hidden" name="historyclassDate" value="<?php echo date('Y-m-j') ?>">
          <input type="hidden" name="hitoryCount" value="<?php echo ($totalRows_Recordset5)+1 ?>"> 
          <a href="home.php"><input type="button" name="home" id="按鈕" value="回到首頁"></a>
          <input type="submit" name="home" id="按鈕" value="點名"></a>
          
          <input type="hidden" name="MM_insert" value="Counter">
        </form>
<?php } ?>
</div>
<br>
  </div>
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
?>
