<?php
session_start();
require 'conn/koneksi.php';

if (isset($_POST["login"])) {
    $id_petugas = $_POST["id_petugas"];
    $password = $_POST["password"];
    
    $result = mysqli_query($conn, "SELECT * FROM petugas WHERE id_petugas = '$id_petugas'");

    //cek username
	if (mysqli_num_rows($result)===1) {
		
		//cek password
		$row = mysqli_fetch_assoc($result);
            
        if (password_verify($password, $row["passwords"])){
			// set session
            $_SESSION['id'] = $row['id_petugas'];
            $_SESSION['nama'] = $row['nama'];
			$_SESSION['login'] = true;
			header("Location: admin/index_admin.php");
			exit;
        }    
    }
    $error = true;
}

if (isset($_POST['daftar'])) {
	if (registrasi($_POST) > 0) {
		echo "<script>alert('user baru berhasil')
		</script>";
	}else{
		echo mysqli_error($conn);
	}
}

if (isset($_SESSION["login"])) {
	header("Location: admin/index_admin.php");
	exit;
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

        <title>SISTEM WARKAH BPN ACEH UTARA</title>

        <!-- Bootstrap -->
        <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- NProgress -->
        <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
        <!-- Animate.css -->
        <link href="vendors/animate.css/animate.min.css" rel="stylesheet">

        <!-- Custom Theme Style -->
        <link href="build/css/custom.min.css" rel="stylesheet">
    </head>

    <body class="login">
        <?php if (isset($error)):?>
            <p style="color: red;">username/password salah</p>
        <?php endif; ?>
        <div>
            <a class="hiddenanchor" id="signup"></a>
            <a class="hiddenanchor" id="signin"></a>

            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content">
                        <form action="" method="POST">
                            <h1>Login Form</h1>
                            <div>
                                <input type="text" name="id_petugas" class="form-control" placeholder="Username" required="" maxlength="10" />
                            </div>
                            <div>
                                <input type="password" name="password" class="form-control" placeholder="Password" required="" maxlength="10"/>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary submit" name="login">Log in</button>
                            </div>

                            <div class="clearfix"></div>

                            <div class="separator">
                                <p class="change_link">New to site?
                                    <a href="#signup" class="to_register"> Create Account </a>
                                </p>
                                <div class="clearfix"></div>
                                <br>

                                <div>
                                    <h1><img src="images/bpn.png" width=50> </i>Warkah BPN Aceh Utara!</h1>
                                    <p>©2021 Aceh Utara
                                    </p>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>

                <div id="register" class="animate form registration_form">
                    <section class="login_content">
                        <form method="POST" action="" enctype="multipart/form-data">
                            <h1>Create Account</h1>
                            <div class="form-group">
                                <input type="text" class="form-control" name="id_petugas" placeholder="Username" required="" />
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="nama" placeholder="Nama" required="@">
                            </div>
                            <div class="form-group">
                                <select name="jk" class="form-control">
                                    <option value="Laki-Laki">Laki-Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group" style="margin-top: 20px;">
                                <input type="email" class="form-control" name="email" placeholder="Email" required="">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="no_tlp" placeholder="No Telepon" required="">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="alamat" placeholder="Alamat" required="">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="tp_lahir" placeholder="Tempat Lahir" required="">
                            </div>
                            <div class="form-group">
                                <input type="date" class="form-control" name="tgl_lahir" placeholder="Tempat Lahir" required="">
                            </div>
                            <div class="form-group" style="margin-top: 20px;">
                                <input type="password" class="form-control" name="password" placeholder="Password" required="">
                            </div>
                            <div class="form-group" style="margin-top: 20px;">
                                <input type="password" class="form-control" name="password2" placeholder="Masukkan ulang password" required="">
                            </div>
                           <div class="item form-group">
							<label class="col-form-label col-md-5 col-sm-3 label-align">Upload Foto Profile</label>
                            <div class="col-md-2 col-sm-6">
                            <input type="file" name="gambar">
                            </div>
                           </div>
                            <div class="form-group" style="margin-top: 50px;">
                                <button type="submit" class="btn btn-primary submit" name="daftar">Daftar</button>
                            </div>
                            



                            <div class="separator">
                                <p class="change_link">Already a member ?
                                    <a href="#signin" class="to_register"> Log in </a>
                                </p>

                                <div class="clearfix"></div>
                                <br />

                                <div>
                                    <h1><img src="images/bpn.png" width=50> </i>Warkah BPN Aceh Utara!</h1>
                                    <p>©2021 Aceh Utara</p>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </body>

    </html>