<?php
error_reporting(0);
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

$mincount=$_GET['mincount'];
$minsum=$_GET['minsum'];

$lrate=$_GET['lrate'];



$q="select * from user ";
$res=mysqli_query($conn,$q);

while($row=mysqli_fetch_assoc($res))
{


	$end = date("Y-m-d H:i:s", strtotime('-1 years'));
  	//echo($end);echo "<br>";
  	//echo $row['accno'];



	$sql="select * from trans where dat >='$end' and accno=".$row['accno']." ";
	$r=mysqli_query($conn,$sql);
	$size=0;
	$sum=0;
	while($tran=mysqli_fetch_assoc($r))
	{
		//echo "sds";
		$size=$size+1;
		$sum=$sum+$tran['amount'];	

	}
	//echo $sum;
	//echo "<br>";
	//echo $size;
	//echo "<br>";

	if($size>=$mincount && $sum>=$minsum)
	{
		//echo "ansf";
		$rew=$sum*$lrate/100;
		$s="select reward from user where accno=".$row['accno']." ";
	$rt=mysqli_query($conn,$s);
	//echo "<br>";
	$f=mysqli_fetch_assoc($rt);
	$r=$f['reward'];
	//echo $r;
	//echo "<br>";

	$rew=$rew+$r;
	//echo $rew;
	$s="update user set reward='$rew' where accno=".$row['accno']." ";
	$r=mysqli_query($conn,$s);

	}

	


}


?>
