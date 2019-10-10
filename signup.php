<?php
	require 'header.php';
?>
		<br>
		<div>
			
			<?php
			
				if(isset($_GET['signup'])) {
					
					echo '<p>Registration Successfull!</p>';
					
				} else {
					if(isset($_GET['error'])) {
						if($_GET['error'] == 'emptyfields') 
							echo '<font color="red">Please, fill in all fields</font><br>';
						elseif($_GET['error'] == 'invalidpwd')
							echo '<font color="red">Invalid Password</font><br>';
						elseif($_GET['error'] == 'matchpwd')
							echo '<font color="red">Passwords are not the same</font><br>';
						elseif($_GET['error'] == 'invalidemail')
							echo '<font color="red">Invalid E-mail</font><br>';
						elseif($_GET['error'] == 'emailtaken')
							echo '<font color="red">E-mail is taken</font><br>';
						elseif($_GET['error'] == 'uidtaken')
							echo '<font color="red">Username is taken</font><br>';
					}
					
					$uid = (isset($_GET['uid'])) ? $_GET['uid'] : '';
					$email = (isset($_GET['email'])) ? $_GET['email'] : '';
					
					echo "<form action='includes/signup.inc.php' method='POST'>
					<input type='text' name='uid' placeholder='Username' value='$uid'>
					<input type='password' name='pwd' placeholder='Password'>
					<input type='password' name='pwd_rep' placeholder='Repeat Password'>
					<input type='text' name='email' placeholder='Email' value='$email'>
					<button type='submit' name='signup_submit'>SignUp</button>
					</form>";
				}
				
			?>
		</div>