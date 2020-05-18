<?php
    $con=mysqli_connect("localhost","root","","tekweb");
    if(!$con)
    {
        die('Could not connect: ' . mysql_error());
    }

    $postData = file_get_contents("php://input");
    if($postData){
        $dataxml = simplexml_load_string($postData);
  
        $nrp=$dataxml->nrp;
        $id_mhs = mysqli_query($con, "SELECT id FROM mahasiswa WHERE '$nrp' = nrp");
        $id_mhs = mysqli_fetch_array($id_mhs)[0];
        $kategori_nilai=$dataxml->kategori_nilai;
        $angka=$dataxml->angka;

        $result=mysqli_query($con, "INSERT INTO `nilai` VALUES(0, ".$id_mhs.", '".$kategori_nilai."', ".$angka.")");
    }
?>