<?php
	session_start();
	require ('koneksi.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login Form</title>
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
			height: 350px;
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
	<h1>Login Page</h1>
	<div class="container">
	       <img class="circle responsive-img" src="images/user.png">
		<form action="login.php" method="post">
			      <div style="margin-top: -10px; margin-left: 80px;" class="row">
			        <div class="input-field col s9">
			          <i class="material-icons prefix">account_circle</i>
			          <input name="un" id="icon_prefix" type="text" class="validate" required>
			          <label for="icon_prefix">Username</label>
			        </div>
			       </div>
			       <div style="margin-top: -20px; margin-left: 80px;" class="row">
			        <div class="input-field col s9">
			          <i class="material-icons prefix">lock</i>
			          <input name="pw" id="icon_prefix" type="password" class="validate" required>
			          <label for="icon_prefix">Password</label> 
			        </div>
			        	<a href="register.php"><button style="margin-top: 110px; margin-left: -40px;" type="button" id="login_btn" name="register" class="btn tooltipped btn-floating btn-large waves-effect waves-light red" data-delay="0" data-position="top" data-tooltip="Create Account"><i class="material-icons">add
            				</i></button></a>
			            <button style="margin-top: 110px; margin-left: 7px;" type="submit" id="register_btn" name="login" class="btn tooltipped btn-floating btn-large waves-effect waves-light light-blue lighten-1" data-delay="0" data-position="top" data-tooltip="Login"><i class="material-icons">send
            				</i></button>
			  </div>
		</form>

		<?php
			if(isset($_POST['login']))
			{
				$username = $_POST['un'];
				$password = $_POST['pw'];

				$select = $con->prepare("SELECT * FROM user WHERE username= :username AND password= :password");
				$select->bindParam(':username',$username);
				$select->bindParam(':password',$password);
				$select->execute();
				$count = $select->rowCount();
				$data = $select->fetch();
				$fullname = $data['fullname'];
					if($count == 1){
										$_SESSION['fullname'] = $fullname;
				                    	header('location: index.php');
				                }
				    else{
				    	echo "<script>
				    			swal('Failed', 'Username or Password Incorrect!', 'error');
				    			</script>";
				    }
			}
		?>
	</div>
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
      <script type="text/javascript" src="js/materialize.min.js"></script>
</body>
</html>