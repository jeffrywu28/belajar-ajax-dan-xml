<?php
	header('Content-Type: text/xml');
	$con=mysqli_connect("localhost","root","","tekweb");
	if(!$con)
	{
		die('Could not connect: ' . mysql_error());
	}

	$id = $_GET["id"];
	echo "<?xml version='1.0' encoding='UTF-8'?>\n";
	echo "<kuliah>";

	if($id==0){ //Select all
		$result=mysqli_query($con, "SELECT * FROM `mahasiswa`");
	}
	if(!empty($result)){ //Looping isi site
		while($row=mysqli_fetch_assoc($result)){
			echo '<mhs id="'.$row["id"].'">';
			echo '<nama>'.$row["nama"].'</nama>';
			echo '<nrp>'.$row["nrp"].'</nrp>';
			echo '<kategori_nilai>'.$row["kategori_nilai"].'</kategori_nilai>';
			echo '<angka>'.$row["nilai"].'</angka>';
			echo '</mhs>';
		}
	}
	echo "</kuliah>";
	mysqli_close($con); //boleh pake boleh ga soalnya nanti otomatis ya ketutup :D
?>