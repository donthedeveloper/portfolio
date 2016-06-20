<?php

// CONFIG START

// Names of Required Fields
$requiredArray = array
	(
		'Name' => true, 
		'Email' => FILTER_VALIDATE_EMAIL, 
		'Message' => true
	);

// echo $requiredArray['Email'];

function getErrorMessage($errorCode) {
  switch ($errorCode) {
    case "emptyName":
      $errorMessage = "Please fill out your name.";
      break;
    case "emptyEmail":
      $errorMessage = "Please fill out your email.";
      break;
    case "emptyMessage":
      $errorMessage = "What would you like to say?";
      break;
		case "invalidEmail":
			$errorMessage = "Please enter a valid email address.";
			break;
  }
	return $errorMessage;
}

function validateInput($inputName, $requiredArray) {
	// if input is empty
	if (empty($_POST[$inputName])) {
		// return that it is empty
		return getErrorMessage("empty" . $inputName);
		// if input is not empty
	} elseif (!empty($_POST[$inputName])) {
		// if array value does not have a php validation
		if ($requiredArray[$inputName] !== true) {
			// validate input
			$filterInput = filter_input(INPUT_POST, $inputName, FILTER_VALIDATE_EMAIL);
			
			if ($filterInput === false) {
				return getErrorMessage("invalid" . $inputName);
			}
		} elseif ($filterInput !== false) {
			return true;
		}
	}
}

function submitPressed() {
	if ($_POST['submit']) {
		return true;
	} else {
		return false;
	}
}

if (submitPressed() && validateInput("Email", $requiredArray)) {
	// I STILL NEED TO ESCAPE CHARACTERS BELOW
// 	mail($_POST['Email'], 'Portfolio Contact Form', $_POST['Message']);
}

?>

<!DOCTYPE>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="https://necolas.github.io/normalize.css/3.0.2/normalize.css">
  <link href='https://fonts.googleapis.com/css?family=Economica:400,700|Work+Sans:400,500,300' rel='stylesheet' type='text/css'>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
  <header class="clearfix">
    <h1 class="name">Don Hansen <i class="material-icons">&#xE01D;</i></h1>
    <ul class="nav">
      <li><a href="index.html">Portfolio</a></li>
      <li><a href="http://blog.donhansen.me">Blog</a></li>
      <li><a href="about.html">About</a></li>
      <li><a href="contact.php" class="selected">Contact</a></li>
    </ul>
  </header>
  <div class="content">
		<h1 class="contentTitle">Get In Touch</h1>
    <section class="contactForm">
      <form action="" method="post">
<!-- 				<i class="material-icons md-36">&#xE0BE;</i> -->
      <!--   <fieldset>
          <legend>Your basic info</legend> -->
          <label for="contactName">Name</label>
          <input type="text" name="Name" id="Name" placeholder="Full Name" value="<?php echo $_POST["Name"]; ?>" />
<?php 
	if (submitPressed() === true && validateInput("Name", $requiredArray) !== true) {
		echo "<p class='errorMessage'>" . validateInput("Name", $requiredArray) . "</p>"; 
	}
?>
          <label for="contactEmail">Email</label>
          <input type="text" name="Email" id="Email" placeholder="joe@gmail.com" value="<?php echo $_POST["Email"]; ?>" />
<?php 
	if (submitPressed() && validateInput("Email", $requiredArray) !== null) {
		echo "<p class='errorMessage'>" . validateInput("Email", $requiredArray) . "</p>"; 
	}
?>
          <label for="contactMessage">Message</label>
          <textarea name="Message" id="Message" placeholder="Hey, how are you?"><?php echo $_POST["Message"]; ?></textarea>
<?php 
	if (submitPressed() && validateInput("Message", $requiredArray) !== true) {
		echo "<p class='errorMessage'>" . validateInput("Message", $requiredArray) . "</p>"; 
	}
?>
          <input type="submit" name="submit" value="Send" />
      </form>
    </section>
  </div>
	<footer>
		<div>
			<p>
				<a href="#" target="_blank"><img src="img/icons/social/Twitch.png"></a>
				<a href="https://www.linkedin.com/in/don-hansen-72394264" target="_blank"><img src="img/icons/social/linkedin.svg"</a>
				<a href="https://twitter.com/donhansen347" target="_blank"><img src="img/icons/social/twitter.svg"</a>
				<a href="contact.php"><img src="img/icons/social/mail.svg"</a>
			</p>
		</div>
	</footer>
</body>






