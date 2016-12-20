<?php

class Auth {

  static function API(User $user, $request) {
    $headers = getAllHeaders();

    //Check that there is an API Key given
    if (!array_key_exists('apiKey', $request) && !array_key_exists('apiKey', $headers)) {
      throw new Exception('No API Key provided');
      return FALSE;
    }
    else {
      $apiKey = array_key_exists('apiKey', $headers) ? $headers['apiKey'] : $request['apiKey'];
    }

    //check that the API key matches the origin
    $origin = $_SERVER['HTTP_ORIGIN'];
    if (!Auth::verifyAPIkey($apiKey, $origin)) {
      throw new Exception('Invalid API Key');
      return FALSE;
    }

    //check that there is a token
    if(!array_key_exists('token', $request) && !array_key_exists('token', $headers)) {
      throw new Exception('No API Token provided');
      return FALSE;
    }
    else {
      $token = array_key_exists('token', $headers) ? $headers['token'] : $requesr['token'];
    }

    //check that the token matches the User
    if(!$user->get('token', $token)) {
      throw new Exception('Invalid User Token');
      return FALSE;
    }
  }

  static function verifyAPIkey($key, $origin) {
    return TRUE;
  }

}
