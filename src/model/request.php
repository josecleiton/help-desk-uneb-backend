<?php

class Request {
  static public function getAuthToken() {

    $bearerToken = apache_request_headers()["Authorization"];
    if(!$bearerToken) {
      return false;
    }
    return substr($bearerToken, strlen("Bearer "));
  }
}

?>