<?php
  $con=mysqli_connect("localhost","root","","tekweb");
  if(!$con)
  {
    die('Could not connect: ' . mysql_error());
  }
  
  $postData = file_get_contents("php://input");
  if($postData){
    $dataxml = simplexml_load_string($postData);
    // echo $postData;
    // print_r($dataxml);

    $nama=$dataxml->nama;
    $nrp=$dataxml->nrp;

    $result=mysqli_query($con, "INSERT INTO `mahasiswa` VALUES(0, '".$nama."', '".$nrp."')");
    //$result2=mysqli_query($con, "INSERT INTO `desc` VALUES(0, '".$brief."', '".$long."')");

    if($result){
      echo "Sukses";
    }
  }
?>