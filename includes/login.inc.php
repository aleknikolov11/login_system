<?php
	
	include_once 'dbh.inc.php';
	
	if(!isset($_POST['login_submit'])) {
		
		header("Location: ../index.php");
		exit();
		
	} else {
		
		$uidmail = $_POST['uidmail'];
		$pwd = $_POST['pwd'];
		
		if(empty($uidmail)) {
			
			header("Location: ../index.php?error=uidmailempty");
			exit();
			
		} elseif(empty($pwd)) {
			
			header("Location: ../index.php?error=pwdempty&uidmail=".$uidmail);
			exit();
			
		} else {
			
			$sql_stmt = "SELECT * FROM users WHERE uidUsers=? OR emailUsers=?;";
			$prep_stmt = mysqli_stmt_init($conn);
			
			if(!mysqli_stmt_prepare($prep_stmt, $sql_stmt)) {
				
				header("Location: ../index.php?error=sqlerror&uidmail=".$uidmail);
				exit();
				
			} else {
				
				mysqli_stmt_bind_param($prep_stmt, 'ss', $uidmail, $uidmail);
				mysqli_stmt_execute($prep_stmt);
				$result = mysqli_stmt_get_result($prep_stmt);
				
					
				$row = mysqli_fetch_assoc($result);
				if(password_verify($pwd, $row['pwdUsers']) != true) {
					
					header("Location: ../index.php?error=wrongpwd&uidmail=".$uidmail);
					exit();
					
				} else {
					session_start();
					$_SESSION['idUser'] = $row['idUsers'];
					$_SESSION['uidUser'] = $row['uidUsers'];
					
					mysqli_stmt_close($prep_stmt);
					mysqli_close($conn);
					
					header("Location: ../index.php?login=success");
					exit();
					
				} 
				
				
			}
			
		}
		
	}