<?php
  require 'queries.php';
  require 'connect.php';

  //check if mandatory parameters are set

  if (!isset($_REQUEST['id'], $_REQUEST['pid'])) {

  //header($_SERVER['PHP_SELF']);
    echo '<!DOCTYPE html>';
    echo '<html><head><title>400 Bad Request</title></head>';
    echo '<body><center><h1>400 Bad Request</h1></center></body>';
    echo '</html>';
    exit();
  }

  //check if optional parameters are set, if not set standard values

  if (!isset($_REQUEST['qtype'])) {$qtype = 'm';}
  if (!isset($_REQUEST['ftype']))  {$ftype = '04';}
  if (!isset($_REQUEST['format'])) {$format = '03';}
  if (!isset($_REQUEST['debug'])) {$debug = 0;}
  if (!isset($_REQUEST['error'])) {$error = 0;}

  $req = new Queries;

  //set URL parameters into variables

  $id = $_REQUEST['id'];        //customer id
  $p_id = $_REQUEST['pid'];       //product id
  $qtype = $_REQUEST['qtype'];  //m=media, b=media & text
  $ftype = $_REQUEST['ftype'];   //type of image (ONIX) 04=cover 06=thumb 07=full
  $format = $_REQUEST['format'];   //
  $debug = $_REQUEST['debug'];  // debug messages 0|1
  $error = $_REQUEST['error'];  // error parameter

  //call functions with given parameters

  $req->account_check();
  $req->alnum_check($p_id);
  $req->product_check($p_id);
  $req->licence_check();
  $req->fset($ftype);
  $req->qset($qtype);
  $req->error_is_set($error);
?>
