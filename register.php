<?php
	require ('koneksi.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Register Form</title>
	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.css"/>
    <link rel="icon" href="img/bbgfix.png" sizes="32x32">
    <script src="js/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/sweetalert.css">
    <style type="text/css">
    	body{
			margin: 0 auto;
			background-image: url("images/bg-log.png");
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
			height: 400px;
		}
		.container img{
			width: 120px;
			height: 120px;
			margin-top: -60px;
			margin-bottom: 30px;
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
	<h1>Register Page</h1>
	<div class="container">
	    <img class="circle responsive-img" src="images/user.png">
		<form action="register.php" method="post">
		    <div style="margin-top: -10px; margin-left: 80px;" class="row">
		    	<div class="input-field col s9">
			   		<i class="material-icons prefix">picture_in_picture</i>
			        <input id="icon_prefix" type="text" class="validate" name="fullname" required>
			        <label for="icon_prefix">Full Name</label>
			    </div>
			</div>
			<div style="margin-top: -20px; margin-left: 80px;" class="row">
			    <div class="input-field col s9">
					<i class="material-icons prefix">account_circle</i>
			        <input id="icon_prefix" type="text" class="validate" name="username" required>
			        <label for="icon_prefix">Username</label>
			    </div>
			</div>
			<div style="margin-top: -20px; margin-left: 80px;" class="row">
				<div class="input-field col s9">
				    <i class="material-icons prefix">lock</i>
			        <input id="icon_prefix" type="password" class="validate" name="password" required>
				    <label for="icon_prefix">Password</label>
			    </div>
			</div>
			<div style="margin-top: -15px; margin-left: -10px;" class="row">
			    <a href="login.php" id="back_btn" class="btn tooltipped btn-floating btn-large waves-effect waves-light red" data-delay="0" data-position="top" data-tooltip="Back">
			    	<i class="material-icons">reply</i>
			    </a>
			  	<button type="submit" id="signup_btn" name="submit_btn" style="margin-left: 450px;" class="btn tooltipped btn-floating btn-large waves-effect waves-light light-blue lighten-1" data-delay="0" data-position="top" data-tooltip="Register">
			  		<i class="material-icons">send</i>
			    </button>
			</div>
		</form>
		<?php
			if(isset($_POST['submit_btn']))
			{
				$fullname = $_POST['fullname'];
				$username = $_POST['username'];
				$password = $_POST['password'];
				$upic = "user.png";

				$insert = $con->prepare("SELECT * FROM user WHERE username = '".$username."'");
				$insert->execute();
				$count = $insert->rowCount();
				if($count == 1){
					echo "<script>
				    			swal('Failed', 'Username already exists!', 'error');
				    		</script>";
				}
				else{
					$insert = $con->prepare("INSERT INTO user (fullname,username,password,pic) values (:fullname,:username,:password,:upic)");
					$insert->bindParam(':fullname', $fullname);
					$insert->bindParam(':username', $username);
					$insert->bindParam(':password', $password);
					$insert->bindParam(':upic', $upic);
					$insert->execute();
					header("location:login.php");
				}
			}
		?>
	</div>
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
      <script type="text/javascript" src="js/materialize.min.js"></script>
</body>
</html>