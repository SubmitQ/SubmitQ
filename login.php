<html>
<head></head>
<body>
        <div id="login">
		<h2>Login</h2>
	
		<form action="process_login.php" method ="POST">
			Email: <input type= "text" name = "email" required> </p>
			<p> Password: <input type= "password" name = "password" required> </p>
			<p><input type="checkbox" name="setcookie" value="setcookie">Remember Me</p>
			<p><input type="submit" name= "submit" value= "Login"></p>
			</form>
		<a href="forgot_password.php">Forgot Password?</a>
	</div>
</body>
</html>