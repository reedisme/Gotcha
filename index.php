<?php
session_start();
if(!empty($_SESSION['lusername']) && !($_SESSION['lusername'] == '')){
	$login = true;
	$display1 = 'none';
	$display2 = 'inherit';
	require_once './config.php';
	$sql = "SELECT target FROM users WHERE username = '".$_SESSION['lusername']."'";
	$result = $link->query($sql);
	$row = mysqli_fetch_array($result);
	if ($row["target"] == Null){
		$info_box = Null;
	} elseif ($row["target"] == "killed"){
		$info_box = "killed";
	} else { $info_box = $row["target"]; }
} else{
	$login = false;
	$display1 = 'inherit';
	$display2 = 'none';
	$info_box = Null;
}
?>


<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="./styles/homepage.css" />
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="./scripts/homepage.js"></script>
<head>
  <title>Goshen Gotcha</title>
</head>
<body >
    <div class='header'>
        <p class='logo'>GOSHEN COLLEGE</p>
    </div>
    <div>
        <h1 class='gotcha'>GOTCHA</h1>
    </div>
    <div class='page'>
        <div class='content'>
            <div id="a1" style="margin-left:-500px;"class="bubble" ></div>
            <div id="a2" style="margin-left:-400px;"class="bubble" ></div>
            <div id="a3" style="margin-left:-300px;"class="bubble" ></div>
            <div id="a4" style="margin-left:-200px;"class="bubble" ></div>
            <div id="b1" style="margin-left:-100px;"class="bubble" ></div>
            <div id="b2" style="margin-left:0px;"class="bubble" ></div>
            <div id="b3" style="margin-left:100px;"class="bubble" ></div>
            <div id="b4" style="margin-left:200px;"class="bubble" ></div>
            <div id="c1" class="bubble" style="margin-left:-100px;"></div>
            <div id="c2" style="margin-left:300px;"class="bubble" ></div>
            <div id="c3" style="margin-left:400px;"class="bubble" ></div>
            <div id="c4" style="margin-left:500px;"class="bubble" ></div>
            <div id="d1" style="margin-left:600px;"class="bubble" ></div>
            <div id="d2" style="margin-left:700px;"class="bubble" ></div>
            <div id="d3" style="margin-left:800px;"class="bubble" ></div>
            <div id="d4" style="margin-left:900px;"class="bubble" ></div>
	    <div style="height:15vh"></div>
	    <div style="display:<?php if ($info_box){echo $display2;}else{echo "none";}?>;"class="information_box"><p>
		<?php
		if ($info_box == "killed"){
			echo "You have been killed!";
		} else {
			echo "Your target is ".$info_box;
		}
		?>
		</p></div>
            <h1 style='z-index:2;margin-top:25vh;position:relative;margin-left:-20px;font-family:Franklin Gothic Bold;'>Gotcha!</h1>
            <p style='z-index:2;position:relative;'>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        </div>
        <div class='buttons'>
            <a href='./login_register.php' class='button' style='float:left;display:<?php echo $display1;?>;'>
                <img class='button_image'src='./images/log_reg.svg'>
                <div class='button_text'>
                    Login/Register
                </div>
            </a>
	    <?php if($info_box == "killed"){echo '<div style="cursor:default;background-color:#363636;';}else{echo "<a href='./submit_form.php' style=";}?>float:left;display:<?php echo $display2;?>;" class='button'>
                <img class='button_image'src='./images/form.svg'>
                <div class='button_text'>
                    Submit Report
                </div>
	    <?php if($info_box == "killed"){echo "</div>";}else{echo "</a>";}?>
            <a href='./view_spies.php' class='button' >
                <img class='button_image'src='./images/assassin.svg'>
                <div class='button_text'>
                    View Assassins
                </div>
            </a>
            <a href='./rules.php' class='button' style='float:right;'>
                <img class='button_image'src='./images/rules.svg'>
                <div class='button_text'>
                    Rules
                </div>
            </a>
        </div>
    </div>
    <div class='footer'>
	<p style="display:inline;float:left;margin:13px;">Created by Bryce Yoder, 2017</p>
	<a href='./logout.php' class='logout' style='float:right;display:<?php if($login == true){echo 'inline';}else{echo 'none';}?>'>Logout</a>
    </div>
</body>
</html>
