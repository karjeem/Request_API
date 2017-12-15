<?php

  require 'connect.php';

  $debug = 0;

  if (!isset($_REQUEST['id'], $_REQUEST['pid'])) {
    if ($debug) {error_log('DEBUG: no id/pid ' . );}

  //header($_SERVER['PHP_SELF']);
    echo '<!DOCTYPE html>';
    echo '<html><head><title>400 Bad Request</title></head>';
    echo '<body><center><h1>400 Bad Request</h1></center></body>';
    echo '</html>';
    exit();
  }

  if (!isset($_REQUEST['qtype'])) {$qtype = 'm';}
  if (!isset($_REQUEST['ftype']))  {$ftype = '04';}
  if (!isset($format)) {$format = '03';}

  $id = $_REQUEST['id'];        //customer id
  $p_id = $_REQUEST['pid'];       //product id
  $qtype = $_REQUEST['qtype']; }  //m=media, b=media & text
  $ftype = $_REQUEST['ftype']; }  //type of image (ONIX) 04=cover 06=thumb 07=full
  if (isset($_REQUEST['format'])) {$format = $_REQUEST['format']; }   //
  if (isset($_REQUEST['debug'])) {$debug = $_REQUEST['debug']; }  // debug messages 0|1
  if (isset($_REQUEST['error'])) {$error = $_REQUEST['error']; }

  if(!isset($error)) {$error = 0;}
 
    if ($error != 0) {
      function error() {
        header(' ', true, 404);
        echo '<!DOCTYPE html>';
        echo '<html><head><title>404 Not Found</title></head>';
        echo '<body><center><h1>404 Not Found</h1></center></body>';
        echo '</html>';
        exit();
      }
    }

?>
