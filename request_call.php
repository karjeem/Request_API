<?php
  require 'queries.php';
  require 'connect.php';

  if (!isset($_REQUEST['qtype'])) {$qtype = 'm';}
  if (!isset($_REQUEST['ftype']))  {$ftype = '04';}
  if (!isset($_REQUEST['format'])) {$format = '03';}
  if (!isset($_REQUEST['debug'])) {$debug = 0;}
  if (!isset($_REQUEST['error'])) {$error = 0;}

  $req = new Queries;

  $req->product_check();
  $req->licence_check();
  $req->fset();
  $req->qset();
?>
