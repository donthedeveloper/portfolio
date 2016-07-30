<?php

ini_set('display_errors', 'On');

include('classes/ValidateInput.php');

$validateInputs = new ValidateInput();

$requiredArray = array
	(
		'Name' => true,
		'Email' => true,
		'Message' => true
	);

$inputArray = array
  (
    'Name' => 'Taylor	Duncan',
    'Email' => '',
    'Message' => ''
  );

print_r( $validateInputs->validateEmptyInput($inputArray, $requiredArray) );

echo "<br /><br />";

if ($_POST['email']) {
  print_r( $validateInputs->validateEmail('email') );
}

?>

<form action="" method="post">
  <input type="text" name="email">
  <input type="submit">
</form>