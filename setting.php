<?php
  session_start();
  require "koneksi.php";
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Setting-SmartCounter</title>
    <script src="js/sweetalert.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <link rel="icon" href="images/logo-sc-blue.png" sizes="32x32">
    <!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
    <link rel="stylesheet" type="text/css" href="css/sweetalert.css">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <style type="text/css">
    #appname{
      left: 65px;
    }
    #menu{
      background-color: #3498db;
      position: fixed;
    }
    .side-nav{
      top: 64px;
      width: 250px;
    }
    #slide-out{
      position: fixed;
    }
    .container{
      margin-left: 300px;
    }
    #tb{
      width: 100%;
    }
    #autocomplete-input{
      width: 30%;
    }
    .prefix{
      top: 10px;
      left: 10px;
    }
    #modal1{
      height: 400px;
    }
    #logo{
      height: 50px;
      width: 50px;
      margin-top: 5px;
      margin-left: 10px;
    }
    nav{
      background-color: #3498db;
    }
    </style>
  </head>
  <body>

  <!-- Modal Pictures -->
      <div id="modalp" class="modal modal-fixed-footer" style="height: 230px; width: 550px; margin-top: 50px;">
        <form method="post" action="" enctype="multipart/form-data">
          <div class="modal-content" style="height: auto;">
            <h4>Change Picture</h4>
            <h1> </h1>
            <div id="images"></div>
            <div class="file-field input-field">
              <div class="btn">
                <span>File</span>
                <input type="file" name="user_image">
              </div>
              <div class="file-path-wrapper">
                <input class="file-path validate" type="text">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="upload" class="modal-action modal-close waves-effect waves-green btn-flat ">Save</button>
            <a href="#" class="modal-action modal-close waves-effect waves-red btn-flat ">Close</a>
          </div>
        </form>
      </div>

  <?php
     if(isset($_POST['upload']))
     {
      $name_p = $_FILES['user_image']['name'];
      $sumber_p = $_FILES['user_image']['tmp_name'];
      $fn = $_SESSION['fullname'];

      $folder = 'images/'; // upload directory
      move_uploaded_file($sumber_p,$folder.$name_p);
        
       $stmt = $con->prepare('UPDATE user set pic = :upic WHERE fullname = :fn');
       $stmt->bindParam(':upic',$name_p);
       $stmt->bindParam(':fn',$fn);
       $stmt->execute();
     }
    ?>

   <!-- Nav-Bar -->
    <div class="navbar-fixed">
      <nav>
        <div class="nav-wrapper">
          <img id="logo" src="images/logo-sc.png">
          <a id="appname" href="index.php" class="brand-logo">SmartCounter</a>
          <ul class="right hide-on-med-and-down">
            <li><a id="logout" class="tooltipped" data-delay="0" data-position="left" data-tooltip="Logout"><i class="material-icons">exit_to_app</i></a></li>
          </ul>
        </div>
      </nav>
    </div>

    <!-- side-nav-bar -->
    <ul id="slide-out" class="side-nav fixed">
      <li><div class="userView">
        <div class="background">
          <img class="responsive-img" src="images/bg.png">
        </div>
        <?php
            $fn = $_SESSION['fullname'];
            $stmt = $con->prepare('SELECT * FROM user WHERE fullname = :fn');
            $stmt->bindParam(':fn',$fn);
            $stmt->execute();
            $result= $stmt->fetchAll();
            foreach ($result as $row) {
        ?>
        <a href="#modalp"><img class="circle" src="images/<?php echo $row['pic']; ?>"></a>
        <?php
            }
        ?>
        <a href="#"><span class="white-text name"><?php echo $_SESSION['fullname']; ?></span></a>
        <a href="#"><span class="white-text email">Administrator</span></a>
      </div></li>
      <li><a href="index.php"><i class="material-icons">home</i>Home</a></li>
      <li><a href="price.php"><i class="material-icons">account_balance_wallet</i>Set Price</a></li>
      <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header" style="margin-left: 16.5px;"><i class="material-icons">description</i>Report</a>
            <div class="collapsible-body">
              <ul>
                <li><a href="pdfToday.php">Today</a></li>
                <li><a href="pdfWeek.php">This Week</a></li>
                <li><a href="pdfMonth.php">This Month</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </li>
      <li><a href="setting.php"><i class="material-icons">settings</i>Setting</a></li>
    </ul>
    <a id="menu" href="#" data-activates="slide-out" class="button-collapse waves-effect btn-floating"><i class="material-icons">menu</i></a>

    <!-- Content -->
    <div class="container">
      <ul class="collapsible popout" data-collapsible="accordion">
        <li>
          <div class="collapsible-header">
            <i class="material-icons">picture_in_picture</i>Change Fullname
          </div>
          <div class="collapsible-body">
            <form method="POST" action="">
              <div class="row">
                <div class="input-field col s9">
                  <input id="icon_prefix" type="text" class="validate" name="fullname" required>
                  <label for="icon_prefix">Fullname</label>
                </div>
              </div>
              <div class="row" align="right">
                  <button type="submit" name="changefn" class="waves-effect waves-green btn-flat ">save change</button>
              </div>
            </form>
          </div>
        </li>
        <li>
          <div class="collapsible-header">
            <i class="material-icons">lock</i>Change Password
          </div>
          <div class="collapsible-body">
            <form method="POST" action="">
              <div class="row">
                <div class="input-field col s9">
                  <input id="icon_prefix" type="password" class="validate" name="pw1" required>
                  <label for="icon_prefix">Your current password</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s9">
                  <input id="icon_prefix" type="password" class="validate" name="pw2" required>
                  <label for="icon_prefix">Your new password</label>
                </div>
              </div>
              <div class="row" align="right">
                  <button type="submit" name="changepw" class="waves-effect waves-green btn-flat ">save change</button>
              </div>
            </form>
          </div>
        </li>
        <li>
          <div class="collapsible-header">
            <i class="material-icons">mail</i>Change Email
          </div>
          <div class="collapsible-body">
            <form method="POST" action="">
              <div class="row">
                <div class="input-field col s9">
                  <input id="icon_prefix" type="email" class="validate" name="email" required>
                  <label for="icon_prefix">Your new email</label>
                </div>
              </div>
              <div class="row" align="right">
                  <button type="submit" name="changemail" class="waves-effect waves-green btn-flat ">save change</button>
              </div>
            </form>
          </div>
        </li>
      </ul>
    </div>
    <?php
      if(isset($_POST['changefn'])){
        $fn = $_POST['fullname'];
        $fn1 = $_SESSION['fullname'];
        $uid = $_SESSION['uid'];

        $query1 = $con->prepare('SELECT * FROM user WHERE uid = "'.$uid.'"');
        $query1->execute();
        $result1 = $query1->fetch();

        if($fn == $result1['fullname'])
        {
          echo "<script>
                  swal('Failed', 'Your fullname not changed!', 'error');
                  </script>";
        }
        else{
          $stmt = $con->prepare('UPDATE user set fullname = "'.$fn.'" WHERE fullname = "'.$fn1.'"');
          $stmt->execute();

          $query = $con->prepare('SELECT * FROM user WHERE uid = "'.$uid.'"');
          $query->execute();
          $result = $query->fetch();
          $fullname = $result['fullname'];
          $_SESSION['fullname'] = $fullname;
            echo '<script>
                      swal({
                        title: "Success",
                        text: "Your fullname successfully changed!",
                        type: "success",
                        confirmButtonColor: "#8cd4f5",
                        confirmButtonText: "OK",
                        },
                        function(isConfirm){
                          if (isConfirm) {
                            window.location.assign("setting.php");
                          }
                        });
                    </script>';
        }
      }
      else if(isset($_POST['changepw'])){
        $pw1 = md5($_POST['pw1']);
        $pw2 = md5($_POST['pw2']);
        $uid = $_SESSION['uid'];

        if($pw1 == $pw2){
          echo "<script>
                    swal('Failed', 'Your new password cannot same!', 'error');
                    </script>";
        }
        else{
          $stmt = $con->prepare('SELECT * FROM user WHERE password = "'.$pw1.'"');
          $stmt->execute();
          $count = $stmt->rowCount();
          if($count < 1){
            echo "<script>
                    swal('Failed', 'Your current password incorrect!', 'error');
                    </script>";
          }
          else{
            $query = $con->prepare('UPDATE user set password = "'.$pw2.'" WHERE uid = "'.$uid.'"');
            $query->execute();
            echo "<script>
                    swal('Success', 'Your password successfully changed!', 'success');
                    </script>";
          }
        }
      }
      else if(isset($_POST['changemail'])){
        $email = $_POST['email'];
        $uid = $_SESSION['uid'];

        $query1 = $con->prepare('SELECT * FROM user WHERE uid = "'.$uid.'"');
        $query1->execute();
        $result1 = $query1->fetch();

        if($email == $result1['email']){
          echo "<script>
                    swal('Failed', 'Your new email cannot same!', 'error');
                    </script>";
        }
        else{
          $stmt = $con->prepare('UPDATE user set email = "'.$email.'" WHERE uid = "'.$uid.'"');
          $stmt->execute();
          echo "<script>
                    swal('Success', 'Your email successfully changed!', 'success');
                    </script>";
        }
      }
    ?>
    <script type="text/javascript">
      $(document).ready(function(){
        $(".button-collapse").sideNav();
        $('.modal').modal();
        $('#logout').click(function(){
              swal({
                    title: "Are you sure?",
                    text: "You will logout!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false,
                    closeOnCancel: true
                  },
                  function(isConfirm){
                    if (isConfirm) {
                      window.location.href="login.php";
                    }
                  });
            });
      });
    </script>
    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="js/materialize.min.js"></script>
  </body>
</html>