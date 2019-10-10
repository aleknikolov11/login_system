<?php
	
	include_once 'dbh.inc.php';

	if(!isset($_POST['signup_submit'])) {
		
		header("Location: ../index.php");
		exit();
		
	} else {
		
		$uid = $_POST['uid'];
		$pwd = $_POST['pwd'];
		$pwd_rep = $_POST['pwd_rep'];
		$email = $_POST['email'];
		
		if(empty($uid) || empty($pwd) || empty($pwd_rep) || empty($email)){
			
			header("Location: ../signup.php?error=emptyfields&uid=".$uid."&email=".$email);
			exit();
			
		} elseif(!preg_match("/^[a-zA-Z0-9]*$/", $pwd) || strlen($pwd) < 8 || strlen($pwd) > 32) {
			
			header("Location: ../signup.php?error=invalidpwd&uid=".$uid."&email=".$email);
			exit();
			
		} elseif($pwd != $pwd_rep){
			
			header("Location: ../signup.php?error=matchpwd&uid=".$uid."&email=".$email);
			exit();
			
		} elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			
			header("Location: ../signup.php?error=invalidemail&uid=".$uid);
			exit();
			
		} else {
			
			$sql_stmt = "SELECT * FROM users WHERE uidUsers=? OR emailUsers=?;";
			$prep_stmt = mysqli_stmt_init($conn);
			
			if(!mysqli_stmt_prepare($prep_stmt, $sql_stmt)) {
				
				header("Location: ../signup.php?error=sqlerror");
				exit();
				
			} else {
				
				mysqli_stmt_bind_param($prep_stmt, 'ss', $uid, $email);
				mysqli_stmt_execute($prep_stmt);
				$result = mysqli_stmt_get_result($prep_stmt);
				
				if($row = mysqli_fetch_assoc($result)) {
					
					if($row['uidUsers'] == $uid) {
						
						header("Location: ../signup.php?error=uidtaken&email=".$email);
						exit();
						
					} elseif ($row['emailUsers'] == $email) {
						
						header("Location: ../signup.php?error=emailtaken&uid=".$uid);
						exit();
						
					} 
				} else {
					
					$sql_stmt = "INSERT INTO users (uidUsers, emailUsers, pwdUsers) VALUES (?, ?, ?);";
					$prep_stmt = mysqli_stmt_init($conn);
					
					if(!mysqli_stmt_prepare($prep_stmt, $sql_stmt)) {
						
						header("Location: ../signup.php?error=sqlerror");
						exit();
						
					} else {
						
						$hashed_pwd = password_hash($pwd, PASSWORD_DEFAULT);
						
						mysqli_stmt_bind_param($prep_stmt, 'sss', $uid, $email, $hashed_pwd);
						mysqli_stmt_execute($prep_stmt);
						echo 'I got here';
						
						header("Location: ../signup.php?signup=success");
						exit();
						
					}	
				}
			}
			
			
		}
		mysqli_stmt_close($prep_stmt);
		mysqli_close($conn);
		
	}