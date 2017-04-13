<?php
  session_start();
  require 'koneksi.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Home-SmartCounter</title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="js/sweetalert.min.js"></script>
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
    #slide-out{
      position: fixed;
    }
    nav{
      background-color: #3498db;  
    }
    #menu{
      background-color: #3498db;
      position: fixed;
    }
    .side-nav{
      top: 64px;
      width: 250px;
    }
    .container{
      margin-left: 300px;
    }
    #slide-out{
      position: fixed;
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
    #logo{
      height: 50px;
      width: 50px;
      margin-top: 5px;
      margin-left: 10px;
    }
    </style>
  </head>
  <body onload="showData()">

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

  <!-- Modal Add -->
  <div id="modal1" class="modal modal-fixed-footer">
    <form method="post" action="">
      <div class="modal-content">
        <h4>Insert Data</h4>
        <h1> </h1>
          <div class="input-field col s12">
            <i class="material-icons prefix">account_circle</i>
            <input id="ifn" type="text" class="validate" required>
            <label for="icon_prefix">Fullname</label>
          </div>
          <div class="input-field col s12">
            <i class="material-icons prefix">dialpad</i>
            <input id="ipn" type="number" class="validate" required>
            <label for="icon_prefix">Phone Number</label>
          </div>
          <div class="input-field col s12">
            <i class="material-icons prefix">sim_card</i>
            <select id="iop" onchange="showsel()" required>
              <option value="" disabled selected>Choose your operator</option>
              <option value="Telkomsel">Telkomsel</option>
              <option value="XL">XL</option>
              <option value="3">3</option>
              <option value="Indosat">Ooredoo</option>
              <option value="Axis">Axis</option>
              <option value="Smartfren">Smartfren</option>
            </select>
            <label>Select Operator</label>
          </div>
          <div id="iico" class="input-field col s12">
            <i class="material-icons prefix">code</i>
            <select id="ico" onchange="showmon()" required>
              <option value="" disabled selected>Select operator first</option>
            </select>
            <label id="sc">Select Code</label>
          </div>
          <div id="money" class="input-field col s12">
            
          </div>
          <div class="input-field col s12">
            <i class="material-icons prefix">date_range</i>
            <input id="idt" type="Date" class="datepicker" required>
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" onclick="addData()" class="waves-effect waves-green btn-flat ">Insert</button>
        <a onclick="hapusData()" class="waves-effect waves-red btn-flat ">Cancel</a>
      </div>
    </form>
  </div>

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
      <div class="input-field col s12">
        <i class="material-icons prefix">search</i>
        <input type="text" onkeyup="show()" id="autocomplete-input">
        <label for="icon_prefix">Search Name</label>
      </div>
      <form method="post" action="">
        <table id="tb" class="responsive-table">
          <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Operator</th>
                <th>Code</th>
                <th>Price(Rp)</th>
                <th>Transaction Date</th>
                <th style="width: 80px;">Action</th>
            </tr>
          </thead>
          <tbody id="tbody">
          </tbody>
        </table>
      </form>
      <div class="fixed-action-btn">
        <a href="#modal1" onclick="load()" class="btn-floating btn-large waves-effect waves-light red">
          <i class="large material-icons">add</i>
        </a>
      </div>
    </div>
    <script type="text/javascript">
      function showmon(){
        var co = $('#ico').val();
          $.ajax({
            type: "GET",
            url: "connect.php?p=ss",
            data: "co="+co,
            success: function(data){
              $('#money').html(data);
            }
          });
      }
      function load(){
        var select = $('select');
        select.val("None");
        select.material_select();
        var op = $('#iop').val();
          $.ajax({
            type: "GET",
            url: "connect.php?p=showsel",
            data: "op="+op,
            success: function(data){
              $('#ico').html(data);
            }
          });
      }
      function hapusData(){
        var select = $('select');
        select.val("None");
        select.material_select(); 
        $('.modal').modal('close');
        var op = $('#iop').val();
          $.ajax({
            type: "GET",
            url: "connect.php?p=showsel",
            data: "op="+op,
            success: function(data){
              $('#ico').html(data);
            }
          });
      }
      function addData(){
          var fullname = $('#ifn').val();
          var number = $('#ipn').val();
          var date = $('#idt').val();
          var op = $('#iop').val();
          var co = $('#ico').val();
          var hg = $('#ihg').val();
          $.ajax({
            type: "POST",
            url: "connect.php?p=add",
            data: "fullname="+fullname+"&phone_number="+number+"&transaction_date="+date+"&op="+op+"&co="+co+"&hg="+hg
          });
        }
        function showData(){
          $.ajax({
            type: "GET",
            url: "connect.php",
            success: function(data){
              $('#tbody').html(data);
            }
          });
        }
        function show(){
          var nama = $('#autocomplete-input').val();
          $.ajax({
            type: "GET",
            url: "connect.php?p=show",
            data: "name="+nama,
            success: function(data){
              $('#tbody').html(data);
            }
          });
        }
        function showsel(){
          var op = $('#iop').val();
          $.ajax({
            type: "GET",
            url: "connect.php?p=showsel",
            data: "op="+op,
            success: function(data){
              $('#ico').html(data);
            }
          });
        }
        function deleteData(str){
          var id = str;
          $.ajax({
            type: "POST",
            url: "connect.php?p=delete",
            data: "id="+id
          });
        }
    </script>
    <script type="text/javascript">
      $(document).ready(function(){
        $(".button-collapse").sideNav();
        $(function() {
          $('.datepicker').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 100, // Creates a dropdown of 15 years to control year
            format: 'yyyy-mm-dd'
          });
        });
        $('.modal').modal();
        $('select').material_select();
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