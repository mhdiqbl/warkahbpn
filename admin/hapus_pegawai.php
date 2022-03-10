<?php 
require '../conn/koneksi.php';

$id = $_GET["id_pegawai"];

if (hapus_pegawai($id) > 0){
    echo "<script>alert('Data pegawai berhasil dihapus');
		document.location.href = 'tabelpegawai.php';
		</script>";
	}else{	
    echo "<script>alert('Data gagal dihapus');
		document.location.href = 'tabelpegawai.php';
		</script>";
}

?>