<?php

$gtwid = $_POST['wid'];
$redirect = $_POST["redirect"];
$hsurl = $_POST["hsurl"];
if (!isset($_POST['submit'])) {

?>

<html>
<head>

<title>GTW/HubSpot Integration</title>
</head>

<body>
<p>Integrate your GoToWebinar registration form with HubSpot</p>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<p>GoToWebinar Webinar ID:&nbsp;&nbsp;<input type="text" size="30" name="wid"><br /></p>
<p>HubSpot API post URL:&nbsp;&nbsp;<input type="password" size="30" name="hsurl"><br /></p>
<p>Thank You page URL to re-direct to:&nbsp;&nbsp;<input type="text" size="15" name="redirect"><br /></p>
<p><input type="submit" value="Generate Form HTML" name="submit"><br />
</form><br />

<?php

}

else {
	echo "Please use this form HTML code for your webinar registration.<br>Anyone who fills this out will be registered for your webinar and registered as a lead in HubSpot.";
	echo "<br>";
	echo "<br>";
	echo htmlspecialchars('
	<form method="get" action="http://parallelstrategies.com/scripts/gtw-process.php">
	First Name: <input name="firstName" size="40" type="text" />
	Last Name: <input name="lastName" size="40" type="text" />
	Email: <input name="email" size="40" type="text" />
	<input name="WebinarKey" type="hidden" value=' .$gtwid. ' />
	<input name="Form" type="hidden" value="webinarRegistrationForm" />
	<input name="Template" type="hidden" value="https://www1.gotomeeting.com/en_US/island/webinar/registration.tmpl" />
	<input type="submit" value="Submit" />
	</form>');

}

?>

</body>
</html>