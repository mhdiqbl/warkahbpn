<?php 
session_start();
$nama = $_SESSION['nama'];
$id = $_SESSION['id'];
if (!isset($_SESSION['login'])) {
  header("Location: ../index.php");
  exit;
}

require '../conn/koneksi.php';
// $buku = query("SELECT * FROM bukutanah INNER JOIN kecamatan ON bukutanah.id_kecamatan = kecamatan.id_kecamatan INNER JOIN desa ON bukutanah.id_desa = desa.id_desa");

$result = mysqli_query($conn, "SELECT * FROM petugas WHERE id_petugas = '$id'");
if (mysqli_num_rows($result)===1) {
  $row = mysqli_fetch_assoc($result);
}

// if (isset($_POST["cari"])) {
//   $buku = cari($_POST);
//  }

if (isset($_POST["tambah"])) {
  //cek lakukan pencarian
  if (tambah($_POST) > 0) {
		echo "<script>alert('data berhasil');
		document.location.href = 'index_admin.php';
		</script>";
	}else{
		echo "<script>alert('data gagal');
		document.location.href = 'index_admin.php';
		</script>";
  }
}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title>SISTEM WARKAH BPN ACEH UTARA</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
	
    <!-- bootstrap-progressbar -->
    <link href="../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="../vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    
    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="nav-md ">
    <div class="container body footer_fixed">
      <div class="main_container">
        <div class="col-md-3 left_col menu_fixed">
          <div class="left_col scroll-view">
            <div class="text-center nav_title profile" style="border: 0;">
            <a href="index_admin.html" class="site_title"><img src="../images/bpn.png" width="50"></a>
              <h2 class="text-center">SISTEM WARKAH</h2>
              <h6 class="text-center">BPN ACEH UTARA</h6>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="text-center">
                
              </div>
              
            </div>
            <!-- /menu profile quick info -->

            <!-- sidebar menu -->
            <?php 
            include 'asset/sidebar.php';
            ?>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <!-- <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="logout_admin.php">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div> -->
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <?php 
            include 'asset/topnav.php';
        ?>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
				<div class="">
					<div class="page-title">
						

					</div>
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 col-sm-12 ">
							<div class="x_panel">
								<div class="x_title">
									<h2>Entri Buku Tanah <small></small></h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
										</li>
									</ul>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<br>
									<form method="POST" action="" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
										<div class="item form-group">
                      <label class="col-form-label col-md-2 col-sm-3 label-align" for="cari_hak">Kode Buku Tanah</label>
                        <input class="form-control col-3" name="id_bukutanah">

											<label class="col-form-label col-md-2 col-sm-3 label-align" for="kode_hak">Tipe Hak</label>
                        <input class="form-control col-3" name="id_hak" list="hak" placeholder="Tipe Hak...">
                        <datalist name="id_hak" id="hak">
                          <?php
                            $hak = query("SELECT * FROM hak");
                          ?>
                            <?php foreach ($hak as $d) : ?>
                            <option value="<?= $d['id_hak']?>"><?= $d['nm_hak']?></option>
                            <?php endforeach; ?>
                        </datalist>

                    </div>	
                    <br>
                    <div class="item form-group">
											<!-- <label class="col-form-label col-md-2 col-sm-3 label-align" for="id_kecamatan">Kecamatan</label>
                        <input class="form-control col-3" name="id_kecamatan" list="camat" placeholder="Kecamatan...">
                        <datalist id="camat" name="id_kecamatan">
                          <?php
                            $camat = query("SELECT * FROM kecamatan");
                          ?>
                            <?php foreach ($camat as $cmt) : ?>
                            <option value="<?= $cmt['id_kecamatan']?>"> <?= $cmt['nm_kecamatan']?> </option>
                            <?php endforeach; ?>
                        </datalist> -->

                        <label class="col-form-label col-md-2 col-sm-3 label-align" for="id_desa">Desa</label>
                        <input class="form-control col-3" name="id_desa" list="desa" placeholder="Desa...">
                        <datalist name="id_desa" id="desa">
                          <?php
                            $desa = query("SELECT * FROM desa");
                          ?>
                            <?php foreach ($desa as $ds) : ?>
                            <option value="<?= $ds['id_desa']?>"> <?= $ds['nm_desa']?></option>
                            <?php endforeach; ?>
                        </datalist>
                    </div>
                    <br>
                    <div class="ln_solid"></div>
                    <div class="item form-group mt-4">
                      <div class="col-md-3 offset-md-5">
                            <!-- <button type="submit" data-toggle="tooltip" data-placement="top" name="cari" title="Cari" class="btn btn-warning"><i class="fa fa-search"> Cari</i></button> -->
                            <button type="submit" data-toggle="tooltip" data-placement="top" name="tambah" title="Tambah" class="btn btn-info"><i class="fa fa-plus-square"> Tambah</i>
                            <!-- <button type="button" data-toggle="tooltip" data-placement="top" title="Tambah" class="btn btn-info"><a href="hapus.php?id_bukutanah=<?php echo $d['id_bukutanah'];?>"><i class="fa fa-edit"> Hapus</a></i> -->
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 col-sm-12 ">
							<div class="x_panel">
								<div class="x_title">
                  <h2>Informasi Buku Tanah</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <div class="row">
                          <div class="col-sm-12">
                            <div class="card-box table-responsive">
                    <p class="text-muted font-13 m-b-30">
                      
                    </p>
                    <table id="datatable-checkbox" class="table table-striped table-bordered bulk_action" style="width:100%">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Kode Buku Tanah</th>
                          <th>Tipe Hak</th>
                          <th>Nama Desa</th>
                          <th>Nama Kecamatan</th>
                          <th>Status</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>
                </div>
              </div>
            </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
        </div>
      </div>
    </div>
               
          
        
        <!-- /page content -->

        <!-- footer content -->
        <?php 
        include 'asset/footer.php';
        ?>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="../vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="../vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="../vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="../vendors/Flot/jquery.flot.js"></script>
    <script src="../vendors/Flot/jquery.flot.pie.js"></script>
    <script src="../vendors/Flot/jquery.flot.time.js"></script>
    <script src="../vendors/Flot/jquery.flot.stack.js"></script>
    <script src="../vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="../vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="../vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="../vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="../vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="../vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="../vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="../vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="../vendors/moment/min/moment.min.js"></script>
    <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- Datatables -->
    <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
	
  </body>
</html>