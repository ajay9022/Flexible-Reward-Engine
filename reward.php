<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barc";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection

if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
} 


$accno=$_GET['accno'];

$q="Select * from user where accno='$accno'";
$res=mysqli_query($conn,$q);

$f=mysqli_fetch_assoc($res);

if($f['reward'])
{
	echo $f['reward'];
}
else
{
	echo "user not found";
	
}
