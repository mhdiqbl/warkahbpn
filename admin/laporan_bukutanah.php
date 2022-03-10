<?php 
include '../conn/koneksi.php';

$filename = "BukuTanah_excel-(".date('d-m-y').").xls";

header("content-disposition: attachment; filename=$filename");
header("content-type: application/vdn.ms-excel");
?>

<h2>Entri Buku Tanah</h2>

<table border="1">
        <thead>
                  <tr>
                    <th>No</th>
                          <th>Kode Buku Tanah</th>
                          <th>Tipe Hak</th>
                          <th>Nama Desa</th>
                          <th>Nama Kecamatan</th>
                  </tr>
        </thead>
        <tbody>
        <?php 
                    $data = showtables();
                    $no = 1; ?>
	                  <?php foreach ($data as $d) : ?>
                      <tr>
                      <td><?php echo $no++?></td>
                      <td><?php echo $d['id_bukutanah']?></td>
                      <td><?php echo $d['id_hak']?></td>
                      <td><?php echo $d['nm_desa']?></td>
                      <td><?php echo $d['nm_kecamatan']?></td>
                  
                  </tr>
                  <?php endforeach; ?>
                    </tbody>
</table>