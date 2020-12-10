<?php
namespace App\Helpers;

class LoginHelper
{
  /**
  * Escape Number From String
  */
  public static function get_username($token)
  {
    return explode('***', base64_decode($token))[0];
  }
  
  public static function get_password($token)
  {
    return explode('***', base64_decode($token))[2];
  }

}
