<?php

  // Example usage
  header('Content-type: text/plain;');

  // String
  $string   = 'L0n$gPa~w*¬d!';

  // Encryption password and IV
  $password = '^dS*&hR56hiJ78^aD%C7fr6%R7t6~';
  $iv       = md5('L0n$gPa~w*¬d!', true);
  
  // Encrypting
  $encrypted = solid_openssl_encrypt($string, $password, $iv);
  var_dump($encrypted);

  // Decrypting
  $decrypted = solid_openssl_decrypt($encrypted, $password, $iv);
  var_dump($decrypted);



  /**
   * solid_openssl_encrypt()
   *
   * OpenSSL handler function that will guarantee proper usage of openssl_encrypt to ensure high security.
   *
   * @syntax  solid_openssl_encrypt($string = false, $password = false, $iv = false);
   * @param   string  $string    String to encrypt.
   * @param   string  $password  Encryption password.
   * @param   string  $iv        Initialization vector.
   * @return  string  Encrypted string.
   */
  function solid_openssl_encrypt($string = false, $password = false, $iv = false) {
    // Raise error if no string provided
    if(empty($string))
     trigger_error('No string to encrypt provided', E_USER_ERROR);


    // Raise error if no password provided
    if(empty($password))
     trigger_error('No encryption password provided', E_USER_ERROR);


    // Raise error if password is not string enough
    if(!preg_match('/^(((?=.*[a-z])(?=.*[A-Z])(?=.*[\d])(?=.*[\W]))).{13,99}$/', $password))
     trigger_error('Encryption password provided is not strong enough', E_USER_ERROR);


    // Raise error if no initialisation vector provided
    if(empty($iv))
     trigger_error('No initialisation vector provided', E_USER_ERROR);


    // Raise error if initialisation vector provided is not 16 bytes
    if(mb_strlen($iv, '8bit') != 16)
     trigger_error('Initialisation vector provided should be 16 bytes', E_USER_ERROR);


    // This encryption algorithm is resistant to any kind of attempts to crack other than brute force.
    // Brute force will work though as with any other encryption method,
    // but the result should take longer then the age of the universe to brute force.
    $method = 'aes-128-cbc';


    // Encrypt and return
    return openssl_encrypt($string, $method, $password, false, $iv);
  }



  /**
   * solid_openssl_decrypt()
   *
   * OpenSSL handler for decryption. Not really necessary but here for consistency.
   *
   * @syntax  solid_openssl_decrypt($string = false, $password = false, $iv = false);
   * @param   string  $string    Encrypted string.
   * @param   string  $password  Encryption password.
   * @param   string  $iv        Initialization vector.
   * @return  string  Decrypted string.
   */
  function solid_openssl_decrypt($string = '', $password = false, $iv = false) {
    // Raise error if no string provided
    if(empty($string))
     trigger_error('No string to decrypt provided', E_USER_ERROR);


    // Raise error if no password provided
    if(empty($password))
     trigger_error('No encryption password provided', E_USER_ERROR);


    // Raise error if no initialisation vector provided
    if(empty($iv))
     trigger_error('No initialisation vector provided', E_USER_ERROR);


    // Method
    $method = 'aes-128-cbc';

    // Decrypt and return
    return openssl_decrypt($string, $method , $password, false, $iv);
  }
