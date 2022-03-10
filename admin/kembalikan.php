<?php 
require '../conn/koneksi.php';

$id = $_GET["id_bukutanah"];

if (kembali($id) > 0){
	mysqli_query($conn, "UPDATE bukutanah SET status = '' WHERE id_bukutanah = '$id'");
    echo "<script>alert('Buku Tanah Sudah di Kembalikan');
	document.location.href = 'index_admin.php';
	</script>";
}else{
    echo "<script>alert('data gagal dihapus');
	document.location.href = 'tabelpengambilan.php';
	</script>";
}
?>