<html>
<head>
<?php
echo "<table id='table' style='border: solid 2px black;'>";
  echo "<thead><tr><th>Firstname</th><th>Lastname</th><th>Number Of viewing</th></tr></thead>";

class TableRows extends RecursiveIteratorIterator {
     function __construct($it) {
         parent::__construct($it, self::LEAVES_ONLY);
     }

     function current() {
         return "<td style='width: 150px; border: 1px solid red;'>" . parent::current(). "</td>";
     }

     function beginChildren() {
         echo "<tr>";
     }

     function endChildren() {
         echo "</tr>" . "\n";
     }
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dreamhome";

try {
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $conn->prepare
	 
	(" SELECT client.fname,client.lname,COUNT(viewing.propertyno) AS NumberOfviewing FROM viewing
	LEFT JOIN client
	ON viewing.clientno=client.clientno
	GROUP BY fname;");
	
	

     $stmt->execute();

     // set the resulting array to associative
     $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

     foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
         echo $v;
     }
}
catch(PDOException $e) {
     echo "Error: " . $e->getMessage();
}
$conn = null;
echo "</table>";



?>

<script type="text/javascript" src="tableExport.jquery.plugin-master/jquery-3.1.1.js"></script>

<script type="text/javascript" src="tableExport.jquery.plugin-master/jspdf/libs/sprintf.js"></script>
<script type="text/javascript" src="tableExport.jquery.plugin-master/jspdf/jspdf.js"></script>
<script type="text/javascript" src="tableExport.jquery.plugin-master/jspdf/libs/base64.js"></script>

<script type="text/javascript" src="tableExport.jquery.plugin-master/jquery.base64.js"></script>
<script type="text/javascript" src="tableExport.jquery.plugin-master/tableExport.jquery.json"></script>
<script type="text/javascript" src="tableExport.jquery.plugin-master/tableExport.js"></script>

<script type="text/javascript"> 
$(document).ready(function(e) {
    $("#pdf").click(function(e){
		$("#table").tableExport({
			type:'pdf',
			escape:'false'
			});
			});
});

$(document).ready(function(e) {
    $("#excel").click(function(e){
		$("#table").tableExport({
			type:'xml',
			escape:'false'
			});
			});
});
</script>

<style>
.dropbtn {
    background-color: #000099;
    color: white;
    padding: 16px;
    font-size: 16px;
    border: none;
    cursor: pointer;
}

.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {background-color: #0066FF}

.dropdown:hover .dropdown-content {
    display: block;
}

.dropdown:hover .dropbtn {
    background-color: #3e8e41;
}
</style>
</head>
<body>


<p>Export database.</p>

<div class="dropdown">
  <button class="dropbtn">Dowload</button>
  <div class="dropdown-content">
    <a id="pdf" href="#" >PDF</a>
    <a id="excel" href="#">Excel</a>
  </div>
</div>





</body>
</html>
