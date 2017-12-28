<?php
  require 'queries.php';
  require 'connect.php';

  if (!isset($_REQUEST['qtype'])) {$qtype = 'm';}
  if (!isset($_REQUEST['ftype']))  {$ftype = '04';}
  if (!isset($_REQUEST['format'])) {$format = '03';}
  if (!isset($_REQUEST['debug'])) {$debug = 0;}
  if (!isset($_REQUEST['error'])) {$error = 0;}

  $req = new Queries;

  $id = $_REQUEST['id'];        //customer id
  $p_id = $_REQUEST['pid'];       //product id
  $qtype = $_REQUEST['qtype'];  //m=media, b=media & text
  $ftype = $_REQUEST['ftype'];   //type of image (ONIX) 04=cover 06=thumb 07=full
  $format = $_REQUEST['format'];   //
  $debug = $_REQUEST['debug'];  // debug messages 0|1
  $error = $_REQUEST['error'];  // error parameter

  $req->account_check();
  $req->product_check($p_id);
  $req->licence_check();
  $req->fset($ftype);
  $req->qset($qtype);
?>
