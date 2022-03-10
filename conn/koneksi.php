<?php

use Symfony\Component\VarDumper\VarDumper;

$conn	= mysqli_connect('localhost', 'root','', 'gudang');

function query($query) {
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];
	while ($row = mysqli_fetch_assoc($result)) {
		$rows[] = $row;
	}
	return $rows;
}

function showtables(){
	global $conn;
	$table = mysqli_query($conn,"SELECT * FROM bukutanah INNER JOIN desa ON bukutanah.id_desa = desa.id_desa INNER JOIN kecamatan ON desa.id_kecamatan = kecamatan.id_kecamatan");
	return $table;
}

function hapus($id){
	global $conn;
	mysqli_query($conn, "DELETE FROM bukutanah WHERE id_bukutanah = '$id'");
	return mysqli_affected_rows($conn);
}

function hapus_pegawai($id){
	global $conn;
	
	$data = mysqli_query($conn, "SELECT * FROM pegawai WHERE id_pegawai = '$id'");
	$u = mysqli_fetch_assoc($data);
	//menghapus gambar pada directory komputer
	unlink('../images/pegawai/'.$u['gambar']); 
	mysqli_query($conn, "DELETE FROM pegawai WHERE id_pegawai = '$id'");
	return mysqli_affected_rows($conn);
}

function kembali($id){
	global $conn;
	mysqli_query($conn, "DELETE FROM pengambilan WHERE id_bukutanah='$id'");
	return mysqli_affected_rows($conn);
}

function tambah($data){
	global $conn;

	// ambil data dari tiap elemen dalam form
	$id_bukutanah = $data["id_bukutanah"];
	$id_hak = $data["id_hak"];
	// $id_kecamatan = $data["id_kecamatan"];
	$id_desa = $data["id_desa"];
	$a = $id_hak.$id_bukutanah;

	// query insert data
	$query = "INSERT INTO bukutanah VALUES ('$a','$id_hak','$id_desa','')";
	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);

}

function ambil($data){
	global $conn;

	// ambil data dari tiap elemen dalam form
	$id_petugas = $data["id_petugas"];
	$id_pegawai = $data["id_pegawai"];
	$id_bukutanah = $data["id_bukutanah"];
	$tgl_ambil = $data["tgl_ambil"];
	$kepentingan = $data["kepentingan"];

	// cek apakah sudah di pinjam
	$ambil = $conn->query("SELECT * FROM pengambilan WHERE id_bukutanah='$id_bukutanah'");
	$yangcocok = $ambil->num_rows;
	if ($yangcocok==0){
	// query insert data
	$query = "INSERT INTO pengambilan VALUES
	('','$id_petugas','$id_pegawai','$id_bukutanah','$tgl_ambil','$kepentingan')";
	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
	}
}

function ubah($data){
	global $conn;

	// ambil data dari tiap elemen dalam form
	$id_bukutanah = $data["id_bukutanah"];
	$id_hak = $data["id_hak"];
	$id_desa = $data["id_desa"];
	$a = $data["kd"];

	// query insert data
	$query =  "UPDATE bukutanah SET
		id_hak = '$id_hak',
		id_desa = '$id_desa',
		id_bukutanah = '$id_bukutanah'
	WHERE id_bukutanah = '$a'
	";
	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}

// function cari($keyword){
// 	$query = "SELECT * FROM bukutanah WHERE 
// 	id_hak LIKE '%$keyword%' OR 
// 	id_desa LIKE '%$keyword%' OR 
// 	id_kecamatan LIKE '%$keyword%' OR 
// 	id_bukutanah LIKE '%$keyword%'
// 	";
// 	return query($query);
// }

