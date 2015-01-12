<?php

define('PASSPHRASE', '********');
define('VALID_COOKIE', '********');
define('COOKIE_NAME', '_tk');
define('PWD_ARGUMENT', 't');

////////////////////////////////////////////////////////////////////////////////
//////////////////////////////  WRAPPING  //////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////

/**
 * Effettua il controllo per una password o per un cookie di password
 * 
 */
function bit_access_only_with_cookie_or_password() {
  if (isset($_GET[PWD_ARGUMENT])) {
    $pass = $_GET[PWD_ARGUMENT];
    if ($pass === PASSPHRASE) {
      bit_access_valid_pwd();
    } else {
      bit_access_invalid_pwd();
    }
  } else {
    if (bit_access_has_valid_cookie()) {
      bit_access_valid_cookie();
    } else {
      bit_access_invalid_cookie();
    }
  }
}

////////////////////////////////////////////////////////////////////////////////
//////////////////////////  GESTIONE DELLE ACTIONS  ////////////////////////////
////////////////////////////////////////////////////////////////////////////////

/**
 * Azione da effettuare nel caso in cui la password inserita sia corretta
 * 
 * Setta il cookie ed effettua un redirect verso la pagina richiesta
 * 
 */
function bit_access_valid_pwd() {
  bit_access_set_cookie();
  bit_access_redirect();
}

/**
 * Azione da effettuare in caso di password non corretta
 * 
 * Restituisce un 403 Forbidden
 * 
 */
function bit_access_invalid_pwd() {
  header('HTTP/1.0 403 Forbidden');
  echo 'Sorry... This page is forbidden (P)';
  die();
}

/**
 * Azione da effettuare quando è presente il cookie
 * 
 * Mostra correttamente la pagina richiesta
 * 
 */
function bit_access_valid_cookie() {
  /**
   * Go ahead
   */
//  echo "Eccoci qui! Ben fatto!";
//  die();
}

/**
 * Azione da effettuare se non è presente il cookie
 * Restituisce un 403 Forbidden
 */
function bit_access_invalid_cookie() {
  header('HTTP/1.0 403 Forbidden');
  die(bit_include_template("errors/403", FALSE));
}

////////////////////////////////////////////////////////////////////////////////
/////////////////////////////  REDIRECTING  ////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////

/**
 * Restituisce la url presso cui fare redirect in caso di passphrase corretta
 */
function bit_access_get_redirect() {
  unset($_GET[PWD_ARGUMENT]);
  $qq = isset($_GET['q']) ? "/" . $_GET['q'] : "";
  unset($_GET['q']);
  $qstring = "?" . http_build_query($_GET); //ricostruiamo la qstring
  $qstring = trim($qstring) === "?" ? "" : $qstring; //ricostruiamo la qstring
  return "http://" . $_SERVER['SERVER_NAME'] . $qq . $qstring;
}

/**
 * Effettua un redirect tramite HEADER
 * 
 */
function bit_access_redirect() {
  header("Location: " . bit_access_get_redirect());
  die();
}

////////////////////////////////////////////////////////////////////////////////
//////////////////////////  GESTIONE DEI COOKIES  //////////////////////////////
////////////////////////////////////////////////////////////////////////////////

/**
 * Restituisce TRUE se il cookie settato è corretto
 * 
 * @return type
 */
function bit_access_has_valid_cookie() {
  return bit_access_get_cookie() ? bit_access_get_cookie() === VALID_COOKIE : FALSE;
}

/**
 * Restituisce il valore del cookie di accesso
 * 
 * @return type
 */
function bit_access_get_cookie() {
  return isset($_COOKIE[COOKIE_NAME]) ? $_COOKIE[COOKIE_NAME] : FALSE;
}

/**
 * Setta il cookie corretto per visualizzare la pagina
 * 
 */
function bit_access_set_cookie() {
  setcookie(
          COOKIE_NAME, VALID_COOKIE, time() + (10 * 365 * 24 * 60 * 60), '/', $_SERVER['SERVER_NAME']
  );
}

