<?php require_once('Connections/mysql.php'); ?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO customers (CustomerID, CitizenID, Firstname, Lastname) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['CustomerID'], "text"),
                       GetSQLValueString($_POST['CitizenID'], "text"),
                       GetSQLValueString($_POST['Firstname'], "text"),
                       GetSQLValueString($_POST['Lastname'], "text"));

  mysql_select_db($database_mysql, $mysql);
  $Result1 = mysql_query($insertSQL, $mysql) or die(mysql_error());
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lab6</title>
</head>
<?php
$servername = "localhost";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=webtech", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; 
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?>

<body>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">

    <label for="CustomerID">CustomerID</label>
    <input type="number" name="CustomerID" id="CustomerID" />

    <label for="CitizenID">CitizenID</label>
    <input type="number" name="CitizenID" id="CitizenID" /></p>
 
    <p> <label for="Firstname">Firstname</label>
    <input type="text" name="Firstname" id="Firstname" />

 
    <label for="Lastname">Lastname</label>
    <input type="text" name="Lastname" id="Lastname" /></p>
  

    <input type="submit" name="submit" id="submit" value="Submit" />
    <input type="reset" name="reset" id="reset" value="Reset" />
 	

  <input type="hidden" name="MM_insert" value="form1" />
</form>
</body>
</html>