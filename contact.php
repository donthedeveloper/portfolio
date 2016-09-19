<?php

// TO DO - USE FILTER_VAR INSTEAD OF FILTER_INPUT
// ^^ This will let us easily pass filtered data back into the fields if they get any errors
// ALSO TO DO - FILTER OUT FOR HEADER INJECTION - THEN USE HEADERS

// ini_set('display_errors', 'On');

// CLASSES //
include('classes/ValidateInput.php');
$validateInput = new ValidateInput();


// FUNCTIONS //
function getErrorMessage($errorCode) {
  switch ($errorCode) {
    case "empty-name":
      $errorMessage = "Please fill out your name.";
      break;
    case "empty-email":
      $errorMessage = "Please fill out your email.";
      break;
    case "empty-message":
      $errorMessage = "What would you like to say?";
      break;
		case "invalid-email":
			$errorMessage = "Please enter a valid email address.";
			break;
  }
	return $errorMessage;
}


if ($_POST['submit']) {
	
	$formName = $_POST['name'];
	$formEmail = $_POST['email'];
	$formMessage = $_POST['message'];

	// REQUIRED CONFIG FOR INPUT VALIDATION
	$requiredArray = array
		(
			'name' => true,
			'email' => true,
			'message' => true
		);

	$inputArray = array
		(
			'name' => $_POST['name'],
			'email' => $_POST['email'],
			'message' => $_POST['message']
		);
	
	$emailInputName = 'email';
	$validatedEmptyInput = TRUE;
	$validatedEmailInput = TRUE;
	
	// RUN VALIDATION METHODS
	$validatedEmptyInput = $validateInput->validateEmptyInput($inputArray, $requiredArray);
	
	if ($validatedEmptyInput['email']) {
		$validatedEmailInput = $validateInput->validateEmail($emailInputName);
	}
	
	// RUN ERROR MESSAGE BUILDER
	$errorArray = array();
	
	foreach ($validatedEmptyInput as $inputName => $value) {
		if (!$value) {
			$errorCode = "empty-$inputName";
			$errorArray[$inputName] = getErrorMessage($errorCode);
		}
	}
	
	if (!$validatedEmailInput) {
		$errorCode = "invalid-$emailInputName";
		$errorArray[$emailInputName] = getErrorMessage($errorCode); // this line isnt assigning proper key to value pair
	}
	
	// SUBMIT EMAIL IF NOTHING IS IN ERROR ARRAY
	if (!$errorArray) {
	// 	I STILL NEED TO ESCAPE CHARACTERS BELOW
		$to = "donhansen347@gmail.com";
		$fromEmail = $_POST['email'];
		$fromName = $_POST['name'];
		$subject = "Portfolio - Contact";
		$message = "From $fromName <$fromEmail>:";
		$message .= "\r\n";
		$message .= "\r\n";
		$message .= $_POST['message'];
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";  
		$headers .= 'From: '. $fromName . "\r\n";
		$headers .= 'Reply-To: Info <info@email.com>' . "\r\n";
		$headers .=  "X-Mailer: PHP/".phpversion();    
		
		mail($to, $subject, $message); // Currently does not work. Test on live server?
		
		unset($formName);
		unset($formEmail);
		unset($formMessage);
	}
	
}

?>

<!DOCTYPE>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="https://necolas.github.io/normalize.css/3.0.2/normalize.css">
  <link href='https://fonts.googleapis.com/css?family=Economica:400,700|Work+Sans:400,500,300' rel='stylesheet' type='text/css'>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/style.css">
	
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-79722569-1', 'auto');
		ga('send', 'pageview');
	</script>
	
</head>
<body>
  <header class="clearfix">
    <h1 class="name">Don Hansen <i class="material-icons">&#xE01D;</i></h1>
    <ul class="nav">
      <li><a href="index.html">Portfolio</a></li>
      <li><a href="about.html">About</a></li>
      <li><a href="contact.php" class="selected">Contact</a></li>
    </ul>
  </header>
  <div class="content">
		<h1 class="contentTitle">Get In Touch</h1>
    <section class="contactForm">
      <form action="" method="post">

<?php

if ( $_POST['submit'] && empty($errorArray) ) {
	echo "<p id='success'>Your message has been sent successfully!</p>";
}

?>	

          <label for="contactName">Name</label>
          <input type="text" name="name" id="Name" placeholder="Full Name" value="<?php echo $formName ?>" />
<?php

$inputName = 'name';
if ( array_key_exists($inputName, $errorArray) ) {
	echo "<p class='errorMessage'>" . $errorArray[$inputName] . "</p>"; 
}

?>
          <label for="contactEmail">Email</label>
          <input type="text" name="email" id="Email" placeholder="joe@gmail.com" value="<?php echo $formEmail ?>" />
<?php 

$inputName = 'email';
if ( array_key_exists($inputName, $errorArray) ) {
	echo "<p class='errorMessage'>" . $errorArray[$inputName] . "</p>"; 
}

?>
          <label for="contactMessage">Message</label>
          <textarea name="message" id="Message" placeholder="Hey, how are you?"><?php echo $formMessage ?></textarea>
<?php 

$inputName = 'message';
if ( array_key_exists($inputName, $errorArray) ) {
	echo "<p class='errorMessage'>" . $errorArray[$inputName] . "</p>"; 
}

?>
          <input type="submit" name="submit" value="Send" />
      </form>
    </section>
  </div>
	<footer>
		<div>
			<p>
				<a href="http://www.twitch.tv/donthedeveloper" target="_blank"><img src="img/icons/social/Twitch.png"></a>
				<a href="https://www.linkedin.com/in/don-hansen-72394264" target="_blank"><img src="img/icons/social/linkedin.svg"></a>
				<a href="https://twitter.com/DeveloperDonTV" target="_blank"><img src="img/icons/social/twitter.svg"></a>
				<a href="contact.php"><img src="img/icons/social/mail.svg"></a>
			</p>
		</div>
	</footer>
</body>