function update($data){
	global $conn;
	
	$id_petugas = strtolower(stripcslashes($data["id_petugas"]));
	$nama = htmlspecialchars($data["nama"]);
	$jk = htmlspecialchars($data["jk"]);
	$email = htmlspecialchars($data["email"]);
	$no_tlp = htmlspecialchars($data["no_tlp"]);	
	$alamat = htmlspecialchars($data["alamat"]);	
	$tp_lahir = htmlspecialchars($data["tp_lahir"]);	
	$tgl_lahir = htmlspecialchars($data["tgl_lahir"]);
	$gambarlama = htmlspecialchars($data["gambarLama"]);

	if ($_FILES['gambar']['error']===4) {
		$gambar = $gambarlama;
	}else{
		$gambar = upload();	
	}

	$query = "UPDATE petugas SET  
	id_petugas = '$id_petugas',
	nama = '$nama',
	jk = '$jk',
	email = '$email',
	no_tlp = '$no_tlp',
	alamat = '$alamat',
	tp_lahir = '$tp_lahir',
	tgl_lahir = '$tgl_lahir',
	gambar = '$gambar'
	WHERE id_petugas = '$id_petugas'
	";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function ubah_password($id){
	global $conn;
	$id_petugas = $id["id_petugas"];
	$password = $id["passwordlama"];
	$passwordbaru = $id["passwordbaru"];
	$passwordbaru2 = $id["passwordbaru2"];
	$result = mysqli_query($conn, "SELECT * FROM petugas WHERE id_petugas ='$id_petugas'");
	$row = mysqli_fetch_assoc($result);
	// cek konfirmasi password
	if ($passwordbaru !== $passwordbaru2 ) {
		echo "<script>alert('Password baru tidak sesuai')</script>";
		return false;
	}

	if (password_verify($password, $row["passwords"])) {
	// enkripsi password
	$passwordbaru = password_hash($passwordbaru, PASSWORD_DEFAULT);

	// tambahkan userbaru ke database
	$query = "UPDATE petugas SET 
	passwords = '$passwordbaru'
	WHERE id_petugas = '$id_petugas'
	";

	mysqli_query($conn, $query);
	}
	return mysqli_affected_rows($conn);
}

function registrasi($data){
	global $conn;

	$id_petugas = strtolower(stripcslashes($data["id_petugas"]));
	$nama = htmlspecialchars($data["nama"]);
	$jk = htmlspecialchars($data["jk"]);
	$email = htmlspecialchars($data["email"]);
	$no_tlp = htmlspecialchars($data["no_tlp"]);	
	$alamat = htmlspecialchars($data["alamat"]);	
	$tp_lahir = htmlspecialchars($data["tp_lahir"]);	
	$tgl_lahir = htmlspecialchars($data["tgl_lahir"]);	
	$password = mysqli_real_escape_string($conn,$data["password"]);
	$password2 = mysqli_real_escape_string($conn,$data["password2"]);

	$gambar = upload();
	if (!$gambar) {
		return false;
	}

	//cek username sudah ada atau belum
	$result = mysqli_query($conn, "SELECT id_petugas FROM petugas WHERE id_petugas ='$id_petugas'");
	if (mysqli_fetch_assoc($result)) {
		echo "<script> alert('username sudah terdaftar');</script>";
		return false;
	}

	// cek konfirmasi password
	if ($password !== $password2) {
		echo "<script>alert('password tidak sesuai')</script>";
		return false;
	}

	// enkripsi password
	$password = password_hash($password, PASSWORD_DEFAULT);

	// tambahkan userbaru ke database
	mysqli_query($conn, "INSERT INTO petugas VALUES('$id_petugas','$nama','$jk','$email','$no_tlp','$alamat','$tp_lahir','$tgl_lahir','$gambar','$password')");

	return mysqli_affected_rows($conn);
}

function upload(){
	$namafile = $_FILES['gambar']['name'];
	$ukuranfile = $_FILES['gambar']['size'];
	$error = $_FILES['gambar']['error'];
	$tmpName = $_FILES['gambar']['tmp_name'];

	// cek apakah ada gambar yg di uplod
	if ($error === 4) {
		echo "<script> alert('pilih gambar terlebih dahulu'); </script>";
		return false;
	}

	// cek apakah yg diupload adalah gambar
	$ekstensiGambarvalid = ['jpg', 'jpeg', 'png'];
	$ekstensiGambar = explode('.', $namafile);
	$ekstensiGambar = strtolower(end($ekstensiGambar));
	if (in_array($ekstensiGambar, $ekstensiGambarvalid)) {
		"<script> alert('yang anda upload bukan gambar!'); </script>";
	}

	// jika ukuran terlalu besar
	if ($ukuranfile > 2000000) {
		echo "<script> alert('ukuran terlalu besar'); </script>";
	}

	// gambar siap di upload
	// generate nama gambar baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= ".";
	$namaFileBaru .= $ekstensiGambar;

	move_uploaded_file($tmpName, 'images/'.$namaFileBaru);

	return $namaFileBaru;
}

