<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
    <title>DATA MAHASISWA</title>

    <script>

        function reloadTablemhs(){
            $.ajax({ //QUERY TABEL MAHASISWA
                type:"GET",
                url: "mahasiswa.php",
                data:{
                    id:0
                },
                success: function(xml){
                    $(xml).find("mhs").each(function(){
                        var nrp=$(this).find("nrp").text();
                        var nama=$(this).find("nama").text();
                        $("#tabel_mhs").append("<tr> <td><a href='#' onclick='getNilai(\""+nrp+"\")'>" + nrp + "</a></td> <td>"+nama+"</td> </tr>");
                    });
                }
            });
        }

        function getNilai(nrp) { //QUERY TABEL NILAI
            $.ajax({
                type:"GET",
                url: "nilai.php",
                data:{
                    nrp:nrp
                },
                success: function(xml){
                    var total=0,counter=0,hasil=0;
                    var str="";
                    $("#kepala").html(""); //MERESET NRP YANG ADA DI TABEL NILAI
                    $("#tabel_nilai tbody").html(""); //MERESET ISI TABEL NILAI
                    $('#kepala').append(nrp); //MEMASUKKAN NRP KE TABEL NILAI

                    $(xml).find("nilai").each(function(){
                        var id=$(this).attr("id");
                        var kategori=$(this).find("kategori").text();
                        var nilai=$(this).find("angka").text();
                         $("#tabel_nilai").append("<tr> <td>"+kategori+"</td> <td>"+nilai+"</td> </tr>"); //MENAMPILKAN SEMUA ISI TABEL NILAI BERDASARKAN NRP
                         total+=parseInt(nilai); 
                         counter+=1;
                    });
                    
                     str+="<tfoot>"; //MENAMBAH FOOTER SEBUAH TABEL
                        str+="<tr>";
                            str+="<th>Rata-Rata</th>";
                            if (counter) {
                                hasil = total/counter;
                                str+="<td class='text-center'>"+hasil.toFixed(2)+"</td>";    
                            } else {
                                str+="<td class='text-center'>"+ 0 +"</td>";
                            }
                        str+="</tr>";
                    str+="</tfoot>";
                    $("#tabel_nilai tfoot").html(""); //RESET FOOTER TABEL NILAI
                    $("#tabel_nilai").append(str);
                }
            });
        }

		$(document).ready(function(){

            reloadTablemhs(); //Memanggil isi tabel db
			$("#tambah").click(function(){
				var nama=$("#nama").val();
				var nrp=$("#nrp").val().toUpperCase(); //mengambil value input form
				$.ajax({
					type:"POST",
					url: "add.php", //memanggil query php untuk INSERT INTO DB
					data: "<data><nama>"+nama+"</nama><nrp>"+nrp+"</nrp></data>", //mengubah format inputan jadi xml
					contentType: "text/xml", //convert text to xml
					dataType: "text",
					success: function(res){ //FUNGSI KETIKA INPUT KE DATABASE SUKSES. parameter RES isinya adalah xml nama & nrp
						$("#tabel_mhs").append("<tr> <td><a href='#' onclick='getNilai(\""+nrp+"\")'>" + nrp + "</a></td> <td>"+nama+"</td> </tr>"); //menambahkan inputan ke html
					}
				});
			}); //END OF TAMBAH

            $("#tambahnilai").click(function(){ //FUNGSI TRIGGER KETIKA KLIK BUTTON TAMBAH NILAI
                var nrp=$("#nrpnilai").val().toUpperCase();
                var kategori=$("#kategori").val().toUpperCase();
                var nilai=$("#nilai").val();

                $.ajax({
                    type:"POST",
                    url: "addnilai.php",
                    data: "<data> <nrp>"+nrp+"</nrp> <kategori_nilai>"+kategori+"</kategori_nilai> <angka>"+nilai+"</angka> </data>",
                    contentType: "text/xml",
                    dataType: "text",
                    success: function(res){
                        getNilai(nrp); //REFRESH TABEL NILAI SPY INPUTAN KITA LANGSUNG MASUK KE TABEL HTML
                    }
                });
            }); //END OF TAMBAH NILAI

		}); //end of document ready
	</script>
  </head>

  <body>
    <h3 class="text-center mt-2">DATA MAHASISWA</h3>
    
    <div class="container">
        <div class="card">
            <div class="card-body">

                <div class="row">

                    <div class="col">
                        <h5><u>Add Mahasiswa</u></h5>
                        <form method="POST">
                            <div class="float-left col-md-8">
                                <div class="form-group">
                                <label for="nama">Nama :</label>
                                <input type="text" class="form-control" id="nama">
                                </div>
                                <div class="form-group">
                                <label for="nrp">NRP :</label>
                                <input type="text" id="nrp" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group">
                            <button type="button" class="btn btn-primary float-right mr-5 mt-5" style="height: 100px; width: 100px;" id="tambah" >Submit</button>
                            </div>
                        </form>
                    </div>

                    <div class="col">
                        <h5><u>Add Nilai</u></h5>
                        <form method="POST">
                            <div class="float-left col-md-8">
                                <div class="form-group">
                                <label for="nrpnilai">NRP :</label>
                                <input type="text" class="form-control" id="nrpnilai">
                                </div>
                                <div class="form-group">
                                <label for="kategori">Kategori :</label>
                                <input type="text" id="kategori" class="form-control" >
                                </div>
                                 <div class="form-group">
                                <label for="nilai">Nilai :</label>
                                <input type="number" id="nilai" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group">
                            <button type="button" class="btn btn-primary float-right mr-5 mt-5" style="height: 100px; width: 100px;" id="tambahnilai" >Submit</button>
                            </div>
                        </form>
                    </div> <!--end of col-->

                </div> <!--end of row-->
            </div>
        </div> <!--end of card--> <br>
        
        <div class="row">

            <div class="col-md-6">
                <table class="table table-bordered" id="tabel_mhs">
                    <thead>
                        <tr>
                        <th scope="col">NRP</th>
                        <th scope="col">Nama</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <div class="col-md-4 text-center">
                <table class="table table-bordered" id="tabel_nilai">
                    <thead>
                        <tr><th id="kepala" colspan='2'>NRP</th></tr>
                        <tr>
                        <th scope="col">Kategori</th>
                        <th scope="col">Nilai</th>
                        </tr>
                    </thead>
                <tbody></tbody>
                </table>
            </div>
        </div>
        

    </div>

  </body>
  
</html>