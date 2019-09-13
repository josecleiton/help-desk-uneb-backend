<?php

class Request
{
  static public function getAuthToken()
  {

    $bearerToken = apache_request_headers()["Authorization"];
    // var_dump($bearerToken);
    if (!$bearerToken) {
      return false;
    }
    return substr($bearerToken, strlen("Bearer "));
  }
}
