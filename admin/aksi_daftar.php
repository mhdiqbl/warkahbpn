<?php
include '../conn/koneksi.php';

  if (isset($_POST["daftar"]))
  {
$id_petugas     = $_POST["id_petugas"];
$nama           = $_POST["nama"];
$jk             = $_POST["jk"];
$email          = $_POST["email"];
$no_tlp         = $_POST["no_tlp"];
$alamat         = $_POST["alamat"];
$tp_lahir       = $_POST["tp_lahir"];
$tgl_lahir      = $_POST["tgl_lahir"];
$password       = $_POST["password"];

//enkripsi password
  // $password = password_hash($password, PASSWORD_DEFAULT);

//cek apakah email sudah digunakan
$ambil = $conn->query("SELECT * FROM petugas WHERE id_petugas='$id_petugas'");
$yangcocok = $ambil->num_rows;
if ($yangcocok==1){
  echo "<script>alert('Penambahan gagal, ID sudah digunakan');</script>";
  echo "<script>location='../index.php';</script>";
}else{
  //menginput data ke database
$conn->query("INSERT INTO petugas VALUES('$id_petugas','$nama','$jk','$email','$no_hp','$alamat','$tp_lahir','$tgl_lahir','$password')");
echo "<script>alert('Pendaftaran Sukses Silahkan Login');</script>";
echo "<script>location='../index.php';</script>";
}
}
?>