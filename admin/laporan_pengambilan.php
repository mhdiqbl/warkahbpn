<?php 
include '../conn/koneksi.php';

$filename = "Pengambilan_excel-(".date('d-m-y').").xls";

header("content-disposition: attachment; filename=$filename");
header("content-type: application/vdn.ms-excel");
?>

<h2>Laporan Buku Tanah yang Keluar</h2>

<table border="1">
	<tr>
        <thead>
                  <tr>
                          <th>ID Pengambilan</th>
                          <th>ID Petugas</th>
                          <th>ID Buku Tanah</th>
                          <th>Desa</th>
                          <th>Kecamatan</th>
                          <th>Tanggal Keluar</th>
                          <th>Kepentingan</th>
                  </tr>
        </thead>
        <tbody>
        <?php 
                    $data = query("SELECT * FROM pengambilan INNER JOIN bukutanah ON pengambilan.id_bukutanah = bukutanah.id_bukutanah INNER JOIN desa ON bukutanah.id_desa = desa.id_desa INNER JOIN kecamatan ON desa.id_kecamatan = kecamatan.id_kecamatan ");
                     ?>
	                  <?php foreach ($data as $d) : ?>
                      <tr>
                      <td><?php echo $d['id_pengambilan']?></td>
                      <td><?php echo $d['id_petugas']?></td>
                      <td><?php echo $d['id_bukutanah']?></td>
                      <td><?php echo $d['nm_desa']?></td>
                      <td><?php echo $d['nm_kecamatan']?></td>
                      <td><?php echo $d['tgl_ambil']?></td>
                      <td><?php echo $d['kepentingan']?></td>
                      <td class="text-center">
                        <div class="btn-group">
                            <a href="kembalikan.php?id_bukutanah=<?php echo $d['id_bukutanah'];?>" onclick="return confirm('YAKIN INGIN KEMBALIKAN BUKU TANAH?');" name="kembalikan" data-toggle="tooltip" data-placement="top" title="Kembalikan" class="btn btn-danger"><i class="fa fa-undo"></i></a>
                        </div>
                    </td>
                    </tr>
                    <?php endforeach; ?>
                      </tbody>
      </tr>
</table>