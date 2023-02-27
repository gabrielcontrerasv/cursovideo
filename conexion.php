<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "video"; 


$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("La conexión falló: " . mysqli_connect_error());
}
echo "Conexión exitosa";
?>
