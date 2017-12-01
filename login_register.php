<?php

session_start();
if (empty($_SESSION['try_count'])) {
	$_SESSION['try_count'] = 1;
	$_SESSION['start_time'] = time();
} else {
	if (time() - $_SESSION['start_time'] > 60){
		session_destroy();
	} else {
		$_SESSION['try_count']++;
	}
}

require_once './config.php';

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
	if(empty(trim($_POST["username"]))){
		$username_err = "Boi what are you trying to do without entering a name?";
	} else{
		$sql = "SELECT id FROM users WHERE username = ?";

		if($stmt = mysqli_prepare($link, $sql)){
			mysqli_stmt_bind_param($stmt, "s", $param_username);

			$param_username = trim($_POST["username"]);

			if(mysqli_stmt_execute($stmt)){
				mysqli_stmt_store_result($stmt);

				if(mysqli_stmt_num_rows($stmt) == 1){
					$username_err = "Bruh, that username is taken.";
				} else{
					$username = trim($_POST["username"]);
				}
			}
		}

		mysqli_stmt_close($stmt);
	}
	if(empty(trim($_POST["password"]))){
		$password_err = "I mean you gotta enter a password my man.";
	}elseif(strlen(trim($_POST["password"])) < 6){
		$password_err = "Hey guy, slap more than 5 characters on that thing.";
	} else{
		$password = trim($_POST["password"]);
	}

	if(empty(trim($_POST["vpassword"]))){
		$confirm_password_err = 'Bruh you gotta confirm that password.';
	} else{
		$confirm_password = trim($_POST["vpassword"]);
		if($password != $confirm_password){
			$confirm_password_err = "Woah there buddy these password don't match.";
		}
	}

	if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

		$sql = "INSERT INTO users (username, password) VALUES (?, ?)";
		if($stmt = mysqli_prepare($link, $sql)){
			mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

			$param_username = $username;
			$param_password = password_hash($password, PASSWORD_DEFAULT);

			if(mysqli_stmt_execute($stmt)){
				header("location: ./index.html");
			}
		}
		mysqli_stmt_close($stmt);
	}
	mysqli_close($link);
}
if ($_SESSION['try_count'] > 5){
	$username_err = 'What, do you like suck at creating users or something?';
}
?>


<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="./styles/login_register.css" />
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="./scripts/login_register.js"></script>
<head>
    <title>Goshen Gotcha | Login/Register</title>
</head>
    <div class="blocker">
        <div class="blocker_text_container">
            <h1 id='login' class='select'>Login</h1>
            <h1 id='register' class='unselect'>Register</h1>
        </div>
    </div>
    <div id='logreg' class="logreg transform">
        <div class="log">
            <form action="./action_page.php">
                <label for="uname">Username</label>
                <input type="text" id="uname" name="lUsername" placeholder="Username">

                <label for="password">Password</label>
                <input type="text" id="password" name="lPassword" placeholder="Password">

                <input type="submit" value="Submit">
            </form>
        </div>
        <div class='reg'>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method='post'>
		<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label for="uname">Username</label>
		<input type="text" id="username" name="username" placeholder="Username"value="<?php echo $username; ?>">
		<span class="help-block"><?php echo $username_err;?></span>
		</div>

		<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ""; ?>">
                <label for="password">Password</label>
		<input type="password"id="password"name="password"placeholder="Password"value="<?php echo $password; ?>">
		<span class="help-block"><?php echo $password_err;?></span>
		</div>

		<div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ""; ?>">
                <label style='right:30%;white-space:nowrap;' for="vpassword">Verify Password</label>
		<input type="password" id="vpassword" name="vpassword"placeholder="Verify Password" value="<?php echo $confirm_password; ?>">
		<span class="help-block"><?php echo $confirm_password_err;?></span>
		</div>

                <input type="submit" value="Submit">
            </form>
        </div>
    </div>
    <div style='position:fixed;bottom:0;' class="blocker"></div>
</html>
