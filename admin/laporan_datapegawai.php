<?php 
include '../conn/koneksi.php';

$filename = "Data Pegawai-(".date('d-m-y').").xls";

header("content-disposition: attachment; filename=$filename");
header("content-type: application/vdn.ms-excel");
?>

<h2>Data Pegawai Kantor BPN Aceh Utara</h2>

<table border="1">
        <thead>
                  <tr>
                    <th>No</th>
                    <th>ID Pegawai</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Email</th>
                    <th>No Telepon</th>
                    <th>Alamat</th>
                    <th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>
                  </tr>
        </thead>
        <tbody>
        <?php 
        $data = query("SELECT * FROM pegawai");
        $no = 1; ?>
            <?php foreach ($data as $d) : ?>
        <tr>
            <td><?php echo $no++?></td>
            <td><?php echo $d['id_pegawai']?></td>
            <td><?php echo $d['nm_pegawai']?></td>
            <td><?php echo $d['jk']?></td>
            <td><?php echo $d['email']?></td>
            <td><?php echo $d['no_tlp']?></td>
            <td><?php echo $d['alamat']?></td>
            <td><?php echo $d['tp_lahir']?></td>
            <td><?php echo $d['tgl_lahir']?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
</table>