<?php
	if(isset($_REQUEST['loginUsername'])){
		session_start();

		include_once("user.php");
		$u_name = $_REQUEST['loginUsername'];
		$p_word = $_REQUEST['loginPassword'];
		$obj = new users();
		$row = $obj->validate_user($username,$password);
		if(!$row){
			echo "wrong credentials";
		}else{
			$_SESSION['USER_ID'] = $row['USER_ID'];
			$_SESSION['USERNAME'] = $row['USERNAME'];
			$_SESSION['PASSWORD'] = $_REQUEST['PASSWORD'];
			header("location:index.php");
		}
	}
?>
<html>
	<head>
	<script src="jquery-2.1.3.js"></script>
	<script>

		function sendRequest(requestURL){
			var obj = $.ajax({url:requestURL, async:false});
			var response =$.parseJSON(obj.responseText);
			return response;

		}

		function login(username, password){
			var response = sendRequest("user_methods.php?cmd=1&username="+username+"&password="+password);
			divContent.innerHTML=response.message;


		}

		function validate(){
			var valid = validatePassword();
			if(valid){
				var response = login(loginUsername.value, loginPassword.value);

			}


		}

		function validatePassword(){
			var password = loginPassword.value;
			var username = loginUsername.value;
			var pErr =false;
			var uErr=false;
			if(password.length<1){
				loginPassword.style.backgroundColor="red";
				pErr=true;
			}
			if(username.length<1){
				loginUsername.style.backgroundColor="red";
				uErr=true;
			}
			if(pErr==false&&uErr==false){
				return true;
			}
			return false;


		}
	</script>
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>


		<form method="POST" action="login.php">
			<table align="center">
				<tr>
					<td>Username</td><td><input type="text" placeholder="Username" name="loginUsername" required></td>
				</tr>
				<tr>
					<td>Password</td><td><input type="password" placeholder="Password" name="loginPassword" required></td>
				</tr>
				<tr>

					<td></td><td><button type="submit">Login</button></td>
				</tr>
			</table>
		</form>
	</body>

</html>
