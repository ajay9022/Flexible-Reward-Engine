
//trans
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
//echo $accno;
$amount=$_GET['amount'];
//echo $amount;
$dat=date("Y-m-d H:i:s");
//echo $dat;

$mx=0;
$mn=0;
$q="select count(*) from user where accno=$accno";
$res=mysqli_query($conn,$q);


if($trans = mysqli_fetch_assoc($res))
{
	$q="insert into user values('$accno',0)";
	$res=mysqli_query($conn,$q);
	//echo "inserted";
}


$query = "SELECT * FROM scheme";
$result = mysqli_query($conn,$query);


//$reward=0;
while ($arrayResult = mysqli_fetch_assoc($result))
{
    echo '<tr>';
    
    $query1="select * from trans where accno='$accno' and dat >= '".$arrayResult['startd']."' and dat <= '".$arrayResult['endd']."' ";

    //echo $arrayResult['startd'];
    //echo $arrayResult['endd'];

    $result1 = mysqli_query($conn,$query1); 


    $size=sizeof($result1);
    echo "<br>";
    

    $sum=0;
    
    //$trans=mysqli_fetch_assoc($result1);
    //echo count($trans);
    //echo $trans['amount'];
    echo "<br>";
    $size=0;
    while($trans = mysqli_fetch_assoc($result1))
    {

    	$size=$size+1;
    	//echo $trans['amount'];
    	//echo "hat";
    	$sum=$sum +$trans['amount'];
    }

    //echo $size;
    echo "<br>";
    //echo $sum;

    if($arrayResult['transcount']<=$size && $arrayResult['mintransamt']<=$sum && $arrayResult['transcount']!=0)
    {
    	//echo "profit";
    	//echo $arrayResult['transcount'];
    	$value1=$arrayResult['percentreward']/100*$amount;


    	$q="select reward from user where accno='$accno'";
    	$res=mysqli_query($conn,$q);

    	$f=mysqli_fetch_assoc($res);
    	$reward=$f['reward'];
    	//echo $reward;
    	//echo "<br> bhenc";

    	$mn=min($value1,$reward);
    	//echo $mn;

    	$amount=$amount-$mn;
    	//echo $amount;

    	//echo "hear";
    	$cash=($amount/100)*$arrayResult['percentcash'];

    	//echo $cash;


    	$mx=max($mx,$cash);

    	//echo $mx;
    }
    else if($arrayResult['transcount']==0  && $sum==0 && $dat>=$arrayResult['startd'] && $dat<=$arrayResult['endd'])
    {

    	//echo "asdas";
    	//echo $arrayResult['transcount'];
    	$value1=$arrayResult['percentreward']/100*$amount;


    	$q="select reward from user where accno='$accno'";
    	$res=mysqli_query($conn,$q);

    	$f=mysqli_fetch_assoc($res);
    	$reward=$f['reward'];
    	//echo $reward;
    	//echo "<br> bhenc";

    	$mn=min($value1,$reward);
    	//echo $mn;

    	$amount=$amount-$mn;
    	//echo $amount;

    	//echo "hear";
    	$cash=($amount/100)*$arrayResult['percentcash'];

    	//echo $cash;


    	$mx=max($mx,$cash);
    }
    else
    {
    	//echo "no";
    }
}
    //echo $mx;



	//echo $amount;
	//echo $mn;
	//echo $mx;
    $q="select reward from user where accno='$accno'";
    $res=mysqli_query($conn,$q);

    $f=mysqli_fetch_assoc($res);
    $reward=$f['reward'];


    $reward=$reward-$mn+$mx;;	
    //echo $reward;




    $q="update user set reward=".$reward." where accno='".$accno."' ";
    $r=mysqli_query($conn,$q);


	$q= "insert into trans values ('$accno','$dat','$amount')";
	$r=mysqli_query($conn,$q);

	//echo "";

    $conn->close();

?>

<html>
	<head>
		</head>
	<body >
		
		<?php
		
		echo "
<label>Account no &nbsp    $accno</label>
<br>

<label>reedmption     $mn</label>
<br>

<label>Cashback        $mx</label>
<br>

<label>Real Amount to be paid      $amount</label>
";


?>
</body>
	



</html>