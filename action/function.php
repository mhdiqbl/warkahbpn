<?php
include '../conn/koneksi.php';
session_start();
    //jika tombol login ditekan
    if (isset ($_POST["login"])) 
    {
        $id_petugas = $_POST["id_petugas"];
        $password= $_POST["password"];

        //lakukan query untuk ngecheck akun yang ada di tabel pelanggan yang berada di database
        $ambil = $koneksi->query("SELECT * FROM petugas WHERE id_petugas = '$id_petugas' AND password ='$password'");

        //ngitung akun yang terambil
        $akunyangcocok = $ambil->num_rows;

        //jika 1 akun yang cocok,maka diloginkan
        if ($akunyangcocok==1) 
        {
            //anda sukses login
            //mendapatan akun dalam bentuk array
            $akun = $ambil->fetch_assoc();
            
            //simpan di session admin
            // if ($akun['hak']=="admin") {
            // $_SESSION['id_petugas'] = $id_petugas;
            // $_SESSION['hak'] = "admin";
            $_SESSION['login'] = true;
            echo "<script>alert('SELAMAT DATANG');</script>";
            echo "<script>location='../admin/index_admin.php';</script>";

            //simpan di session user
            // if ($akun['status']=="1") {
            // $_SESSION['id_pegawai'] = $id_pegawai;
            // $_SESSION['hak'] = "user";
            // $_SESSION['login'] = true;
            // echo "<script>alert('ANDA LOGIN SEBAGAI ADMIN');</script>";
            // echo "<script>location='../admin/index_admin.php';</script>";
            }
    }
            //anda gagal login
            echo "<script>alert('FAILED LOGIN');</script>";
            echo "<script>location='../index.php';</script>";
     ?>