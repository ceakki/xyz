<?php

  /**
   * SolidOpenSSL
   *
   * OpenSSL handler class to guarantee proper usage of OpenSSL and with that high security.
   *
   */
  class SolidOpenSSL {

    /**
     * $method
     *
     * This encryption algorithm is resistant to any kind of attempts to crack other than brute force.
     * Brute force will work though as with any other encryption method,
     * but the result should take longer then the age of the universe to brute force.
     */
    public static $method   = 'aes-256-cbc';


    /**
     * $pasword
     *
     * Encryption password: Must be at least 13 characters long and have four types of characters.
     */
    public static $password = '^dS*&hR56hiJ78^aD%C7fr6%R7t6~';


    /**
     * $iv
     *
     * Initialisation vector: Must be 16 characters long.
     */
    public static $iv       = '*gfs%%tHKL87p90a';


    /**
     * SolidOpenSSL::set_password()
     *
     * Handler for the password variable.
     *
     * @syntax  SolidOpenSSL::set_password($string = '');
     * @param   string  $string    Password to use.
     */
    static public function set_password($string = '') {
      self::$password = $string;
    }


    /**
     * SolidOpenSSL::set_iv()
     *
     * Handler for the iv variable.
     *
     * @syntax  SolidOpenSSL::set_iv($string = '');
     * @param   string  $string    Intilisation vector to use.
     */
    static public function set_iv($string = '') {
      self::$iv = $string;
    }


    /**
     * SolidOpenSSL::encrypt()
     *
     * Encrypting.
     *
     * @syntax  SolidOpenSSL::encrypt($string = false);
     * @param   string  $string    String to encrypt.
     * @return  string  Encrypted string.
     */
    static public function encrypt($string = false) {
      // Raise error if no string provided
      if(empty($string))
       trigger_error('No string to encrypt provided', E_USER_ERROR);


      // Raise error if no password provided
      if(empty(self::$password))
       trigger_error('No encryption password provided', E_USER_ERROR);


      // Raise error if password is not string enough
      if(!preg_match('/^(((?=.*[a-z])(?=.*[A-Z])(?=.*[\d])(?=.*[\W]))).{13,99}$/', self::$password))
       trigger_error('Encryption password provided is not strong enough', E_USER_ERROR);


      // Raise error if no initialisation vector provided
      if(empty(self::$iv))
       trigger_error('No initialisation vector provided', E_USER_ERROR);


      // Raise error if initialisation vector provided is not 16 bytes
      if(mb_strlen(self::$iv, '8bit') != 16)
       trigger_error('Initialisation vector provided should be 16 bytes', E_USER_ERROR);


      // Encrypt and return
      return openssl_encrypt($string, self::$method, self::$password, false, self::$iv);
    }



    /**
     * SolidOpenSSL::decrypt()
     *
     * Decrypting. Not really necessary but here for consistency.
     *
     * @syntax  SolidOpenSSL::decrypt($string = false);
     * @param   string  $string    Encrypted string.
     * @return  string  Decrypted string.
     */
    static public function decrypt($string = '') {
      // Raise error if no string provided
      if(empty($string))
       trigger_error('No string to decrypt provided', E_USER_ERROR);


      // Raise error if no password provided
      if(empty(self::$password))
       trigger_error('No encryption password provided', E_USER_ERROR);


      // Raise error if no initialisation vector provided
      if(empty(self::$iv))
       trigger_error('No initialisation vector provided', E_USER_ERROR);


      // Decrypt and return
      return openssl_decrypt($string, self::$method , self::$password, false, self::$iv);
    }
  }
