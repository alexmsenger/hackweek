<?php

class Session {
  public static function init() {
    if(session_id() == '') {
      session_start();
      session_set_cookie_params(0, SESSION_PATH, SESSION_DOMAIN, SESSION_SECURE, HTTPONLY);
    }
  }

  public static function destroy() {
    session_destroy();
  }
}
