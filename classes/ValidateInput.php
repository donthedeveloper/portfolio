<?php

class ValidateInput {
  
  // returns array of passed(true) & failed(false) inputs
  public function validateEmptyInput($inputArray, $requiredArray) {
    
    $validatedInputs = array();
    
    foreach($inputArray as $inputName => $inputValue) {
      // if the current input being looped through is required
      if ($requiredArray[$inputName]) {
        if ( empty($inputValue) ) {
          $validatedInputs[$inputName] = FALSE;
        }
        else {
          $validatedInputs[$inputName] = TRUE;
        }
      }
    }
    
    return $validatedInputs;
    
  }
  
  public function validateEmail($inputName) {
    
    $validateEmail = filter_input(INPUT_POST, $inputName, FILTER_VALIDATE_EMAIL);
    
    if ($validateEmail === FALSE) {
      return FALSE;
    }
    else {
      return TRUE;
    }
    
  }
  
}