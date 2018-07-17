<?php 


$servername = "localhost";
$username = "root";
$password = "s0r4sGRbJPOrTlML";
 
try {
    $conn = new PDO("mysql:host=$servername;dbname=myDB", $username, $password);
    echo "连接成功"; 
}
catch(PDOException $e)
{
    echo $e->getMessage();
}

mysql_select_db($database_memberConn, $memberConn);
$query_Recordset1 = "SELECT * FROM teacherdata";
$Recordset1 = mysql_query($query_Recordset1, $memberConn) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['memId'])) {
  $loginUsername=$_POST['memId'];
  $password=$_POST['memPsw'];
  $MM_fldUserAuthorization = "teacherLevel";
  $MM_redirectLoginSuccess = "home.php";
  $MM_redirectLoginFailed = "login.php?Err=yes";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_memberConn, $memberConn);
  	
  $LoginRS__query=sprintf("SELECT teacherAccount, teacherPsw, teacherLevel FROM teacherdata WHERE teacherAccount=%s AND teacherPsw=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $memberConn) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'teacherLevel');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>登入頁面</title>
<style type="text/css">
#login {
	position: absolute;
	right: 45%;
	top: 35%;
	font-family: "微軟正黑體 Light";
	font-size: 20px;
	font-weight: bold;
	color: #000;
}
</style>
</head>

<body>
<div id="login" align="center">點名系統登入
  <br>
  <br>
   <?php 
		  $_GET["Err"] = (isset($_GET["Err"]) ? $_GET["Err"] : 'no');
		  if($_GET["Err"]=="yes") {
          ?>
  <table width="300" border="1" align="center" cellpadding="1" cellspacing="1">
              <tr>
                <td align="center" bgcolor="#990000" ><span class="style2">登入錯誤：帳號或密碼輸入錯誤</span></td>
              </tr>
  </table>
  
   <?php }?>
  <form ACTION="<?php echo $loginFormAction; ?>" METHOD="POST" id="form1" name="form1" >
   <table width="300" border="1" align="center" cellpadding="1" cellspacing="1">
              <tr>
                <td align="center" bgcolor="#FF6" ><span class="style2">
                <br>
                
  *帳號:
  <input name="memId" type="text">
  <br>
  *密碼:
  <input name="memPsw" type="text">
  <br>
  <br>
  </td>
              </tr>
  </table>
  <br>
  <input style="font-size: 18px; width: 100px; height: 30px; color: #000; font-weight: bold; font-family: '微軟正黑體 Light';" type="submit" name="submit" id="submit" value="送出" />
  </form>
  
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
