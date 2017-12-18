<?php

  require 'connect.php';
  include 'queries.php';

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
  if (!isset($_REQUEST['format'])) {$format = '03';}
  if (!isset($_REQUEST['debug'])) {$debug = 0;}
  if (!isset($_REQUEST['error'])) {$error = 0;}

  $id = $_REQUEST['id'];        //customer id
  $p_id = $_REQUEST['pid'];       //product id
  $qtype = $_REQUEST['qtype'];  //m=media, b=media & text
  $ftype = $_REQUEST['ftype'];   //type of image (ONIX) 04=cover 06=thumb 07=full
  $format = $_REQUEST['format'];   //
  $debug = $_REQUEST['debug'];  // debug messages 0|1
  $error = $_REQUEST['error'];  // error parameter
 
  if ($error != 0) {
    function error() {
      header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
      echo '<!DOCTYPE html>';
      echo '<html><head><title>404 Not Found</title></head>';
      echo '<body><center><h1>404 Not Found</h1></center></body>';
      echo '</html>';
      exit();
    }
  }

  //remove unnecessary characters
  $p_id = str_replace('-', '', $p_id);
 
  if (!ctype_alnum($id) or !ctype_alnum($p_id)) {
    if ($debug) {error_log('DEBUG: id/pid not alphanumeric ' . $id . ' ' . $p_id); }
    echo '<!DOCTYPE html>';
    echo '<html><head><title>400 Bad Request</title></head>';
    echo '<body><center><h1>400 Bad Request</h1></center></body>';
    echo '</html>';
    exit();
  }

  //check if product exists

  $product_query = $conn->query("SELECT category_id FROM product WHERE proweb_id = '$p_id'") or die(mysql_error());
  if ($product = mysqli_fetch_array($product_query)) { $iidee = $product['category_id']; }
 
  if (!isset($iidee)) {
    if ($debug) {error_log('DEBUG: product not found ' . $p_id);}
    if ($error == 1) {error();}

    $img_not_available = 'kuvaa_ei_saatavilla.png';
    header('Content-Type: image/png');
    $eioo = new SimpleImage();
    $eioo->load($img_not_available);
    $eioo->resizeToWidth(80);
    $eioo->output();
    exit();
  }

  // check customer licensing
 
  $license_query = $conn->query("SELECT pwcategory_id FROM license WHERE pwcategory_id = '$iidee' AND accno = '$accno'") or die(mysql_error());
  if ($license = mysqli_fetch_array($license_query)) { $cat_id = $license['pwcategory_id']; }
  if(!isset($cat_id)) {
    if ($debug) {error_log('DEBUG: license not found ' . $id . ' ' . $iidee); }
    if ($error == 1) {error();}
    $img_not_available = 'kuvaa_ei_saatavilla.png';
    header('Content-Type: image/png');
    $eioo = new SimpleImage();
    $eioo->load($img_not_available);
    $eioo->resizeToWidth(80);
    $eioo->output();
    exit();
  }

  //call image type function with URL parameter
  queries->fset($ftype);

  //call query type function with URL parameter
  queries->aqset($qtype);      

?>
