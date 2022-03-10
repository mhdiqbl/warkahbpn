<?php 
require '../conn/koneksi.php';

$id = $_GET["id_bukutanah"];

if (hapus($id) > 0){
    echo "<script>alert('data berhasil dihapus');
		document.location.href = 'index_admin.php';
		</script>";
	}else{	
    echo "<script>alert('data gagal dihapus');
		document.location.href = 'tabelbukutanah.php';
		</script>";
}

?>