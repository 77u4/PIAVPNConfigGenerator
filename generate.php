<?php
/**
  * privateinternetaccess.com Mac OS X VPN config generator
  * Copyright (c) 2014 Jannis Hutt
  * Licensed under MIT License
**/

if(@$_GET['action'] == 'make' OR @$_GET['action'] == 'download'){

//VARS

//From Form
$username = @$_POST['username'];
$password = @$_POST['password'];
$secret   =	@$_POST['secret'];

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
	print urldecode($_POST['document']);
	exit;
}
?>
<!Doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>privateinternetaccess.com VPN config generator for Mac OS X</title>
</head>
<body>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=make" method="post" name="data">
<div class="row requiredRow">
	<label for="username" id="Username-ariaLabel">Username</label>
	<input id="username" name="username" type="text" aria-labelledby="Username-ariaLabel" class="required" title="Username. This is a required field">
</div>
<div class="row requiredRow">
	<label for="password" id="Password-ariaLabel">Password</label>
	<input id="password" name="password" type="text" aria-labelledby="Password-ariaLabel" class="required" title="Password. This is a required field">
</div>
<div class="row requiredRow">
	<label for="secret" id="Secret-ariaLabel">Shared Secret</label>
	<input id="secret" value="mysafety" name="secret" type="text" aria-labelledby="Secret-ariaLabel" class="required" title="Secret. This is a required field">
</div>
<div class="row">
<input type="submit" value="Generate">
</div>
</form>
</body>
</html>
