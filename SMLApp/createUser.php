<?php include("header.php");?>
<?php
	if($_SESSION['username'] == '')
    header("location: login.php");

	$reg = @$_POST['submit'];
	$id = "";
	$fn = "";
	$ln = "";
	$un = "";
	$em = "";
	$emUse = "";
	$pswd = "";
	$pswd2 = "";
	$level = "";
	$position = "";
	$d = "";
	$emailChecked = "";
	$empChecked = "";
	$passerror = $unerror = $fielderror = "";
	$message = "Create User";

	if($reg)
	{
		$emUse = strip_tags(@$_POST['reqNot']);
		$empChecked = strip_tags(@$_POST['empInfo']);
		$fn = strip_tags(@$_POST['firstname']);
		$ln = strip_tags(@$_POST['lastname']);
		$un = strip_tags(@$_POST['username']);
		$pswd = strip_tags(@$_POST['password']);
		$pswd2 = strip_tags(@$_POST['password2']);
		$level = strip_tags(@$_POST['level']);
		$em = strip_tags(@$_POST['email']);
		$position = strip_tags(@$_POST['position']);
		$emUse = strip_tags(@$_POST['reqNot']);
		$d = date("Y-m-d");
		$id = strip_tags(@$_POST['id']);

		$data = mysqli_query($link, "SELECT username FROM users WHERE username = '$un'");
		$check = mysqli_num_rows($data);
		if($check == 0)
		{
			if($pswd == $pswd2)
			{
				if(strlen($un) > 25 || strlen($fn) > 25 || strlen($ln) > 25)
					echo "The maximum limit for username/firstname/lastname is 25 characters";
				else
				{
					if(strlen($pswd) > 30 || strlen($pswd) < 5)
						echo "Your password must be between 5 and 30 characters";
					else
					{
						if($emUse == 'ch')
							$emUse = '1';
						else
							$emUse = '0';

						if($empChecked == 'ch')
							$empChecked = '1';
						else
							$empChecked = '0';

						$pswd_hash = crypt($pswd);
						$pswd2_hash = crypt($pswd2, $pswd_hash);
						$query = mysqli_query($link, "INSERT INTO users
								(username, first_name, last_name, password, user_level, sign_up_date, email, reqNot, display_info, position)
								VALUES ('$un', '$fn', '$ln', '$pswd_hash', '$level', '$d', '$em', '$emUse', '$empChecked', '$position')");
					}
				}
			}
			else
				$passerror = "Your passwords don't match";
		}
		else
		{
			if($pswd == $pswd2)
			{
				if(strlen($un) > 25 || strlen($fn) > 25 || strlen($ln) > 25)
					echo "The maximum limit for username/firstname/lastname is 25 characters";
				else
				{
					if(strlen($pswd) > 30 || strlen($pswd) < 5)
						echo "Your password must be between 5 and 30 characters";
					else
					{
						if($emUse == 'ch')
							$emUse = '1';
						else
							$emUse = '0';

						if($empChecked == 'ch')
							$empChecked = '1';
						else
							$empChecked = '0';

						$pswd_hash = crypt($pswd);
						$pswd2_hash = crypt($pswd2, $pswd_hash);
						$query = mysqli_query($link, "UPDATE users
								SET username = '$un', password = '$pswd_hash', user_level = '$level', email = '$em', reqNot = '$emUse', display_info = '$empChecked',
								 last_name = '$ln', position = '$position' WHERE id = '$id'");
					}
				}
			}
			else
				$passerror = "Your passwords don't match";
		}
		
	}

	if(isset($_GET['delete']))
	{
	    $page = $_GET['page'];
	    if($page == 'user')
	    {
	      $id = $_GET['id'];
	      $data = mysqli_query($link, "DELETE FROM users WHERE id = '$id'");
	      header("location: createUser.php");
	    }
	}
	if(isset($_POST['edit']))
	{
		$id = strip_tags(@$_POST['id']);
		$data = mysqli_query($link, "SELECT first_name, last_name, username, email, position, user_level, reqNot, display_info FROM users WHERE id = '$id'");
		while ($row = mysqli_fetch_array($data, MYSQL_NUM))
		{
			$fn = $row[0];
			$ln = $row[1];
			$un = $row[2];
			$em = $row[3];
			$position = $row[4];
			$level = $row[5];
			$emailChecked = $row[6];
			if($emailChecked == '1')
				$emailChecked = 'checked';
			else
				$emailChecked = '';
			$empChecked = $row[7];
			if($empChecked == '1')
				$empChecked = 'checked';
			else
				$empChecked = '';
		}
		$message = "Edit User";
	}
?>
		<div class = "wrapper">
			<br>
			<h2>Users</h2>
			<div ng-app="sortApp" ng-init = "vis = false" ng-controller="mainController">
				<form action = "createUser.php" method = "post" ng-show = "vis" >
					<input type = "hidden" name = "id" value = '<?php echo $id; ?>' />
					<div class = "field">
						<div class = "hidden-label"><label></label></div><br>
						<input type = "text" name = "firstname" placeholder = "firstname" value = '<?php echo $fn; ?>' required autofocus>
					</div>
					<div class = "field">
						<div class = "hidden-label"><label></label></div><br>
						<input type = "text" name = "lastname" placeholder = "lastname" value = '<?php echo $ln; ?>' required>
					</div>
					<div class = "field">
						<div class = "hidden-label"><label></label></div><br>
						<input type = "text" name = "username" placeholder = "username" value = '<?php echo $un; ?>' required autocomplete = "off">
					</div>
					<div class = "field">
						<div class = "hidden-label"<label></label></div><br>
						<input type = "email" name = "email" placeholder = "email" value = '<?php echo $em; ?>' autocomplete = "off" />
					</div>
					<div class = "field">
						<div class = "hidden-label"<label></label></div><br>
						<input type = "text" name = "position" placeholder = "position" value = '<?php echo $position; ?>' autocomplete = "off" />
					</div>
					<div class = "field">
						<div class = "hidden-label"><label></label></div><br>
						<select name = "level" id = "level" required>
							<option disabled selected>Select a user level</option>
							<option>Machinist</option>
							<option>Accountant</option>
							<option>Admin</option>
							<option>Inspector</option>
						</select>
						<script>
				            <?php echo "document.getElementById('toolType').level = '" . $level . "';"; ?>
				        </script>
					</div>
					<div class = "field">
						<div class = "hidden-label"><label></label></div><br>
						<input type = "password" name = "password" placeholder = "password" required autocomplete = "off">
					</div>
					<div class = "field">
						<div class = "hidden-label"><label></label></div><br>
						<input type = "password" name = "password2" placeholder = "re-enter your password" required autocomplete = "off">
					</div>
					<div class = "field">
						<div class = "check-boxes">
					        <div class = "useCheck">
					          	<input type = "checkbox" name = "reqNot" value = 'ch' <?php echo $emailChecked; ?> />
					          	<h5>Use as tools-request email</h5>
					        </div>
					        <div class = "useCheck">
					          	<input type = "checkbox" name = "empInfo" value = 'ch' <?php echo $empChecked; ?> />
					          	<h5>Display employee on website</h5>
					        </div>
					    </div>
				    </div><br>
					<div class = "end-buttons">
						<input type = "submit" name = "submit" value = "<?php echo $message; ?>" id = "submit">
						<input type = "reset" value = "Clear">
					</div>
				</form><br>
				<input type = "button" ng-click = "vis = !vis" value = 'show / hide new user form' id = "hide-button" /><br><br>
			
				<table>
					<tr>
						<?php 
							if($_SESSION['level'] == "Admin")
							{
								echo "<th></th>";
							}
						?>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Username</th>
						<th>Email</th>
						<th>Position</th>
						<th>User Level</th>
					</tr>
					<?php
						$data = mysqli_query($link, "SELECT id, username, first_name, last_name, user_level, email, reqNot, position FROM users");
						while ($row = mysqli_fetch_array($data, MYSQL_NUM))
						{
							echo "<tr>";
							if($_SESSION['level'] == "Admin")
							{
								echo '<td>
						            <div class = "dropdown">
						                <button class = "dropbtn">Options</button>
						                <ul class = "dropdown-content">
						                  	<div class = "dropbuffer">
						                    	<li><span class = "void-link">Options</span></li>
						                    	<li><form action = "createUser.php" method = "post">
							                        <input type = "hidden" name = "id" value = "' . $row[0] . '" />
							                        <input type = "submit" name = "edit" class = "link" value = "Edit / View" /></form>
							                    </li>
						                    	<li><form action = "createUser.php" method = "get">
													<input type = "hidden" name = "id" value = "' . $row[0] . '"></input>
													<input type = "hidden" name = "page" value = "user"></input>
													<input type = "submit" name = "delete" class = "link" value = "Delete"></input></form>
						                    	</li>
						                  	</div>
						                </ul>
						            </div>
						        </td>';
							}
							echo "<td>" . $row[2] . "</td>";
							echo "<td>" . $row[3] . "</td>";
							echo "<td>" . $row[1] . "</td>";
							echo "<td>" . $row[5] . "</td>";
							echo "<td>" . $row[7] . "</td>";
							echo "<td>" . $row[4] . "</td>";
						}
					?>
				</table>
			</div>
		</div>
	</body>
</html>