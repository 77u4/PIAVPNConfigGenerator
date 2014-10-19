<?php
/**
  * privateinternetaccess.com Mac OS X VPN config generator
  * Generator - generate.php
  * Copyright (c) 2014 Jannis Hutt
  * Licensed under MIT License
**/

//require('crypto.class.php');

if(@$_GET['action'] == 'make' OR @$_GET['action'] == 'download'){

//VARS

//From Form
$username = @$_POST['username'];
$password = @$_POST['password'];
$secret   =	@$_POST['secret'];

//Encryption of $password and $secret

//I have no clue how this should work.
//Workaround:
/*
$password = "add in System Preferences after import.";
$secret = "add in System Preferences after import.";
*/

// PIA Server List
$server = array("us-midwest.privateinternetaccess.com"=>"US Midwest", "us-east.privateinternetaccess.com"=>"US East", "us-texas.privateinternetaccess.com"=>"US Texas","us-west.privateinternetaccess.com"=>"US West", "us-california.privateinternetaccess.com"=>"US California", "us-seattle"=>"US Seattle", "us-florida.privateinternetaccess.com"=>"US Florida", "ca.privateinternetaccess.com"=>"Canada", "ca-toronto.privateinternetaccess.com"=>"CA Toronto", "uk-london.privateinternetaccess.com"=>"UK London", "uk-southampton.privateinternetaccess.com"=>"UK Southampton","swiss.privateinternetaccess.com"=>"Switzerland", "nl.privateinternetaccess.com"=>"Netherlands", "sweden.privateinternetaccess.com"=>"Sweden", "france.privateinternetaccess.com"=>"France", "germany.privateinternetaccess.com"=>"Germany", "romania.privateinternetaccess.com"=>"Romania", "hk.privateinternetaccess.com"=>"Hong Kong", "israel.privateinternetaccess.com"=>"Israel");

// Generate XML		
$xml = '<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
<plist version="1.0">
<dict>
	<key>L2TP</key>
	<dict>
		<key>UserConfigs</key>
		<array>';
foreach($server as $url=>$name){
	$xml .= '
			<dict>
				<key>EAP</key>
				<dict/>
				<key>IPSec</key>
				<dict>
					<key>AuthenticationMethod</key>
					<string>SharedSecret</string>
					<key>ExportedSharedSecret</key>
					<data>
					'.$secret.'
					</data>
				</dict>
				<key>PPP</key>
				<dict>
					<key>AuthName</key>
					<string>'.$username.'</string>
					<key>AuthPasswordEncryption</key>
					<string>Keychain</string>
					<key>CommRemoteAddress</key>
					<string>'.$url.'</string>
					<key>ExportedPassword</key>
					<data>
					'.$password.'
					</data>
					<key>UserDefinedName</key>
					<string>'.$name.'</string>
				</dict>
			</dict>';
}
$xml .=	'
	   </array>
	</dict>
</dict>
</plist>';
}

if($_GET['action'] == "download"){
	header("Content-disposition: attachment; filename=privateinternetaccess.networkConnect");
	header("Content-type: application/xml");
	print $xml;
	exit;
}
?><!Doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>privateinternetaccess.com Mac OS X VPN config generator</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="wrapper">
		<h1>VPN config wizard<br/><small class="subheading">Generate Mac OS X VPN configuration file for privateinternetaccess.com customers</small></h1>
		<fieldset name="Generator">
		  <legend>Login Credentials</legend>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=make" method="post" name="data">
		<div class="row requiredRow">
			<label for="username">Username</label>
			<input id="username" name="username" type="text" class="required" value="<?php if(isset($_GET['action'])) echo $username; ?>" title="Username. This is a required field">
		</div>
		<div class="row requiredRow">
			<label for="password" id="Password-ariaLabel">Password</label>
			<input id="password" name="password" type="text" class="required" value="<?php if(isset($_GET['action'])) echo $password; ?>" title="Password. This is a required field">
		</div>
		<div class="row">
			<label for="secret" id="Secret-ariaLabel">Shared Secret</label>
			<input id="secret" name="secret" type="text" class="required" value="<?php if(isset($_GET['action'])) echo $secret; ?>" title="Secret. This is a required field">
		</div>
		<div class="row" style="margin: 5px;">
			<input type="submit" value="Generate">
		</div>
	</form>
		<small>I'm currently unable to figure out how Apple encrypts passwords.<br/> 
		You have to set password and shared secret on your own after importing the configuration file.</small>
		<!--
		<small>Your credentials are not going to be sent anywhere except this script file.<br/>
		Check the code if you have security concerns.</small>
		-->
	</fieldset>
	<?php
	if(@$_GET['action'] == "make"){
		echo '<br/><textarea rows="20" cols="100">'.$xml.'</textarea>';	
		echo '<br/><form method ="post" action="'.$_SERVER['PHP_SELF'].'?action=download">
			<input type="hidden" id="username" value="'.$username.'">
			<input type="hidden" id="password" value="'.$password.'">
			<input type="hidden" id="secret" value="'.$secret.'">
			<label for="dl" style="margin-left: 6px;">download as file (ready to import)</label>
			<input type="submit" value="Download" id="dl" style="margin: 5px;">
		</form>';
	}
	?>
	<div class="push"></div>
</div>
<div class="footer">
	<p>Copyright &copy; 2014 Jannis Hutt &middot; Licensed under MIT License &middot; <a title="Project on GitHub" href="https://github.com/77u4/PIAVPNConfigGenerator">Project on GitHub</a></p>
</div>
</body>
</html>
