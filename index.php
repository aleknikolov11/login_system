<?php
	require 'header.php';
?>

<main>

	<?php
		
		if(isset($_SESSION['uidUser'])) {
			
			echo "<p>You are logged in!</p><br>";
			echo "<form action='includes/logout.inc.php' method='post'>
					<button type='submit' name='logout_submit'>Logout</button>
					</form>";
			
		} else {
			
			echo "<p>You are logged out!</p><br>";
			echo "	<div>
					<form action='includes/login.inc.php' method='POST'>
						<input type='text' name='uidmail' placeholder='Username / E-mail'>
						<input type='password' name='pwd' placeholder='Password'>
						<button type='submit' name='login_submit'>Login</button>
					</form>
					</div>
					<br>
					<a href='signup.php'>Signup</a>";
			
		}

	?>

</main>

<?php
	require 'footer.php';
?>