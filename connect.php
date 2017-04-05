<?php

		$con = new PDO('mysql:host=localhost;dbname=sapp','root','root');
		$page = isset($_GET['p'])?$_GET['p']:'';
		if($page == 'add')
		{
			$name   = $_POST['fullname'];
			$number = $_POST['phone_number'];
			$op = $_POST['op'];
			$co = $_POST['co'];
			$hg = $_POST['hg'];
			$date = $_POST['transaction_date'];
			if($hg == ""){

			}else{
			$query	= $con->prepare("INSERT INTO transaction(fullname,phone_number,operator,kode,harga,transaction_date) values(:name, :number, :op, :co, :hg, :date)");
			$result	= $query->execute(array(
				":name" 	=> $name,
				":number"	=> $number,
				":op"	=> $op,
				":co"	=> $co,
				":hg"	=> $hg,
				":date"	=> $date
			));
			}
		}
		else if($page == 'addHarga')
		{
			$sc   = $_POST['sc'];
			$cd = $_POST['cd'];
			$mn = $_POST['mn'];

			$query	= $con->prepare("INSERT INTO harga(operator,kode,harga) values(:name, :number, :date)");
			$result	= $query->execute(array(
					":name" 	=> $sc,
					":number"	=> $cd,
					":date"	=> $mn
					));
		}
		else if($page == 'editDatas')
		{
			$id = $_POST['id'];
			$sc = $_POST['sc'];
			$cd = $_POST['cd'];
			$mn = $_POST['mn'];

			$query	= $con->prepare("UPDATE harga set operator = :name, kode = :number, harga = :date WHERE id = :id");
			$result	= $query->execute(array(
					":name" 	=> $sc,
					":number"	=> $cd,
					":id"	=> $id,
					":date"	=> $mn
					));
		}
		else if ($page == "edit") {
			$id = $_POST['id'];
			$name   = $_POST['fullname'];
			$number = $_POST['phone_number'];
			$date = $_POST['transaction_date'];
			$query	= $con->prepare("UPDATE transaction set fullname = :fn, phone_number = :pn, transaction_date = :td WHERE id = :id");
			$result	= $query->execute(array(
				":fn" 	=> $name,
				":pn"	=> $number,
				":td"	=> $date,
				":id"	=> $id
			));
		}
		else if ($page == "delete") {
			$id = $_POST['id'];
			$query	= $con->prepare("DELETE FROM transaction WHERE id = :id");
			$result	= $query->execute(array(
				":id"	=> $id
			));	
		}
		else if ($page == "deletes") {
			$id = $_POST['id'];
			$query	= $con->prepare("DELETE FROM harga WHERE id = :id");
			$result	= $query->execute(array(
				":id"	=> $id
			));	
		}
		else if($page == "show")
		{
			$name = $_GET['name'];
			if($name != ""){
				$query = $con->prepare('SELECT * FROM transaction WHERE fullname LIKE "%'.$_GET['name'].'%"');
	            $query->execute(array(':name' => $name));
	            while($result = $query->fetch()){
            ?>
            <tr>
              <td><?php echo $result['id']; ?></td>
              <td><?php echo $result['fullname']; ?></td>
              <td><?php echo $result['phone_number']; ?></td>
              <td><?php echo $result['operator']; ?></td>
              <td><?php echo $result['kode']; ?></td>
              <td><?php echo $result['harga']; ?></td>
              <td><?php echo $result['transaction_date']; ?></td>
              <td>
                <div>
                  <button onclick="deleteDatas(<?php echo $result['id']; ?>)" class="btn-floating waves-effect waves-light red"><i class="material-icons left">delete</i>Delete</button>
                </div>
              </td>
            </tr>
            <?php
            	}
            }
            else{
				$query = $con->prepare('SELECT * FROM transaction');
	            $query->execute();
	            while($result = $query->fetch()){

            ?>
            <tr>
              <td><?php echo $result['id']; ?></td>
              <td><?php echo $result['fullname']; ?></td>
              <td><?php echo $result['phone_number']; ?></td>
              <td><?php echo $result['operator']; ?></td>
              <td><?php echo $result['kode']; ?></td>
              <td><?php echo $result['harga']; ?></td>
              <td><?php echo $result['transaction_date']; ?></td>
              <td>
                <div>
                  <button onclick="deleteDatas(<?php echo $result['id']; ?>)" class="btn-floating waves-effect waves-light red"><i class="material-icons left">delete</i>Delete</button>
                </div>
              </td>
            </tr>
            <?php
        	}
        }
		}
		else if($page == "shows")
		{
			$name = $_GET['name'];
			if($name != ""){
				$query = $con->prepare('SELECT * FROM harga WHERE operator LIKE "%'.$_GET['name'].'%"');
	            $query->execute(array(':name' => $name));
	            while($result = $query->fetch()){
            ?>
            <tr>
              <td><?php echo $result['id']; ?></td>
              <td><?php echo $result['operator']; ?></td>
              <td><?php echo $result['kode']; ?></td>
              <td><?php echo $result['harga']; ?></td>
              <td>
                <div>
                  <a href="#modal2-<?php echo $result['id']; ?>" class="btn-floating waves-effect waves-light yellow"><i class="material-icons left">edit</i>Edit</a>
                  <button onclick="deleteDatas(<?php echo $result['id']; ?>)" class="btn-floating waves-effect waves-light red"><i class="material-icons left">delete</i>Delete</button>
                </div>
                <!-- Modal -->
		        <div id="modal2-<?php echo $result['id']; ?>" style="height: 400px;" class="modal modal-fixed-footer">
		          <form method="post" action="">
		            <div class="modal-content">
		              <h4>Edit Data</h4>
		              <h1> </h1>
		                <div class="input-field col s12">
		                  <i class="material-icons prefix">sim_card</i>
		                  <input id="esc" type="text" class="validate" value="<?php echo $result['operator']; ?>" disabled>
		                </div>
		                <div class="input-field col s12">
		                  <i class="material-icons prefix">code</i>
		                  <input id="ecd" type="text" class="validate" value="<?php echo $result['kode']; ?>">
		                </div>
		                <div class="input-field col s12">
		                  <i class="material-icons prefix">monetization_on</i>
		                  <input id="emn" type="number" class="validate" value="<?php echo $result['harga']; ?>">
		                </div>
		            </div>
		            <div class="modal-footer">
		              <button type="submit" onclick="editDatas(<?php echo $result['id']; ?>)" class="waves-effect waves-green btn-flat ">Save</button>
		              <a class="modal-action modal-close waves-effect waves-red btn-flat ">Cancel</a>
		            </div>
		          </form>
		        </div>
              </td>
            </tr>
            <script type="text/javascript">
		      $(document).ready(function(){
		        $('select').material_select();
		        $('.modal').modal();
		      });
		    </script>
            <?php
            	}
            }
            else{
				$query = $con->prepare('SELECT * FROM harga');
	            $query->execute();
	            while($result = $query->fetch()){

            ?>
            <tr>
              <td><?php echo $result['id']; ?></td>
              <td><?php echo $result['operator']; ?></td>
              <td><?php echo $result['kode']; ?></td>
              <td><?php echo $result['harga']; ?></td>
              <td>
              	<!-- Modal -->
		        <div id="modal2-<?php echo $result['id']; ?>" style="height: 400px;" class="modal modal-fixed-footer">
		          <form method="post" action="">
		            <div class="modal-content">
		              <h4>Edit Data</h4>
		              <h1> </h1>
		                <div class="input-field col s12">
		                  <i class="material-icons prefix">sim_card</i>
		                  <input id="esc" type="text" class="validate" value="<?php echo $result['operator']; ?>" disabled>
		                </div>
		                <div class="input-field col s12">
		                  <i class="material-icons prefix">code</i>
		                  <input id="ecd" type="text" class="validate" value="<?php echo $result['kode']; ?>">
		                </div>
		                <div class="input-field col s12">
		                  <i class="material-icons prefix">monetization_on</i>
		                  <input id="emn" type="number" class="validate" value="<?php echo $result['harga']; ?>">
		                </div>
		            </div>
		            <div class="modal-footer">
		              <button type="submit" onclick="editDatas(<?php echo $result['id']; ?>)" class="waves-effect waves-green btn-flat ">Save</button>
		              <a class="modal-action modal-close waves-effect waves-red btn-flat ">Cancel</a>
		            </div>
		          </form>
		        </div>
                <div>
                  <a href="#modal2-<?php echo $result['id']; ?>" class="btn-floating waves-effect waves-light yellow"><i class="material-icons left">edit</i>Edit</a>
                  <button onclick="deleteData(<?php echo $result['id']; ?>)" class="btn-floating waves-effect waves-light red"><i class="material-icons left">delete</i>Delete</button>
                </div>
              </td>
            </tr>
            <script type="text/javascript">
		      $(document).ready(function(){
		        $('select').material_select();
		        $('.modal').modal();
		      });
		    </script>
            <?php
        	}
          }
		}
		else if($page == "ss")
		{
			$name = $_GET['co'];
				$query = $con->prepare('SELECT * FROM harga WHERE kode = :co');
	            $query->execute(array(':co' => $name));
	            while($result = $query->fetch()){
	        ?>
	        	<i class="material-icons prefix">monetization_on</i>
	            <input id="ihg" type="number" class="validate" value="<?php echo $result['harga']; ?>" disabled required>
	        <?php
            	}
        }
		else if($page == "showsel")
		{
			$name = $_GET['op'];
			if($name != "Choose your operator"){
				$query = $con->prepare('SELECT * FROM harga WHERE operator = :op');
	            $query->execute(array(':op' => $name));
	            while($result = $query->fetch()){
            ?>
            <option value="<?php echo $result['kode']; ?>"><?php echo $result['kode']; ?></option>
            <script type="text/javascript">
		      $(document).ready(function(){
		        $('select').material_select();
		      });
		    </script>
            <?php
            	}
            	}
            	else{
            ?>
            	<option value="" disabled>Select operator first</option>
	            <script type="text/javascript">
			      $(document).ready(function(){
			        $('select').material_select();
			      });
			    </script>
        <?php
        	}
		}
		else if($page == "sh")
            {
            	$query = $con->prepare('SELECT * FROM harga');
	            $query->execute();
	            while($result = $query->fetch()){
            ?>
            <tr>
              <td><?php echo $result['id']; ?></td>
              <td><?php echo $result['operator']; ?></td>
              <td><?php echo $result['kode']; ?></td>
              <td><?php echo $result['harga']; ?></td>
              <td>
                <div>
                  <a href="#modal2-<?php echo $result['id']; ?>" class="btn-trigger btn-floating waves-effect waves-light yellow"><i class="material-icons left">edit</i>Edit</a>
                  <button onclick="deleteDatas(<?php echo $result['id']; ?>)" class="btn-floating waves-effect waves-light red"><i class="material-icons left">delete</i>Delete</button>
                </div>
                <!-- Modal -->
		        <div id="modal2-<?php echo $result['id']; ?>" style="height: 400px;" class="modal modal-fixed-footer">
		          <form method="post" action="">
		            <div class="modal-content">
		              <h4>Edit Data</h4>
		              <h1> </h1>
		                <div class="input-field col s12">
		                  <i class="material-icons prefix">sim_card</i>
		                  <input id="esc" type="text" class="validate" value="<?php echo $result['operator']; ?>" disabled>
		                </div>
		                <div class="input-field col s12">
		                  <i class="material-icons prefix">code</i>
		                  <input id="ecd" type="text" class="validate" value="<?php echo $result['kode']; ?>">
		                </div>
		                <div class="input-field col s12">
		                  <i class="material-icons prefix">monetization_on</i>
		                  <input id="emn" type="number" class="validate" value="<?php echo $result['harga']; ?>">
		                </div>
		            </div>
		            <div class="modal-footer">
		              <button type="submit" onclick="editDatas(<?php echo $result['id']; ?>)" class="waves-effect waves-green btn-flat ">Save</button>
		              <a class="modal-action modal-close waves-effect waves-red btn-flat ">Cancel</a>
		            </div>
		          </form>
		        </div>
              </td>
            </tr>
			  <script type="text/javascript">
		      $(document).ready(function(){
		        $('select').material_select();
		        $('.modal').modal();
		      });
		    </script>
            <?php
        		}
            }
		else
		{
			$query = $con->prepare('SELECT * FROM transaction');
            $query->execute();
            while($result = $query->fetch()){
            ?>
            <tr>
              <td><?php echo $result['id']; ?></td>
              <td><?php echo $result['fullname']; ?></td>
              <td><?php echo $result['phone_number']; ?></td>
              <td><?php echo $result['operator']; ?></td>
              <td><?php echo $result['kode']; ?></td>
              <td><?php echo $result['harga']; ?></td>
              <td><?php echo $result['transaction_date']; ?></td>
              <td>
                <div>
                  <button onclick="deleteData(<?php echo $result['id']; ?>)" class="btn-floating waves-effect waves-light red"><i class="material-icons left">delete</i>Delete</button>
                </div>
              </td>
            </tr>
            <?php
            }
		}


?>