function upload_pegawai(){
	$namafile = $_FILES['gambar']['name'];
	$ukuranfile = $_FILES['gambar']['size'];
	$error = $_FILES['gambar']['error'];
	$tmpName = $_FILES['gambar']['tmp_name'];

	// cek apakah ada gambar yg di uplod
	if ($error === 4) {
		echo "<script> alert('pilih gambar terlebih dahulu'); </script>";
		return false;
	}

	// cek apakah yg diupload adalah gambar
	$ekstensiGambarvalid = ['jpg', 'jpeg', 'png'];
	$ekstensiGambar = explode('.', $namafile);
	$ekstensiGambar = strtolower(end($ekstensiGambar));
	if (in_array($ekstensiGambar, $ekstensiGambarvalid)) {
		"<script> alert('yang anda upload bukan gambar!'); </script>";
	}

	// jika ukuran terlalu besar
	if ($ukuranfile > 2000000) {
		echo "<script> alert('ukuran terlalu besar'); </script>";
	}

	// gambar siap di upload
	// generate nama gambar baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= ".";
	$namaFileBaru .= $ekstensiGambar;

	move_uploaded_file($tmpName, '../images/pegawai/'.$namaFileBaru);

	return $namaFileBaru;
}

function tambah_pegawai($data){
	global $conn;

	$id_pegawai = strtolower(stripcslashes($data["id_pegawai"]));
	$nm_pegawai = htmlspecialchars($data["nm_pegawai"]);
	$jk = htmlspecialchars($data["jk"]);
	$email = htmlspecialchars($data["email"]);
	$no_tlp = htmlspecialchars($data["no_tlp"]);	
	$alamat = htmlspecialchars($data["alamat"]);	
	$tp_lahir = htmlspecialchars($data["tp_lahir"]);	
	$tgl_lahir = htmlspecialchars($data["tgl_lahir"]);

	$gambar = upload_pegawai();
	if (!$gambar) {
		return false;
	}

	//cek username sudah ada atau belum
	$result = mysqli_query($conn, "SELECT id_pegawai FROM pegawai WHERE id_pegawai ='$id_pegawai'");
	if (mysqli_fetch_assoc($result)) {
		echo "<script> alert('ID sudah terdaftar');</script>";
		return false;
	}

	// tambahkan userbaru ke database
	mysqli_query($conn, "INSERT INTO pegawai VALUES('$id_pegawai','$nm_pegawai','$jk','$email','$no_tlp','$alamat','$tp_lahir','$tgl_lahir','$gambar')");

	return mysqli_affected_rows($conn);
}

function update_pegawai($data){
	global $conn;
	
	$id_pegawai = strtolower(stripcslashes($data["id_pegawai"]));
	$nm_pegawai = htmlspecialchars($data["nm_pegawai"]);
	$jk = htmlspecialchars($data["jk"]);
	$email = htmlspecialchars($data["email"]);
	$no_tlp = htmlspecialchars($data["no_tlp"]);	
	$alamat = htmlspecialchars($data["alamat"]);	
	$tp_lahir = htmlspecialchars($data["tp_lahir"]);	
	$tgl_lahir = htmlspecialchars($data["tgl_lahir"]);
	$gambarlama = htmlspecialchars($data["gambarLama"]);

	if ($_FILES['gambar']['error']===4) {
		$gambar = $gambarlama;
	}else{
		$gambar = upload_pegawai();	
	}

	$query = "UPDATE pegawai SET  
	id_pegawai = '$id_pegawai',
	nm_pegawai = '$nm_pegawai',
	jk = '$jk',
	email = '$email',
	no_tlp = '$no_tlp',
	alamat = '$alamat',
	tp_lahir = '$tp_lahir',
	tgl_lahir = '$tgl_lahir',
	gambar = '$gambar'
	WHERE id_pegawai = '$id_pegawai'
	";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}
 ?>