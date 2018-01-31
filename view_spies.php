<?php
session_start();
if(!empty($_SESSION['lusername']) && !($_SESSION['lusername'] == '')){
	$login = true;
	$display1 = 'none';
	$display2 = 'inherit';
} else{
	$login = false;
	$display1 = 'inherit';
	$display2 = 'none';
}
?>

<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="./styles/view_spies.css" />
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
	<title>Goshen Gotcha | Spies</title>
</head>
<body>
<div class="wrapper">
<div class="header">VIEW SPIES</div>
<?php
require './config.php';

$sql = "SELECT username, description, target FROM users";
$result = $link->query($sql);

if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		if ($row["target"] == "killed"){
			$color = "background-color:#363636;";
		} else { $color = "background-color:#2d0e44;";}
		echo'<div class="spy" style="'.$color.'"><h1>'.$row["username"].'</h1><p>'.$row["description"].'</p></div>';
	}
} else {
	echo "0 results";
}
$link->close();
?>
<div style="position:absolute;height:100vh;width:100%;top:0;"></div>
</div>
<div class="footer">
	<p style="display:inline;float:left;margin:13px;"><a href="/">Home</a>Created by Bryce Yoder, 2017</p>
	<a href='./logout.php' class='logout' style='float:right;display:<?php if($login == true){echo 'inline';}else{echo 'none';}?>'>Logout</a>
</div>
</body>
</html>
