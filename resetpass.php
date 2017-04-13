<?php
	session_start();
	require ('koneksi.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Reset Password Form</title>
	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.css"/>
    <link rel="icon" href="images/logo-sc-blue.png" sizes="32x32">
    <script src="js/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/sweetalert.css">
    <style type="text/css">
    	body{
			margin: 0 auto;
			background-image: url("images/bgs.png");
			background-repeat: no-repeat;
			background-size: 100% 720px;
		}
		.container{
			text-align: center;
			background-color: rgba(215, 240, 244,0.7);
			border-radius: 10px;
			margin: 50px;
			margin-top: 100px;
			margin-left: 27%;
			width: 600px;
			height: 200px;
		}
		h1{
			margin-top: 30px;
			color: white;
			text-align: center;
			font-size: 50px;
		}
    </style>
</head>
<body>
	<h1>Forgot Password</h1>
	<div class="container">
		<form action="resetpass.php" method="post">
				<br>
			      <div style="margin-top: 0px; margin-left: 80px;" class="row">
			        <div class="input-field col s9" style="margin-top: 30px;">
			          <i class="material-icons prefix">mail</i>
			          <input name="email" id="icon_prefix" type="email" class="validate" required>
			          <label for="icon_prefix">Email</label>
			        </div>
			       </div>
			        	<a href="login.php"><button style="margin-top: -10px; margin-left: 0px;" type="button" id="login_btn" name="register" class="btn tooltipped btn-floating btn-large waves-effect waves-light red" data-delay="0" data-position="top" data-tooltip="Back"><i class="material-icons">reply
            				</i></button></a>
			            <button style="margin-top: -10px; margin-left: 450px;" type="submit" id="register_btn" name="reset" class="btn tooltipped btn-floating btn-large waves-effect waves-light light-blue lighten-1" data-delay="0" data-position="top" data-tooltip="Next"><i class="material-icons">send
            				</i></button>
		</form>
	</div>
	<?php
		if (isset($_POST['reset'])) {
		$pass="1A2B4HTjsk5kwhadbwlff"; $panjang='8'; $len=strlen($pass); 
		$start=$len-$panjang; $xx=rand('0',$start); 
		$yy=str_shuffle($pass); 
		$passwordbaru=substr($yy, $xx, $panjang);
		 
		$email = $_POST['email'];
		$password = md5($passwordbaru);
		 
		// mencari alamat email si user
		$query = "SELECT * FROM user WHERE email ='$email'";
		$hasil = $con->prepare($query);
		$hasil->execute();
		$data = $hasil->fetch();
		$cek = $hasil->rowCount();
		$id_member = $data['uid'];
		$alamatEmail = $data['email'];
		$nama = $data['fullname'];
		$username = $data['username'];
		if ($cek == 1) {
		// title atau subject email
			ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL); date_default_timezone_set('Etc/UTC'); /*autoload phpmailer*/ require 'PHPMailerAutoload.php'; $mail = new PHPMailer; $mail->isSMTP();
 
			/*dipakai debugging,
			 * 0 = off (for production use)
			 * 1 = client messages
			 * 2 = client and server messages
			 * */
			$mail->SMTPDebug = 0;
			$mail->Debugoutput = 'html';
			$mail->Host = 'smtp.gmail.com'; 
			/**jika kebetulan network SMTP di block lewat IPv6 maka gunakan kode ini
			 * $mail->Host = gethostbyname('smtp.gmail.com');
			 * */
			$mail->Port = 587; //ini adalah port default mbah google
			$mail->SMTPSecure = 'tls'; //security pakai ssl atau tls, tapi ssl telah deprecated
			$mail->SMTPAuth = true; //menandakan butuh authentifikasi
			$mail->Username = "m.hilmy007@gmail.com";//email anda
			$mail->Password = "jak081806493014"; //password anda, silakan diganti
			$mail->setFrom('m.hilmy007@gmail.com', 'SmartCounter');
			$mail->addAddress($alamatEmail, $nama);
			$mail->Subject = 'New Password';
			//$mail->AddAttachment("module.txt"); // attachment
			$mail->msgHTML("Your new password = ".$passwordbaru, "");
			if (!$mail->send()) {
			    echo"<script>
						swal('Failed', 'Email was not sent!', 'error');
					</script>";
			} else {
				$query = "UPDATE user SET password='$password' WHERE uid = '".$id_member."'";
				$hasil = $con->prepare($query);
				$hasil->execute();
			    echo '<script>
                    swal({
                      title: "Success",
                      text: "Your password has been sent to your email!",
                      type: "success",
                      confirmButtonColor: "#8cd4f5",
                      confirmButtonText: "OK",
                      },
                      function(isConfirm){
                        if (isConfirm) {
                          window.location.assign("login.php");
                        }
                      });
                  </script>';
			}
		}
		else{
		 
		echo"<script>
				swal('Failed', 'Email not found!', 'error');
			</script>";
		}
	}
	?>
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
      <script type="text/javascript" src="js/materialize.min.js"></script>
</body>
</html>