
<?php
  

  $servername="localhost";
  $username="root";
  $password = "";
  $dbname = "barc";

  $conn = mysqli_connect($servername,$username,$password,$dbname);

  if ($conn->connect_error) 
  {
      die("Connection failed: " . $conn->connect_error);
  }

  $startd = $_GET['startd'];
  $endd = $_GET['endd'];
  $transcount = $_GET['transcount'];
  $mintransamt = $_GET['mintransamt']; 
  $percentreward = $_GET['percentreward'];
  //$maxcash = $_GET['maxcash'];
  $percentcash=$_GET['percentcash'];
  //echo $percentcash;
  //echo $percentreward;

  $query = "insert into scheme values('$startd','$endd','$transcount','$mintransamt','$percentreward','$percentcash')";
  $result = mysqli_query($conn,$query);

  if(isset($result))
  {
  //echo("jknda");
    echo "<label> Successfully launched</label>";


  }
  else
  {
   echo "Not successfully";
  }





  //echo $startd." ".$endd." ".$transcount." ".$mintransamt." ".$percentreward." ".$maxcash;
  //echo "Hi Ash";
?>