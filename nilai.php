<?php
    $con=mysqli_connect("localhost","root","","tekweb");
    if(!$con)
    {
        die('Could not connect: ' . mysql_error());
    }

    header('Content-Type: text/xml');
    $nrp = $_GET["nrp"];
    echo "<?xml version='1.0' encoding='UTF-8'?>\n";

    echo "<daftarnilai>";
    $id_mhs = mysqli_query($con, "SELECT id FROM `mahasiswa` WHERE '$nrp' = nrp");
    $id_mhs = mysqli_fetch_array($id_mhs)[0];

    $result=mysqli_query($con, "SELECT * FROM `nilai` WHERE '$id_mhs' = id_mhs");

    if (!empty($result)) {
        while($row=mysqli_fetch_assoc($result)){
			echo '<nilai id="'.$row["id"].'">';
			echo '<id_mahasiswa>'.$row["id_mhs"].'</id_mahasiswa>';
            echo '<kategori>'.$row["kategori_nilai"].'</kategori>';
            echo '<angka>'.$row["nilai"].'</angka>';
			echo '</nilai>';
		}
    }
    echo "</daftarnilai>";
	mysqli_close($con);
?>